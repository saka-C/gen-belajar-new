<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DonationNotificationController extends Controller
{
    public function index()
    {
        $donations = Donation::query()
            ->with('campaign')
            ->where('user_id', auth()->id())
            ->orderByDesc('donation_id')
            ->get()
            ->filter(function (Donation $donation) {
                if ($donation->payment_status !== 'pending') {
                    return true;
                }

                return ! Donation::query()
                    ->where('user_id', auth()->id())
                    ->where('campaign_id', $donation->campaign_id)
                    ->where('payment_status', 'pending')
                    ->where('donation_id', '>', $donation->donation_id)
                    ->exists();
            })
            ->map(function (Donation $donation) {
                $date = $this->dateFromTransactionId($donation->transaction_id);

                return [
                    'donation_id' => $donation->donation_id,
                    'campaign_id' => $donation->campaign_id,
                    'campaign_title' => $donation->campaign->title ?? 'Campaign',
                    'amount' => (float) $donation->amount,
                    'amount_label' => 'Rp '.number_format($donation->amount, 0, ',', '.'),
                    'payment_method' => $donation->payment_method ?: 'midtrans',
                    'transaction_id' => $donation->transaction_id,
                    'payment_status' => $donation->payment_status ?: 'pending',
                    'status_label' => $this->statusLabel($donation->payment_status),
                    'date_label' => $date?->format('d M Y H:i') ?? '-',
                    'donor_name' => $donation->is_anonymous
                        ? 'Anonim'
                        : ($donation->user->username ?? $donation->guest_name ?? 'Donatur'),
                    'resume_url' => route('donations.midtrans.resume', $donation),
                ];
            });

        return view('pages.notifications', compact('donations'));
    }

    private function dateFromTransactionId(string $transactionId): ?Carbon
    {
        if (! preg_match('/DON-\d+-(\d{14})-/', $transactionId, $matches)) {
            return null;
        }

        return Carbon::createFromFormat('YmdHis', $matches[1]);
    }

    private function statusLabel(?string $status): string
    {
        return match ($status) {
            'success' => 'Transaksi Berhasil',
            'failed' => 'Transaksi Gagal',
            default => 'Menunggu Pembayaran',
        };
    }
}
