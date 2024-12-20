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

`;
document.head.appendChild(styleSheet);

$(document).ready(function() {

    // Form elements
    const formSubmitBtn = $('.formbold-btn');
    const stepMenuOne = $('.formbold-step-menu1');
    const stepMenuTwo = $('.formbold-step-menu2');
    const stepMenuThree = $('.formbold-step-menu3');
    const stepOne = $('.formbold-form-step-1');
    const stepTwo = $('.formbold-form-step-2');
    const stepThree = $('.formbold-form-step-3');
    const formBackBtn = $('.formbold-back-btn');
    const emailInput = $('#email');
    const passwordInput = $('#password');

    // Add password requirements div
    const passwordRequirements = $('<div>', {
        class: 'password-requirements'
    }).html(`
<div class="requirement length">Minimal 8 karakter</div>
<div class="requirement letter">Minimal satu huruf kecil</div>
<div class="requirement capital">Minimal satu huruf kapital</div>
<div class="requirement number">Minimal satu angka</div>
<div class="requirement special">Minimal satu karakter spesial</div>
`);

    const strengthMeter = $('<div>', {
        class: 'password-strength-meter'
    }).html('<div class="strength-meter-fill"></div>');

    const strengthText = $('<div>', {
        class: 'password-strength-text',
        style: 'font-size: 12px; margin-top: 5px; color: #666;'
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
    const toggleButton = $('<button>', {
        type: 'button',
        class: 'password-toggle',
        html: showPasswordIcon
    });
    passwordInput.after(toggleButton);

    toggleButton.on('click', function(e) {
        e.preventDefault();
        const input = passwordInput;

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).html(hidePasswordIcon);
        } else {
            input.attr('type', 'password');
            $(this).html(showPasswordIcon);
        }
    });

    // Email validation function
    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailPattern.test(email)) {
            emailInput.removeClass('invalid').addClass('valid');
            return true;
        } else {
            emailInput.removeClass('valid').addClass('invalid');
            return false;
        }
    }

    function checkEmailExistence(email) {
        return $.ajax({
            url: '/check-email', // Add this route to your web.php
            method: 'POST',
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    // Modify the email input event handler
    emailInput.on('input', function() {
        const email = $(this).val();
        if (validateEmail(email)) {
            // Check email existence only if format is valid
            checkEmailExistence(email).then(function(response) {
                if (response.exists) {
                    emailInput.removeClass('valid').addClass('invalid');
                    // Show warning using SweetAlert2
                    Swal.fire({
                        icon: 'warning',
                        title: 'Email Sudah Terdaftar',
                        text: 'Email ini sudah terdaftar. Silakan gunakan email lain atau login ke akun Anda.',
                        showCancelButton: true,
                        confirmButtonText: 'Login',
                        cancelButtonText: 'Gunakan Email Lain'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login';
                        }
                    });
                } else {
                    emailInput.removeClass('invalid').addClass('valid');
                }
            });
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
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const $requirement = $(`.requirement.${req}`);
            if (requirements[req]) {
                $requirement.addClass('valid').removeClass('invalid');
                strength++;
            } else {
                $requirement.addClass('invalid').removeClass('valid');
            }
        });

        return strength;
    }

    function updatePasswordStrength(strength) {
        const $strengthMeter = $('.strength-meter-fill');
        const $strengthText = $('.password-strength-text');

        $strengthMeter.removeClass('very-weak weak medium strong very-strong');
        let strengthClass, strengthText;

        switch (strength) {
            case 1:
                strengthClass = 'very-weak';
                strengthText = 'Sangat Lemah';
                break;
            case 2:
                strengthClass = 'weak';
                strengthText = 'Lemah';
                break;
            case 3:
                strengthClass = 'medium';
                strengthText = 'Sedang';
                break;
            case 4:
                strengthClass = 'strong';
                strengthText = 'Kuat';
                break;
            case 5:
                strengthClass = 'very-strong';
                strengthText = 'Sangat Kuat';
                break;
            default:
                strengthClass = '';
                strengthText = '';
        }
        $strengthMeter.addClass(strengthClass);
        $strengthText.text(`Kekuatan Password: ${strengthText}`);
        return strength >= 3; // Returns true if password is at least medium strength
    }

    // Real-time validation for email
    emailInput.on('input', function() {
        validateEmail($(this).val());
    });

    // Real-time validation for password
    passwordInput.on('input', function() {
        const password = $(this).val();
        const strength = calculatePasswordStrength(password);
        const isValid = updatePasswordStrength(strength);

        if (isValid) {
            $(this).removeClass('invalid').addClass('valid');
        } else {
            $(this).removeClass('valid').addClass('invalid');
        }
    });

    // Handle back button
    formBackBtn.on('click', function(event) {
        event.preventDefault();
        if (stepMenuTwo.hasClass('active')) {
            stepMenuTwo.removeClass('active');
            stepMenuOne.addClass('active');
            stepTwo.removeClass('active');
            stepOne.addClass('active');
            formBackBtn.removeClass('active');
            formSubmitBtn.text('Selanjutnya');
        } else if (stepMenuThree.hasClass('active')) {
            stepMenuThree.removeClass('active');
            stepMenuTwo.addClass('active');
            stepThree.removeClass('active');
            stepTwo.addClass('active');
            formBackBtn.addClass('active');
            formSubmitBtn.text('Selanjutnya');
        }
    });

    // Handle next button
    formSubmitBtn.on('click', function(event) {
        event.preventDefault();

        if (stepMenuOne.hasClass('active')) {
            const fullname = $('#fullname').val().trim();
            const telepon = $('#telepon').val().trim();
            const tglLahir = $('#tgl_lahir').val().trim();
            const makananFav = $('#makanan_fav').val().trim();
            const address = $('#address').val().trim();

            if (fullname && telepon && tglLahir && makananFav && address) {
                stepMenuOne.removeClass('active');
                stepMenuTwo.addClass('active');
                stepOne.removeClass('active');
                stepTwo.addClass('active');
                formBackBtn.addClass('active');
                formSubmitBtn.text('Selanjutnya');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Perhatian!',
                    text: 'Mohon isi semua field yang wajib diisi'
                });
            }
        } else if (stepMenuTwo.hasClass('active')) {
            const email = emailInput.val().trim();
            const password = passwordInput.val().trim();
            const strength = calculatePasswordStrength(password);

            if (!email || !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Perhatian!',
                    text: 'Mohon isi semua field yang wajib diisi'
                });
                return;
            }



            const isEmailValid = validateEmail(email);
            const isPasswordValid = strength >= 3; // Minimum medium strength required

            if (!isEmailValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Perhatian!',
                    text: 'Format email tidak valid'
                });
                return;
            }

            if (!isPasswordValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Perhatian!',
                    text: 'Password terlalu lemah. Pastikan memenuhi minimal 3 kriteria keamanan'
                });
                return;
            }

            stepMenuTwo.removeClass('active');
            stepMenuThree.addClass('active');
            stepTwo.removeClass('active');
            stepThree.addClass('active');
            formBackBtn.addClass('active');
            formSubmitBtn.text('Daftar !');
        } else if (stepMenuThree.hasClass('active')) {
            const confirmBtns = $('.formbold-confirm-btn');
            let confirmed = false;

            confirmBtns.each(function() {
                if ($(this).hasClass('active') && $(this).text().trim()
                    .includes('Yes')) {
                    confirmed = true;
                }
            });

            if (!confirmed) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Perhatian!',
                    text: 'Silakan pilih konfirmasi terlebih dahulu'
                });
                return;
            }

            $('form').submit();
        }
    });

    // Handle confirmation buttons
    $('.formbold-confirm-btn').on('click', function(e) {
        e.preventDefault();
        $('.formbold-confirm-btn').removeClass('active');
        $(this).addClass('active');
    });
});