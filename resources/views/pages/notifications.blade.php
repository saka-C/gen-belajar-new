@extends('layouts.app')

@section('title', 'Notifikasi Transaksi - Gen Belajar')

@section('content')
<div class="bg-gray-50 min-h-screen pt-28 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <p class="text-sm font-semibold text-red-600 uppercase tracking-wide">Riwayat Donasi</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2">Notifikasi Transaksi</h1>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            @forelse ($donations as $donation)
                @php
                    $statusClass = match ($donation['payment_status']) {
                        'success' => 'bg-green-50 text-green-700 border-green-200',
                        'failed' => 'bg-red-50 text-red-700 border-red-200',
                        default => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    };
                @endphp

                <div class="p-5 sm:p-6 border-b border-gray-100 last:border-b-0">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5 justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                    {{ $donation['status_label'] }}
                                </span>
                                <span class="text-xs font-semibold text-gray-500">{{ $donation['date_label'] }}</span>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 truncate">{{ $donation['campaign_title'] }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Order ID: {{ $donation['transaction_id'] }}</p>
                            <p class="text-xl font-extrabold text-gray-900 mt-3">{{ $donation['amount_label'] }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                            @if ($donation['payment_status'] === 'success')
                                <button
                                    type="button"
                                    class="receipt-btn px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800 transition"
                                    data-donation-id="{{ $donation['donation_id'] }}"
                                >
                                    Lihat Resi
                                </button>
                                <button
                                    type="button"
                                    class="download-receipt-btn px-4 py-2 rounded-xl border border-gray-300 text-gray-800 text-sm font-semibold hover:bg-gray-50 transition"
                                    data-donation-id="{{ $donation['donation_id'] }}"
                                >
                                    Unduh PDF
                                </button>
                            @elseif ($donation['payment_status'] === 'pending')
                                <button
                                    type="button"
                                    class="resume-payment-btn px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition"
                                    data-resume-url="{{ $donation['resume_url'] }}"
                                    data-order-id="{{ $donation['transaction_id'] }}"
                                >
                                    Selesaikan Pembayaran
                                </button>
                            @else
                                <a
                                    href="{{ route('campaigns.show', $donation['campaign_id']) }}"
                                    class="px-4 py-2 rounded-xl border border-gray-300 text-gray-800 text-sm font-semibold hover:bg-gray-50 transition text-center"
                                >
                                    Donasi Ulang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center">
                    <h2 class="text-xl font-bold text-gray-900">Belum ada transaksi</h2>
                    <p class="text-sm text-gray-600 mt-2">Riwayat donasi Anda akan muncul setelah membuat transaksi.</p>
                    <a href="{{ route('program') }}" class="inline-flex mt-6 px-5 py-3 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                        Lihat Campaign
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div id="receipt-modal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Resi Donasi</h2>
            <button type="button" id="close-receipt-modal" class="w-9 h-9 rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50">x</button>
        </div>
        <div id="receipt-content" class="p-6 space-y-4">
            <div class="text-center pb-4 border-b border-dashed border-gray-300">
                <p class="text-sm font-semibold text-red-600">GEN BELAJAR</p>
                <p class="text-xs text-gray-500 mt-1">Bukti transaksi donasi</p>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Order ID</span>
                    <span id="receipt-order" class="font-semibold text-gray-900 text-right"></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Campaign</span>
                    <span id="receipt-campaign" class="font-semibold text-gray-900 text-right"></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Donatur</span>
                    <span id="receipt-donor" class="font-semibold text-gray-900 text-right"></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Metode</span>
                    <span id="receipt-method" class="font-semibold text-gray-900 text-right"></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Tanggal</span>
                    <span id="receipt-date" class="font-semibold text-gray-900 text-right"></span>
                </div>
                <div class="flex justify-between gap-4 pt-4 border-t border-gray-100">
                    <span class="text-gray-500">Nominal</span>
                    <span id="receipt-amount" class="font-extrabold text-gray-900 text-right"></span>
                </div>
            </div>
        </div>
        <div class="p-6 bg-gray-50 flex flex-col sm:flex-row gap-2 justify-end">
            <button type="button" id="download-modal-receipt" class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                Unduh PDF
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script
    src="{{ config('services.midtrans.snap_js_url') }}"
    data-client-key="{{ config('services.midtrans.client_key') }}"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const donations = @json($donations->keyBy('donation_id'));
    const csrfToken = '{{ csrf_token() }}';
    const refreshStatusUrl = '{{ route('donations.midtrans.status') }}';
    const modal = document.getElementById('receipt-modal');
    let selectedReceipt = null;

    document.querySelectorAll('.receipt-btn').forEach((button) => {
        button.addEventListener('click', () => openReceipt(button.dataset.donationId));
    });

    document.querySelectorAll('.download-receipt-btn').forEach((button) => {
        button.addEventListener('click', () => downloadReceipt(button.dataset.donationId));
    });

    document.querySelectorAll('.resume-payment-btn').forEach((button) => {
        button.addEventListener('click', async () => {
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Memproses...';

            try {
                const response = await fetch(button.dataset.resumeUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const data = await response.json();

                if (! response.ok) {
                    throw new Error(data.message || 'Pembayaran tidak dapat dilanjutkan.');
                }

                if (! window.snap || ! data.snap_token) {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }

                    throw new Error('Midtrans Snap belum siap. Muat ulang halaman lalu coba lagi.');
                }

                window.snap.pay(data.snap_token, {
                    onSuccess: async function() {
                        await refreshDonationStatus(data.order_id);
                        window.location.reload();
                    },
                    onPending: async function() {
                        await refreshDonationStatus(data.order_id);
                        window.location.reload();
                    },
                    onError: async function() {
                        await refreshDonationStatus(data.order_id);
                        window.location.reload();
                    },
                    onClose: function() {
                        button.disabled = false;
                        button.textContent = originalText;
                    },
                });
            } catch (error) {
                button.disabled = false;
                button.textContent = originalText;
                alert(error.message || 'Terjadi kesalahan saat melanjutkan pembayaran.');
            }
        });
    });

    document.getElementById('close-receipt-modal').addEventListener('click', closeReceipt);
    document.getElementById('download-modal-receipt').addEventListener('click', () => {
        if (selectedReceipt) {
            downloadReceipt(selectedReceipt.donation_id);
        }
    });
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeReceipt();
        }
    });

    function openReceipt(donationId) {
        selectedReceipt = donations[donationId];

        document.getElementById('receipt-order').textContent = selectedReceipt.transaction_id;
        document.getElementById('receipt-campaign').textContent = selectedReceipt.campaign_title;
        document.getElementById('receipt-donor').textContent = selectedReceipt.donor_name;
        document.getElementById('receipt-method').textContent = selectedReceipt.payment_method;
        document.getElementById('receipt-date').textContent = selectedReceipt.date_label;
        document.getElementById('receipt-amount').textContent = selectedReceipt.amount_label;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReceipt() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function downloadReceipt(donationId) {
        const donation = donations[donationId];
        const jsPdf = window.jspdf?.jsPDF;

        if (! jsPdf) {
            window.print();
            return;
        }

        const pdf = new jsPdf();
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(18);
        pdf.text('GEN BELAJAR', 20, 22);
        pdf.setFontSize(13);
        pdf.text('Resi Donasi', 20, 32);

        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(11);
        pdf.text(`Order ID: ${donation.transaction_id}`, 20, 48);
        pdf.text(`Campaign: ${donation.campaign_title}`, 20, 58);
        pdf.text(`Donatur: ${donation.donor_name}`, 20, 68);
        pdf.text(`Metode: ${donation.payment_method}`, 20, 78);
        pdf.text(`Tanggal: ${donation.date_label}`, 20, 88);

        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(16);
        pdf.text(`Nominal: ${donation.amount_label}`, 20, 106);
        pdf.setFontSize(11);
        pdf.text('Status: Transaksi Berhasil', 20, 118);

        pdf.save(`resi-${donation.transaction_id}.pdf`);
    }

    async function refreshDonationStatus(orderId) {
        await fetch(refreshStatusUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ order_id: orderId }),
        });
    }
});
</script>
@endpush
