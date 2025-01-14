@extends('layouts.app')
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Sidebar -->
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="position-relative" style="width: 120px; height: 120px; margin: 0 auto;">
                                        @if (Auth::user()->photo)
                                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                                class="rounded-circle img-fluid border border-4"
                                                style="width: 120px; height: 120px; object-fit: cover;" alt="Profile Photo">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                style="width: 120px; height: 120px;">
                                                <i class="fas fa-user fa-3x text-secondary"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow">
                                            <i class="fas fa-camera text-custom"></i>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-4">
                                    <i class="fas fa-user-tag me-2"></i>Pelanggan
                                </p>

                                <!-- Stats -->
                                <div class="row g-0 mb-4">
                                    <div class="col border rounded-start p-3">
                                        <h6 class="mb-0 text-custom">24</h6>
                                        <small class="text-muted">Pesanan</small>
                                    </div>
                                    <div class="col border-top border-bottom border-end p-3">
                                        <h6 class="mb-0 text-custom">12</h6>
                                        <small class="text-muted">Review</small>
                                    </div>
                                    <div class="col border rounded-end p-3">
                                        <h6 class="mb-0 text-custom">5</h6>
                                        <small class="text-muted">Wishlist</small>
                                    </div>
                                </div>

                                <!-- Navigation Menu -->
                                <div class="list-group mb-4">
                                    <a href="{{ route('pelanggan.profile') }}"
                                        class="list-group-item list-group-item-action active">
                                        <i class="fas fa-user-circle me-2"></i>Profile Saya
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                                        <i class="fas fa-shopping-bag me-2"></i>Pesanan Saya
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="fas fa-heart me-2"></i>Wishlist
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="fas fa-star me-2"></i>Review Saya
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="fas fa-cog me-2"></i>Pengaturan
                                    </a>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('home.index') }}" class="btn btn-secondary flex-grow-1">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <button type="submit" class="btn btn-custom w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-custom text-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-edit me-2"></i>
                                Informasi Profil Saya
                            </h5>
                        </div>

                        <div class="card-body">
                            <!-- Form content remains the same, just updating colors -->
                            <form action="{{ route('pelanggan.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-user me-2 text-custom"></i>Nama Lengkap
                                            </label>
                                            <input type="text" name="name"
                                                value="{{ old('name', Auth::user()->name) }}"
                                                class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-envelope me-2 text-custom"></i>Email
                                            </label>
                                            <input type="email" name="email"
                                                value="{{ old('email', Auth::user()->email) }}"
                                                class="form-control @error('email') is-invalid @enderror">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fab fa-whatsapp me-2 text-custom"></i>WhatsApp
                                            </label>
                                            <input type="text" name="telepon"
                                                value="{{ old('telepon', Auth::user()->telepon) }}" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-birthday-cake me-2 text-custom"></i>Tanggal Lahir
                                            </label>
                                            <input type="date" name="tgl_lahir"
                                                value="{{ old('tgl_lahir', Auth::user()->tgl_lahir) }}"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-utensils me-2 text-custom"></i>Makanan Favorit
                                            </label>
                                            <input type="text" name="makanan_fav"
                                                value="{{ old('makanan_fav', Auth::user()->makanan_fav) }}"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-map-marker-alt me-2 text-custom"></i>Alamat
                                            </label>
                                            <textarea name="alamat" rows="3" class="form-control">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Read Only Fields -->
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-venus-mars me-2 text-custom"></i>Jenis Kelamin
                                            </label>
                                            <input type="text" value="{{ Auth::user()->jenis_kelamin }}"
                                                class="form-control" style="background-color: #f0f0f0;" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-user-tag me-2 text-custom"></i>Jenis Pengguna
                                            </label>
                                            <input type="text" value="{{ Auth::user()->role }}" class="form-control"
                                                style="background-color: #f0f0f0;" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Photo Upload -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-camera me-2 text-custom"></i>Foto Profil
                                    </label>
                                    <div class="input-group">
                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                        @if (Auth::user()->photo)
                                            <div class="input-group-text">
                                                <div class="form-check m-0">
                                                    <input type="checkbox" class="form-check-input" id="remove_photo"
                                                        name="remove_photo">
                                                    <label class="form-check-label" for="remove_photo">
                                                        Hapus foto
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Format yang didukung: JPG, JPEG, PNG, SVG, GIF (Max. 2MB)
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-2 text-custom"></i>Password Baru
                                    </label>
                                    <input type="password" name="password" class="form-control">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Biarkan kosong jika tidak ingin mengubah password
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-custom">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // SweetAlert2 configuration
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false,
                        background: '#fff',
                        iconColor: '#D32F2F'
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: "{{ session('error') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if ($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: "{{ $errors->first() }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif
            });
        </script>
    @endpush
@endsection
