@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Data Produk</h6>
                        </div>
                        <a href="{{ route('admin.produk.create') }}" class="btn bg-gradient-dark btn-md me-3 mt-3">
                            <i class="material-symbols-rounded me-1" style="font-size: 18px;">box_add</i> Tambah
                            Data Produk
                        </a>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7">
                                            Gambar Produk</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7">
                                            Nama Produk</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Deskripsi</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Stok</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Diskon</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Diskon</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kategori</th>
                                        <th class="text-uppercase text-black-th text-xxs font-weight-bolder opacity-7 ps-2">
                                            Ditambahkan pada tanggal</th>

                                        <th
                                            class="text-center text-uppercase text-black-th text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $index => $prod)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-3 py-2">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <img src="{{ $prod->gambar ? asset('storage/' . $prod->gambar) : asset('storage/user.svg') }}"
                                                        class="avatar avatar-lg me-3 border-radius-lg" alt="product photo">
                                                </div>
                                            </td>

                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $prod->nama_produk }}
                                                </p>
                                            </td>

                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $prod->deskripsi }}">
                                                    {{ \Illuminate\Support\Str::limit($prod->deskripsi, 50, '...') }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">Rp
                                                    {{ number_format($prod->harga, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $prod->stok }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $prod->diskon }}%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">Rp
                                                    {{ number_format($prod->harga_diskon, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $prod->created_at }}
                                                </span>
                                            </td>

                                            <td class="align-middle">
                                                <a href="{{ route('admin.produk.edit', $prod->id) }}"
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit produk">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.produk.destroy', $prod->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger font-weight-bold text-xs"
                                                        style="border: none; background: none;"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
