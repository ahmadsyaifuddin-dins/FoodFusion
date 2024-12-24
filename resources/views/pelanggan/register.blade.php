<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan</title>

    <link rel="stylesheet" href="{{ url('css/register.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.js"></script>
</head>

<body>
    <div class="formbold-main-wrapper">

        <div class="formbold-form-wrapper">
            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: '{!! implode('<br>', $errors->all()) !!}',
                            showConfirmButton: true
                        });
                    </script>
                @endif

                <div class="formbold-steps">
                    <ul>
                        <li class="formbold-step-menu1 active">
                            <span>1</span>
                            Data Diri
                        </li>
                        <li class="formbold-step-menu2">
                            <span>2</span>
                            Data Login
                        </li>
                        <li class="formbold-step-menu3">
                            <span>3</span>
                            Konfirmasi
                        </li>
                    </ul>
                </div>

                <div class="formbold-form-step-1 active">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="fullname" class="formbold-form-label">Nama Lengkap </label>
                            <input type="text" name="name" placeholder="John Doe" id="fullname"
                                class="formbold-form-input" required value="{{ old('name') }}" />
                        </div>
                        <div>
                            <label for="telepon" class="formbold-form-label">Nomor Telp/WhatsApp </label>
                            <input type="number" name="telepon" placeholder="085812345678" id="telepon"
                                class="formbold-form-input" required value="{{ old('telepon') }}" />
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="tgl_lahir" class="formbold-form-label">Tanggal Lahir </label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="formbold-form-input" required
                                value="{{ old('tgl_lahir') }}" />
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="formbold-form-label">Jenis Kelamin</label>
                            <div>
                                <label class="formbold-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki"
                                        class="formbold-radio-input" required
                                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} />
                                    Laki-laki
                                </label>
                                <label class="formbold-radio-label">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                                        class="formbold-radio-input" required
                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} />
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="makanan_fav" class="formbold-form-label">Makanan Favorit </label>
                        <input type="text" name="makanan_fav" id="makanan_fav" class="formbold-form-input"
                            placeholder="Mandai, Bilungka, Kolak" required value="{{ old('makanan_fav') }}" />
                    </div>
                    <br>
                    <div>
                        <label for="address" class="formbold-form-label">Alamat Lengkap </label>
                        <input type="text" name="alamat" id="address"
                            placeholder="Jl. Kaca Piring No. 8 Banjarmasin" class="formbold-form-input" required
                            value="{{ old('alamat') }}" />
                    </div>
                </div>

                <div class="formbold-form-step-2">
                    <div>
                        <label for="email" class="formbold-form-label">Email</label>
                        <input type="email" name="email" placeholder="example@mail.com" id="email"
                            class="formbold-form-input @error('email') is-invalid @enderror" required
                            value="{{ old('email') }}" />
                    </div>

                    <div>
                        <br>
                        <label for="password" class="formbold-form-label">Password</label>
                        <input type="password" name="password" id="password" class="formbold-form-input" required />
                        <div class="password-requirements">
                            <p><b>Minimal 3</b> Validasi kriteria keamanan Terpenuhi</p>
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step-3">
                    <div class="formbold-form-confirm">
                        <p>
                            Dengan Mendaftar Akun di Platform Food Fusion Kami, Apakah Anda menyetujui
                        </p>

                        <div>
                            <button class="formbold-confirm-btn active">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="10.5" fill="white" stroke="#DDE3EC" />
                                    <g clip-path="url(#clip0_1667_1314)">
                                        <path
                                            d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z"
                                            fill="#536387" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1667_1314)">
                                            <rect width="14" height="14" fill="white"
                                                transform="translate(4 4)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Yes! I want it.
                            </button>

                            <button class="formbold-confirm-btn">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="10.5" fill="white"
                                        stroke="#DDE3EC" />
                                    <g clip-path="url(#clip0_1667_1314)">
                                        <path
                                            d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z"
                                            fill="#536387" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1667_1314)">
                                            <rect width="14" height="14)" fill="white"
                                                transform="translate(4 4)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                No! I don’t want it.
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hyperlink untuk login -->
                <div class="formbold-form-btn-wrapper">
                    <p>Sudah punya akun?<a href="{{ route('login') }}" class="login-link"> Masuk disini</a></p>

                    <button class="formbold-back-btn">
                        Kembali
                    </button>

                    <button class="formbold-btn">
                        Selanjutnya
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1675_1807)">
                                <path
                                    d="M10.7814 7.33312L7.20541 3.75712L8.14808 2.81445L13.3334 7.99979L8.14808 13.1851L7.20541 12.2425L10.7814 8.66645H2.66675V7.33312H10.7814Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1675_1807)">
                                    <rect width="16" height="16)" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </form>


        </div>
    </div>

    <script src="{{ url('js/register.js') }}"></script>

</body>

</html>