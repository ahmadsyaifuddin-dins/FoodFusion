// Add these CSS rules to your existing <style> section
const styleSheet = document.createElement("style");
styleSheet.textContent = `

.formbold-form-input.valid {
border-color: #4CAF50 !important;
background-color: #f8fff8 !important;
}

.formbold-form-input.invalid {
border-color: #FF5252 !important;
background-color: #fff8f8 !important;
}


.password-requirements {
font-size: 12px;
color: #666;
margin-top: 5px;
}

.requirement {
display: flex;
align-items: center;
gap: 5px;
margin: 3px 0;
position: relative;
padding-left: 20px;
}

.requirement:before {
content: '';
position: absolute;
left: 0;
top: 50%;
transform: translateY(-50%);
width: 14px;
height: 14px;
border-radius: 50%;
border: 2px solid #ddd;
transition: all 0.3s ease;
}

.requirement.valid:before {
border-color: #4CAF50;
background-color: #4CAF50;
}

.requirement.invalid:before {
border-color: #FF5252;
}

.password-strength-meter {
height: 5px;
background-color: #f3f3f3;
border-radius: 3px;
margin-top: 10px;
}

.strength-meter-fill {
height: 100%;
border-radius: 3px;
transition: width 0.3s ease-in-out, background-color 0.3s ease-in-out;
width: 0;
}

.very-weak { background-color: #FF4136; width: 20%; }
.weak { background-color: #FF851B; width: 40%; }
.medium { background-color: #FFDC00; width: 60%; }
.strong { background-color: #2ECC40; width: 80%; }
.very-strong { background-color: #01FF70; width: 100%; }

.password-wrapper {
position: relative;
width: 100%;
}

.password-toggle {
position: absolute;
right: 12px;
top: 50%;
transform: translateY(-50%);
cursor: pointer;
padding: 5px;
z-index: 10;
background: none;
border: none;
display: flex;
align-items: center;
}

.password-toggle i {
color: #536387;
font-size: 18px;
}

.password-toggle:hover i {
color: #F44424;
}


#valid-msg, #error-msg {
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease-in-out;
    position: absolute;
    margin-top: 5px;
}

#valid-msg.show, #error-msg.show {
    opacity: 1;
    transform: translateY(0);
}

.hide {
    display: none !important;
}

.telepon-wrapper {
    position: relative;
}

`;
document.head.appendChild(styleSheet);

$(document).ready(function () {

    // Form elements
    const formSubmitBtn = $(".formbold-btn");
    const stepMenuOne = $(".formbold-step-menu1");
    const stepMenuTwo = $(".formbold-step-menu2");
    const stepMenuThree = $(".formbold-step-menu3");
    const stepOne = $(".formbold-form-step-1");
    const stepTwo = $(".formbold-form-step-2");
    const stepThree = $(".formbold-form-step-3");
    const formBackBtn = $(".formbold-back-btn");
    const emailInput = $("#email");
    const passwordInput = $("#password");

    //!Start Untuk Inputan Telepon
    // Modifikasi fungsi validasi
    const input = document.querySelector("#telepon");
    const errorMsg = document.querySelector("#error-msg");
    const validMsg = document.querySelector("#valid-msg");

    const iti = window.intlTelInput(input, {
        initialCountry: "id", // Default ke Indonesia
        preferredCountries: ["id", "my", "sg", "au"], // Negara yang muncul di atas
        separateDialCode: true,
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    const errorMap = [
        "Nomor tidak valid",
        "Kode negara tidak valid",
        "Nomor terlalu pendek",
        "Nomor terlalu panjang",
        "Nomor tidak valid",
    ];

    // Mencegah input karakter non-angka
    input.addEventListener("keypress", function (e) {
        if (e.key.match(/[^0-9]/)) {
            e.preventDefault();
        }
    });

    // Mencegah paste konten non-angka
    input.addEventListener("paste", function (e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData(
            "text"
        );
        if (pastedText.match(/^\d+$/)) {
            this.value = pastedText;
        }
    });

    // Hapus karakter non-angka jika somehow masuk
    input.addEventListener("input", function (e) {
        this.value = this.value.replace(/[^\d]/g, "");
    });

    // Phone input validation functions
    function resetPhoneValidation() {
        input.classList.remove("error", "valid", "invalid");
        errorMsg.innerHTML = "";
        errorMsg.classList.remove("show");
        errorMsg.classList.add("hide");
        validMsg.classList.remove("show");
        validMsg.classList.add("hide");
    }

    function validatePhoneNumber() {
        resetPhoneValidation();

        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
                setTimeout(() => validMsg.classList.add("show"), 10);
                input.classList.add("valid");
                input.classList.remove("invalid");
                return true;
            } else {
                input.classList.remove("valid");
                input.classList.add("invalid");
                const errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode] || "Nomor tidak valid";
                errorMsg.classList.remove("hide");
                setTimeout(() => errorMsg.classList.add("show"), 10);
                return false;
            }
        }
        return false;
    }

    // Event listeners
    const phoneInput = document.querySelector("#telepon");
    phoneInput.addEventListener("blur", validatePhoneNumber);
    phoneInput.addEventListener("change", validatePhoneNumber);
    phoneInput.addEventListener("keyup", function (e) {
        // Validasi hanya jika ada input
        if (this.value.length > 0) {
            validatePhoneNumber();
        } else {
            // Reset status jika input kosong
            this.classList.remove("valid", "invalid");
            document.querySelector("#valid-msg").classList.add("hide");
            document.querySelector("#error-msg").classList.add("hide");
        }
    });
    //!End Untuk Inputan Telepon


    //!Start Untuk Inputan Password
    // Add password requirements div
    const passwordRequirements = $("<div>", {
        class: "password-requirements",
    }).html(`
    <div class="requirement letter">Minimal satu huruf kecil</div>
    <div class="requirement length">Minimal 8 karakter</div>
    <div class="requirement capital">Minimal satu huruf kapital</div>
    <div class="requirement number">Minimal satu angka</div>
    <div class="requirement special">Minimal satu karakter spesial</div>
    `);

    const strengthMeter = $("<div>", {
        class: "password-strength-meter",
    }).html('<div class="strength-meter-fill"></div>');

    const strengthText = $("<div>", {
        class: "password-strength-text",
        style: "font-size: 12px; margin-top: 5px; color: #666;",
    });

    // Insert elements after password input
    passwordInput.after(strengthText);
    passwordInput.after(strengthMeter);
    passwordInput.after(passwordRequirements);

    const showPasswordIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
<circle cx="12" cy="12" r="3"/>
</svg>`;

    const hidePasswordIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
<line x1="1" y1="1" x2="23" y2="23"/>
</svg>`;

    passwordInput.wrap('<div class="password-wrapper"></div>');
    const toggleButton = $("<button>", {
        type: "button",
        class: "password-toggle",
        html: showPasswordIcon,
    });
    passwordInput.after(toggleButton);

    toggleButton.on("click", function (e) {
        e.preventDefault();
        const input = passwordInput;

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $(this).html(hidePasswordIcon);
        } else {
            input.attr("type", "password");
            $(this).html(showPasswordIcon);
        }
    });

    // Password validation function
    function calculatePasswordStrength(password) {
        let strength = 0;
        const requirements = {
            length: password.length >= 8,
            letter: /[a-z]/.test(password),
            capital: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password),
        };

        // Update requirement indicators
        Object.keys(requirements).forEach((req) => {
            const $requirement = $(`.requirement.${req}`);
            if (requirements[req]) {
                $requirement.addClass("valid").removeClass("invalid");
                strength++;
            } else {
                $requirement.addClass("invalid").removeClass("valid");
            }
        });

        return strength;
    }

    function updatePasswordStrength(strength) {
        const $strengthMeter = $(".strength-meter-fill");
        const $strengthText = $(".password-strength-text");

        $strengthMeter.removeClass("very-weak weak medium strong very-strong");
        let strengthClass, strengthText;

        switch (strength) {
            case 1:
                strengthClass = "very-weak";
                strengthText = "Sangat Lemah";
                break;
            case 2:
                strengthClass = "weak";
                strengthText = "Lemah";
                break;
            case 3:
                strengthClass = "medium";
                strengthText = "Sedang";
                break;
            case 4:
                strengthClass = "strong";
                strengthText = "Kuat";
                break;
            case 5:
                strengthClass = "very-strong";
                strengthText = "Sangat Kuat";
                break;
            default:
                strengthClass = "";
                strengthText = "";
        }
        $strengthMeter.addClass(strengthClass);
        $strengthText.text(`Kekuatan Password: ${strengthText}`);
        return strength >= 3; // Returns true if password is at least medium strength
    }

    // Real-time validation for password
    passwordInput.on("input", function () {
        const password = $(this).val();
        const strength = calculatePasswordStrength(password);
        const isValid = updatePasswordStrength(strength);

        if (isValid) {
            $(this).removeClass("invalid").addClass("valid");
        } else {
            $(this).removeClass("valid").addClass("invalid");
        }
    });
    //!End Untuk Inputan Password


    //!Start Untuk Inputan Email
    // Email validation function
    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailPattern.test(email)) {
            emailInput.removeClass("invalid").addClass("valid");
            return true;
        } else {
            emailInput.removeClass("valid").addClass("invalid");
            return false;
        }
    }

    function checkEmailExistence(email) {
        return $.ajax({
            url: "/check-email", // Add this route to your web.php
            method: "POST",
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    // Modify the email input event handler
    emailInput.on("input", function () {
        const email = $(this).val();
        if (validateEmail(email)) {
            // Check email existence only if format is valid
            checkEmailExistence(email).then(function (response) {
                if (response.exists) {
                    emailInput.removeClass("valid").addClass("invalid");
                    // Show warning using SweetAlert2
                    Swal.fire({
                        icon: "warning",
                        title: "Email Sudah Terdaftar",
                        text: "Email ini sudah terdaftar. Silakan gunakan email lain atau login ke akun Anda.",
                        showCancelButton: true,
                        confirmButtonText: "Login",
                        cancelButtonText: "Gunakan Email Lain",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/login";
                        }
                    });
                } else {
                    emailInput.removeClass("invalid").addClass("valid");
                }
            });
        }
    });

    // Real-time validation for email
    emailInput.on("input", function () {
        validateEmail($(this).val());
    });
    //!End Untuk Inputan Email


    // Handle back button
    formBackBtn.on("click", function (event) {
        event.preventDefault();
        if (stepMenuTwo.hasClass("active")) {
            stepMenuTwo.removeClass("active");
            stepMenuOne.addClass("active");
            stepTwo.removeClass("active");
            stepOne.addClass("active");
            formBackBtn.removeClass("active");
            formSubmitBtn.text("Selanjutnya");
        } else if (stepMenuThree.hasClass("active")) {
            stepMenuThree.removeClass("active");
            stepMenuTwo.addClass("active");
            stepThree.removeClass("active");
            stepTwo.addClass("active");
            formBackBtn.addClass("active");
            formSubmitBtn.text("Selanjutnya");
        }
    });


    //!Start Untuk Menghandle Alert Isian Inputan Dan Button Selanjutnya, dan UI Step Active Color
    // Handle next button
    formSubmitBtn.on("click", function (event) {
        event.preventDefault();

        //! Start Step Menu Pertama 
        if (stepMenuOne.hasClass("active")) {
            const fullname = $("#fullname").val().trim();
            const telepon = $("#telepon").val().trim();
            const tglLahir = $("#tgl_lahir").val().trim();
            const jenisKelamin = $('input[name="jenis_kelamin"]:checked').val();
            const makananFav = $("#makanan_fav").val().trim();
            const address = $("#address").val().trim();

            //!Start menampilkan SweetAlert2 jika ada kolom belum yg diisi (global/non-spesifik) dan ui Step Active
            if (fullname && telepon && tglLahir && jenisKelamin && makananFav && address) {
                stepMenuOne.removeClass("active");
                stepMenuTwo.addClass("active");
                stepOne.removeClass("active");
                stepTwo.addClass("active");
                formBackBtn.addClass("active");
                formSubmitBtn.text("Selanjutnya");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Mohon isi semua field yang wajib diisi",
                });
            }
            //!End Global


            //! Modify SweetAlert2Start Isian Nama Lengkap jika tidak di isi (secara Spesifik)
            if (!fullname) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: 'Isi Nama Lengkap!'
                });
                return;
            }
            //! Modify SweetAlert2End Isian Nama Lengkap jika tidak di isi (secara Spesifik)


            //! Modify SweetAlert2Start Isian Number jika tidak di isi (secara Spesifik)        
            // Check phone number validation
            if (!iti.isValidNumber()) {
                Swal.fire({
                    icon: "error",
                    title: "Perhatikan Inputan Nomor Telepon",
                    text:
                        errorMap[iti.getValidationError()] ||
                        "Mohon masukkan nomor telepon yang valid",
                });
                return;
            }
            //! Modify SweetAlert2End Isian Number jika tidak di isi (secara Spesifik)


            //! Modify SweetAlert2Start Isian Tanggal Lahir jika tidak di isi (secara Spesifik)
            // Tambahkan pengecekan spesifik untuk Tanggal Lahir
            // if (!tglLahir) {
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Mohon Perhatian!',
            //     text: 'Isi Tanggal lahirmu Kocak!'
            //     });
            //     return;
            // }
            //! Modify SweetAlert2End Isian Tanggal Lahir jika tidak di isi (secara Spesifik)


            //! Modify SweetAlert2Start Isian Makanan Favorit jika tidak di isi (secara Spesifik)
            // Tambahkan pengecekan spesifik untuk Makanan Favorit
            if (!makananFav) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Input Makanan Favoritmu Kocak!",
                });
                return;
            }
            //! Modify SweetAlert2End Isian Makanan Favorit jika tidak di isi (secara Spesifik)
            //! End Step Menu Pertama

            //! Start Step Menu Kedua
        } else if (stepMenuTwo.hasClass("active")) {
            const email = emailInput.val().trim();
            const password = passwordInput.val().trim();
            const strength = calculatePasswordStrength(password);

            //! Jika Email dan Password masih kosong lalu pencet tombol selanjutnya maka akan menampilkan alert
            if (!email || !password) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Mohon isi semua field yang wajib diisi",
                });
                return;
            }

            const isEmailValid = validateEmail(email);
            const isPasswordValid = strength >= 3; // Minimum medium strength required

            //! Jika Inputan Email Tidak Valid, maka akan menampilkan alert
            if (!isEmailValid) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Format email tidak valid",
                });
                return;
            }

            //! Jika Inputan Password Lemah, maka akan menampilkan alert
            if (!isPasswordValid) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Password terlalu lemah. Pastikan memenuhi minimal 3 kriteria keamanan",
                });
                return;
            }

            stepMenuTwo.removeClass("active");
            stepMenuThree.addClass("active");
            stepTwo.removeClass("active");
            stepThree.addClass("active");
            formBackBtn.addClass("active");
            formSubmitBtn.text("GO! Daftar");
            //! End Step Menu Kedua

        } else if (stepMenuThree.hasClass("active")) {
            const characterType = document.getElementById("type_char").value;

            if (!characterType) {
                Swal.fire({
                    icon: "error",
                    title: "Mohon Perhatian!",
                    text: "Silakan pilih tipe karakter Anda!",
                });
                return;
            }

            $("form").submit();
        }
    });

    // Handle confirmation buttons
    $(".formbold-confirm-btn").on("click", function (e) {
        e.preventDefault();
        $(".formbold-confirm-btn").removeClass("active");
        $(this).addClass("active");
    });
});

function selectCharacter(type) {
    // Reset semua button ke state awal
    document.querySelectorAll(".formbold-confirm-btn").forEach((btn) => {
        btn.classList.remove("active");
    });

    // Aktifkan button yang dipilih
    const button =
        type === "Hero"
            ? document.getElementById("hero-btn")
            : document.getElementById("villain-btn");
    button.classList.add("active");

    // Set nilai ke input hidden
    document.getElementById("type_char").value = type;
}
