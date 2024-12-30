<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.admin_app')
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('components.admin-sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('components.admin-navbar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Edit Produk</h6>
                            </div>
                        </div>
                        <div class="card-body px-4 pb-2">
                            <form action="{{ route('admin.produk.update', $produk->produk_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="nama_produk" class="mb-2">Nama Produk</label>
                                            <div class="input-group input-group-outline">
                                                <input type="text" name="nama_produk" id="nama_produk"
                                                    class="form-control" value="{{ $produk->nama_produk }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="mb-2">Kategori</label>
                                            <div class="input-group input-group-outline">
                                                <select name="kategori_id" id="kategori" class="form-control" required>
                                                    <option value="" disabled>Pilih Kategori</option>
                                                    @foreach ($kategori as $kat)
                                                        <option value="{{ $kat->kategori_id }}"
                                                            {{ $produk->kategori_id == $kat->kategori_id ? 'selected' : '' }}>
                                                            {{ $kat->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="harga" class="mb-2">Harga</label>
                                            <div class="input-group input-group-outline ">
                                                <input type="number" name="harga" id="harga" class="form-control"
                                                    value="{{ $produk->harga }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="stok" class="mb-2">Stok</label>
                                            <div class="input-group input-group-outline">
                                                <input type="number" name="stok" id="stok" class="form-control"
                                                    value="{{ $produk->stok }}" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="deskripsi" class="mb-2">Deskripsi</label>
                                            <div class="input-group input-group-outline">
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ $produk->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="gambar" class="mb-2">Gambar Produk</label>
                                            <div class="input-group input-group-outline">
                                                <input type="file" name="gambar" id="gambar"
                                                    class="form-control">
                                            </div>
                                            @if ($produk->gambar)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                                                        alt="Current photo" class="img-thumbnail"
                                                        style="max-height: 100px">
                                                    <span class="text-sm">Gambar saat ini</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn bg-gradient-dark">Update</button>
                                        <a href="{{ route('admin.produk.index') }}"
                                            class="btn btn-outline-dark">Kembali</a>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    @include('components.function')

    <script src="{{ asset('material-dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('material-dashboard/assets/js/plugins/chartjs.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="{{ asset('material-dashboard/assets/js/material-dashboard.min.js') }}"></script>
</body>

</html>