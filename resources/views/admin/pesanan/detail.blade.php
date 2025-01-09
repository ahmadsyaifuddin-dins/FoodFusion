@extends('layouts.app-admin')

@section('content')
    <div class="container my-5 me-5 flex justify-content-center align-items-center">
        <h4>Detail Pesanan</h4>
        <table class="table">
            <tr>
                <th>Nomor Pesanan</th>
                <td>{{ $pesanan->order_number }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $pesanan->user->name ?? 'Guest' }}</td>
            </tr>
            <tr>
                <th>Produk yang Dibeli</th>
                <td>
                    <ol>
                        @foreach ($pesanan->orderItems as $item)
                            @php
                                $harga_asli = $item->produk->harga ?? 0;
                                $diskon = $item->produk->diskon ?? 0;
                                $harga_setelah_diskon = $harga_asli - $harga_asli * ($diskon / 100);
                                $subtotal = $harga_setelah_diskon * $item->quantity;
                            @endphp
                            <li>
                                {{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }}
                                (Jumlah: {{ $item->quantity }})
                                <br>
                                Harga Satuan: Rp{{ number_format($harga_setelah_diskon, 0, ',', '.') }} <br>
                                Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ol>
                </td>

            <tr>
                <th>Total</th>
                @php
                    $total = 0;
                    foreach ($pesanan->orderItems as $item) {
                        $harga_asli = $item->produk->harga ?? 0;
                        $diskon = $item->produk->diskon ?? 0;
                        $harga_setelah_diskon = $harga_asli - $harga_asli * ($diskon / 100);
                        $total += $harga_setelah_diskon * $item->quantity;
                    }
                @endphp
                <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $pesanan->payment_method ?? 'Metode pembayaran tidak tersedia' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge {{ $pesanan->status_badge }}">{{ ucfirst($pesanan->status) }}</span>
                </td>
            </tr>
            <tr>
                <th>Alamat Pengiriman</th>
                <td>{{ $pesanan->user ? $pesanan->user->alamat : 'Alamat tidak tersedia' }}</td>
            </tr>
        </table>
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-primary">Kembali</a>
    </div>
@endsection