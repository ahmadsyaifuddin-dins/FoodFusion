@extends('layouts.app-admin')

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <!-- Card Monitoring Aktivitas -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Aktivitas Penggunaan Voucher</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <button class="btn btn-outline-secondary btn-sm mb-0">Lihat Semua</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        @forelse($voucherActivities as $activity)
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-success text-gradient">local_offer</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $activity->user_name }} menggunakan voucher {{ $activity->voucher_code }}</h6>
                                    <p class="text-secondary font-weight-normal text-xs mt-1 mb-0">
                                        {{ \Carbon\Carbon::parse($activity->used_at)->locale('id')->diffForHumans() }}
                                        • Diskon: Rp {{ number_format($activity->discount_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-secondary text-sm mb-0">Belum ada aktivitas penggunaan voucher</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Data Voucher</h6>
                    </div>
                    <a href="{{ route('admin.vouchers.create') }}" class="btn bg-gradient-dark btn-md me-3 mt-3">
                        <i class="material-symbols-rounded me-1" style="font-size: 18px;">add_circle</i>
                        Tambah Voucher
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible text-white mx-3 mt-3" role="alert">
                        <span class="text-sm">{{ session('success') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7">Kode</th>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7 ps-2">Tipe Voucher</th>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7 ps-2">Nilai</th>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7 ps-2">Min. Pembelian</th>
                                    <th class="text-uppercase text-black-th text-sm font-weight-bolder opacity-7 ps-2">Penggunaan</th>
                                    <th class="text-center text-uppercase text-black-th text-sm font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-black-th text-sm font-weight-bolder opacity-7">Berlaku</th>
                                    <th class="text-center text-uppercase text-black-th text-sm font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vouchers as $voucher)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-2">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $voucher->code }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $voucher->name }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm {{ $voucher->type === 'fixed' ? 'bg-gradient-primary' : 'bg-gradient-warning' }}">
                                            {{ $voucher->type === 'fixed' ? 'Nominal' : 'Persentase' }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            @if($voucher->type === 'fixed')
                                                Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                            @else
                                                {{ $voucher->value }}%
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark mb-0">Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-sm">
                                                {{ $voucher->used_count }} / {{ $voucher->max_uses ?: '∞' }}
                                            </span>
                                            @if($voucher->max_uses)
                                                <div class="progress" style="width: 100px; height: 5px;">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar" 
                                                        style="width: {{ ($voucher->used_count / $voucher->max_uses) * 100 }}%" 
                                                        aria-valuenow="{{ $voucher->used_count }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="{{ $voucher->max_uses }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-sm {{ $voucher->is_active ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                            {{ $voucher->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $voucher->valid_until->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                           class="text-primary font-weight-bold text-xs me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher) }}"
                                              method="POST"
                                              style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-danger font-weight-bold text-xs"
                                                    style="border: none; background: none;"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">
                                            <i class="material-symbols-rounded me-1" style="font-size: 18px;">info</i>
                                            Belum ada data voucher
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center px-4">
                        <div class="pagination pagination-dark">
                            {{ $vouchers->onEachSide(1)->links('vendor.pagination.material') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-radius-lg {
        border-radius: 0.75rem;
    }

    .bg-gradient-dark {
        background-image: linear-gradient(195deg, #42424a 0%, #191919 100%);
    }

    .shadow-dark {
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(64, 64, 64, 0.4);
    }

    .bg-gradient-primary {
        background-image: linear-gradient(195deg, #EC407A 0%, #D81B60 100%);
    }

    .bg-gradient-warning {
        background-image: linear-gradient(195deg, #FFA726 0%, #FB8C00 100%);
    }

    .bg-gradient-success {
        background-image: linear-gradient(195deg, #66BB6A 0%, #43A047 100%);
    }

    .bg-gradient-danger {
        background-image: linear-gradient(195deg, #EF5350 0%, #E53935 100%);
    }

    .bg-gradient-secondary {
        background-image: linear-gradient(195deg, #747b8a 0%, #495361 100%);
    }

    .bg-gradient-info {
        background-image: linear-gradient(195deg, #66BB6A 0%, #43A047 100%);
    }

    .badge {
        text-transform: uppercase;
        padding: 5px 9px;
        font-size: 0.65rem;
        font-weight: 500;
        border-radius: 0.375rem;
        line-height: 1;
    }

    .text-xxs {
        font-size: 0.65rem !important;
    }

    .text-xs {
        font-size: 0.75rem !important;
    }

    .text-sm {
        font-size: 0.875rem !important;
    }

    .font-weight-bolder {
        font-weight: 700 !important;
    }

    .table > :not(:last-child) > :last-child > * {
        border-bottom-color: #e9ecef;
    }

    .alert {
        padding: 0.75rem 1.25rem;
        border: 0;
        border-radius: 0.75rem;
    }

    .alert.alert-success {
        background-image: linear-gradient(195deg, #66BB6A 0%, #43A047 100%);
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #495361;
    }

    .page-item.active .page-link {
        background-image: linear-gradient(195deg, #42424a 0%, #191919 100%);
        border-color: #191919;
    }
</style>
@endpush
@endsection
