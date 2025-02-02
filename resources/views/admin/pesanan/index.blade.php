@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Daftar Pesanan Masuk</h6>
                        </div>
                        <div class="table-responsive p-0">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-black-th">#</th>
                                        <th class="text-black-th">Nomor Pesanan</th>
                                        <th class="text-black-th">Nama Pelanggan</th>
                                        <th class="text-black-th">Tanggal</th>
                                        <th class="text-black-th">Total</th>
                                        <th class="text-black-th">Metode Pembayaran</th>
                                        <th class="text-black-th">Status</th>
                                        <th class="text-black-th">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pesanan as $key => $order)
                                        <tr>
                                            <td>{{ $pesanan->firstItem() + $key }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>{{ $order->formatted_total }}</td>
                                            <td class="text-capitalize">{{ $order->payment_method }}
                                                
                                            </td>
                                            <td>
                                                <span class="badge {{ $order->status_badgeAdmin }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                            <td class="d-flex align-items-center justify-content-center gap-2"
                                                style="height: 100%; min-height: 60px;">
                                                <div class="d-flex align-items-center justify-content-center gap-2"
                                                    style="width: 100%;">
                                                    <a href="{{ route('admin.pesanan.show', $order->order_number) }}"
                                                        class="btn btn-dark btn-sm">Detail</a>

                                                    @if ($order->payment_method === 'Cash on Delivery')
                                                        <form action="{{ route('admin.pesanan.updateStatus', $order->id) }}"
                                                            method="POST" id="statusForm-{{ $order->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status"
                                                                class="form-select form-select-sm status-select status-{{ $order->status }}"
                                                                onchange="if(confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')) { this.form.submit(); }">
                                                                <option value="pending"
                                                                    {{ $order->status === 'pending' ? 'selected' : '' }}
                                                                    class="status-bg-pending">Pending</option>
                                                                <option value="confirmed"
                                                                    {{ $order->status === 'confirmed' ? 'selected' : '' }}
                                                                    class="status-bg-confirmed">Konfirmasi</option>
                                                                <option value="processing"
                                                                    {{ $order->status === 'processing' ? 'selected' : '' }}
                                                                    class="status-bg-processing">Proses</option>
                                                                <option value="delivered"
                                                                    {{ $order->status === 'delivered' ? 'selected' : '' }}
                                                                    class="status-bg-delivery">Dikirim</option>
                                                                <option value="completed"
                                                                    {{ $order->status === 'completed' ? 'selected' : '' }}
                                                                    class="status-bg-completed">Selesai</option>
                                                            </select>
                                                        </form>
                                                    @endif

                                                    @if ($order->payment_method === 'transfer')
                                                        <form
                                                            action="{{ route('admin.pesanan.updateStatus', $order->id) }}"
                                                            method="POST" id="statusForm-{{ $order->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="status"
                                                                class="form-select form-select-sm status-select status-{{ $order->status }}"
                                                                onchange="if(confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')) { this.form.submit(); }">
                                                                <option value="awaiting payment"
                                                                    {{ $order->status === 'awaiting payment' ? 'selected' : '' }}
                                                                    class="status-bg-pending">Pending</option>
                                                                <option value="confirmed"
                                                                    {{ $order->status === 'confirmed' ? 'selected' : '' }}
                                                                    class="status-bg-confirmed">Konfirmasi
                                                                </option>
                                                                <option value="processing"
                                                                    {{ $order->status === 'processing' ? 'selected' : '' }}
                                                                    class="status-bg-processing">Proses</option>
                                                                <option value="delivered"
                                                                    {{ $order->status === 'delivered' ? 'selected' : '' }}
                                                                    class="status-bg-delivery">Dikirim</option>
                                                                <option value="completed"
                                                                    {{ $order->status === 'completed' ? 'selected' : '' }}
                                                                    class="status-bg-completed">Selesai</option>
                                                            </select>
                                                        </form>
                                                    @endif

                                                    {{-- @if($order->payment_method === 'transfer' && $order->status === 'pending')
                                                        <div class="d-flex gap-2">
                                                            <!-- Tombol Lihat Bukti Transfer -->
                                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#proofModal{{ $order->id }}">
                                                                <i class="bi bi-image"></i> Lihat Bukti
                                                            </button>
                                                            
                                                            <!-- Form Verifikasi -->
                                                            <form action="{{ route('orders.verify-payment', $order->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini?')">
                                                                    <i class="bi bi-check-circle"></i> Verifikasi
                                                                </button>
                                                            </form>

                                                            <!-- Form Tolak -->
                                                            <form action="{{ route('orders.reject-payment', $order->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                                                    <i class="bi bi-x-circle"></i> Tolak
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <!-- Modal Bukti Transfer -->
                                                        <div class="modal fade" id="proofModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Bukti Transfer - Order #{{ $order->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset('uploads/payment_proofs/' . $order->payment_proof) }}" 
                                                                             class="img-fluid" 
                                                                             alt="Bukti Transfer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif --}}

                                                    <form action="{{ route('admin.pesanan.destroy', $order->id) }}"
                                                        method="POST" class="mb-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Tidak ada pesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination yang diperbaiki -->
                            <div class="card-footer py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Info showing results -->
                                    <div class="text-sm text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ $pesanan->firstItem() }}</span>
                                        to
                                        <span class="font-medium">{{ $pesanan->lastItem() }}</span>
                                        of
                                        <span class="font-medium">{{ $pesanan->total() }}</span>
                                        results
                                    </div>

                                    <!-- Pagination links -->
                                    <div>
                                        {{ $pesanan->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .table td,
    .table th {
        vertical-align: middle !important;
        text-align: center !important;
        padding: 12px 8px !important;
        height: 60px !important;
    }

    /* Update button and form styles */
    .table .btn-sm {
        margin-bottom: 0 !important;
        padding: 0.25rem 0.5rem !important;
        height: 31px !important;
        min-width: 60px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

    }


    .table form {
        margin: 0;
        display: inline-flex !important;
        align-items: center !important;
    }



    .card-footer {
        background-color: #fff;
        border-top: 1px solid #dee2e6;
    }


    .status-select {
        min-width: 120px;
        height: 31px !important;
        padding: 2px 8px !important;
        font-size: 0.875rem !important;
    }

    /* Warna background untuk select berdasarkan status aktif */
    .status-pending {
        background-color: #fef3c7 !important;
        color: #92400e !important;
    }

    /* Tambahkan ini di bagian CSS Anda */
    .status-awaiting.payment {
        background-color: #fef3c7 !important;
        color: #92400e !important;
    }

    .status-confirmed {
        background-color: #e0f2fe !important;
        color: #075985 !important;
    }

    .status-processing {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
    }

    .status-delivered {
        background-color: #dcfce7 !important;
        color: #166534 !important;
    }

    .status-completed {
        background-color: #bbf7d0 !important;
        color: #15803d !important;
    }


    /* Warna background untuk options */
    .status-select option.status-bg-pending {
        background-color: #fef3c7 !important;
        color: #92400e !important;
    }

    .status-select option.status-bg-confirmed {
        background-color: #e0f2fe !important;
        color: #075985 !important;
    }

    .status-select option.status-bg-processing {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
    }

    .status-select option.status-bg-delivery {
        background-color: #dcfce7 !important;
        color: #166534 !important;
    }

    .status-select option.status-bg-completed {
        background-color: #bbf7d0 !important;
        color: #15803d !important;
    }

    .status-select:focus {
        border-color: #344767;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25);
    }
</style>
