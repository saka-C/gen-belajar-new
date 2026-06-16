<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DonationPaymentController extends Controller
{
    public function createSnapToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'campaign_id' => ['required', 'integer', 'exists:campaigns,campaign_id'],
            'amount' => ['required', 'integer', 'min:1000'],
            'guest_name' => ['nullable', 'string', 'max:100'],
            'is_anonymous' => ['nullable', 'boolean'],
        ]);

        $campaign = Campaign::query()
            ->where('campaign_id', $validated['campaign_id'])
            ->whereIn('status', ['active'])
            ->firstOrFail();

        $user = Auth::user();
        $guestName = trim((string) ($validated['guest_name'] ?? ''));

        $donation = DB::transaction(function () use ($campaign, $user, $guestName, $validated) {
            Campaign::query()
                ->where('campaign_id', $campaign->campaign_id)
                ->lockForUpdate()
                ->first();

            $donation = $user
                ? Donation::query()
                    ->where('user_id', $user->user_id)
                    ->where('campaign_id', $campaign->campaign_id)
                    ->where('payment_status', 'pending')
                    ->orderByDesc('donation_id')
                    ->first()
                : null;

            if ($donation) {
                $donation->update([
                    'amount' => $validated['amount'],
                    'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
                    'guest_name' => null,
                    'payment_method' => 'midtrans',
                ]);

                return $donation;
            }

            return Donation::create([
                'user_id' => $user?->user_id,
                'campaign_id' => $campaign->campaign_id,
                'amount' => $validated['amount'],
                'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
                'guest_name' => $user ? null : ($guestName ?: 'Donatur'),
                'payment_method' => 'midtrans',
                'transaction_id' => $this->generateOrderId($campaign->campaign_id),
                'payment_status' => 'pending',
            ]);
        });

        $snapResponse = $this->createMidtransSnapTransaction($donation->loadMissing(['campaign', 'user']), true);

        if ($snapResponse instanceof JsonResponse) {
            return $snapResponse;
        }

        return $this->snapResponse($snapResponse);
    }

    public function resumePayment(Donation $donation): JsonResponse
    {
        abort_if($donation->user_id !== Auth::id(), 403);
        abort_if($donation->payment_status !== 'pending', 422, 'Transaksi ini tidak menunggu pembayaran.');

        $snapResponse = $this->createMidtransSnapTransaction($donation->loadMissing(['campaign', 'user']), true);

        if ($snapResponse instanceof JsonResponse) {
            return $snapResponse;
        }

        return $this->snapResponse($snapResponse);
    }

    public function refreshStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => ['required', 'string', 'exists:donations,transaction_id'],
        ]);

        $donation = $this->syncDonationStatus($validated['order_id']);

        return response()->json([
            'order_id' => $donation->transaction_id,
            'payment_status' => $donation->payment_status,
        ]);
    }

    public function notification(Request $request): JsonResponse
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;

        if (! $orderId || ! $this->isValidSignature($payload)) {
            return response()->json(['message' => 'Invalid Midtrans notification.'], 403);
        }

        $donation = Donation::query()
            ->where('transaction_id', $orderId)
            ->firstOrFail();

        $donation->update([
            'payment_status' => $this->mapPaymentStatus(
                $payload['transaction_status'] ?? null,
                $payload['fraud_status'] ?? null
            ),
            'payment_method' => Str::limit($payload['payment_type'] ?? $donation->payment_method, 20, ''),
        ]);

        return response()->json(['message' => 'Notification processed.']);
    }

    private function syncDonationStatus(string $orderId): Donation
    {
        $donation = Donation::query()
            ->where('transaction_id', $orderId)
            ->firstOrFail();

        $response = Http::withBasicAuth((string) config('services.midtrans.server_key'), '')
            ->acceptJson()
            ->get(rtrim(config('services.midtrans.api_url'), '/')."/v2/{$orderId}/status");

        if ($response->successful()) {
            $donation->update([
                'payment_status' => $this->mapPaymentStatus(
                    $response->json('transaction_status'),
                    $response->json('fraud_status')
                ),
                'payment_method' => Str::limit($response->json('payment_type') ?? $donation->payment_method, 20, ''),
            ]);
        }

        return $donation->refresh();
    }

    private function generateOrderId(int $campaignId): string
    {
        do {
            $orderId = 'DON-'.$campaignId.'-'.now()->format('YmdHis').'-'.Str::upper(Str::random(6));
        } while (Donation::query()->where('transaction_id', $orderId)->exists());

        return $orderId;
    }

    private function createMidtransSnapTransaction(Donation $donation, bool $forceNewOrderId = false): Donation|JsonResponse
    {
        if ($forceNewOrderId) {
            $donation->update([
                'transaction_id' => $this->generateOrderId($donation->campaign_id),
                'snap_token' => null,
                'snap_redirect_url' => null,
            ]);
        }

        $donorName = $donation->guest_name ?: ($donation->user->username ?? 'Donatur Gen Belajar');
        $payload = [
            'transaction_details' => [
                'order_id' => $donation->transaction_id,
                'gross_amount' => (int) $donation->amount,
            ],
            'item_details' => [[
                'id' => (string) $donation->campaign_id,
                'price' => (int) $donation->amount,
                'quantity' => 1,
                'name' => Str::limit($donation->campaign->title, 45, ''),
            ]],
            'customer_details' => [
                'first_name' => Str::limit($donorName, 50, ''),
                'email' => $donation->user->email ?? null,
            ],
            'enabled_payments' => [
                'credit_card',
                'bank_transfer',
                'gopay',
                'shopeepay',
                'qris',
            ],
            'credit_card' => [
                'secure' => config('services.midtrans.is_3ds'),
            ],
        ];

        $response = Http::withBasicAuth((string) config('services.midtrans.server_key'), '')
            ->acceptJson()
            ->post(config('services.midtrans.snap_url'), $payload);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal menghubungkan ke Midtrans.',
                'details' => $response->json(),
            ], 502);
        }

        $donation->update([
            'snap_token' => $response->json('token'),
            'snap_redirect_url' => $response->json('redirect_url'),
        ]);

        return $donation->refresh();
    }

    private function snapResponse(Donation $donation): JsonResponse
    {
        return response()->json([
            'snap_token' => $donation->snap_token,
            'redirect_url' => $donation->snap_redirect_url,
            'order_id' => $donation->transaction_id,
            'donation_id' => $donation->donation_id,
        ]);
    }

    private function mapPaymentStatus(?string $transactionStatus, ?string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'challenge' ? 'pending' : 'success',
            'settlement' => 'success',
            'pending' => 'pending',
            'deny', 'cancel', 'expire', 'failure', 'refund', 'partial_refund' => 'failed',
            default => 'pending',
        };
    }

    private function isValidSignature(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signature = $payload['signature_key'] ?? '';

        $expected = hash(
            'sha512',
            $orderId.$statusCode.$grossAmount.config('services.midtrans.server_key')
        );

        return hash_equals($expected, $signature);
    }
}
