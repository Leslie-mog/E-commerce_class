// js/validate.js
// Form validation will be added in Task 3.
console.log('validate.js loaded');
// js/validate.js

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');
    if (!form) return;

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\-\s]{7,15}$/;
    const passwordRegex = /^(?=.*\d).{8,}$/;   // min 8 chars + at least 1 digit

    // login-form validation
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            let ok = true;
            const emailEl = loginForm.email;
            const passEl = loginForm.password;

            document.getElementById('login-email-error').textContent = '';
            document.getElementById('login-password-error').textContent = '';

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
                document.getElementById('login-email-error').textContent = 'Enter a valid email.';
                ok = false;
            }
            if (passEl.value.length < 1) {
                document.getElementById('login-password-error').textContent = 'Password is required.';
                ok = false;
            }
            if (!ok) e.preventDefault();
        });
    }
    function showError(id, msg) {
        const el = document.getElementById(id);
        if (el) el.textContent = msg;
    }
    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
    }

    form.addEventListener('submit', function (e) {
        clearErrors();
        let ok = true;

        const name = form.name.value.trim();
        const email = form.email.value.trim();
        const password = form.password.value;
        const confirm = form.confirm_password.value;
        const country = form.country.value;
        const city = form.city.value.trim();
        const contact = form.contact.value.trim();

        if (name.length < 2) {
            showError('name-error', 'Name must be at least 2 characters.');
            ok = false;
        }
        if (!emailRegex.test(email)) {
            showError('email-error', 'Enter a valid email address.');
            ok = false;
        }
        if (!passwordRegex.test(password)) {
            showError('password-error', 'Min 8 characters with at least one digit.');
            ok = false;
        }
        if (password !== confirm) {
            showError('confirm-error', 'Passwords do not match.');
            ok = false;
        }
        if (!country) {
            showError('country-error', 'Please select a country.');
            ok = false;
        }
        if (!city) {
            showError('city-error', 'Please enter your city.');
            ok = false;
        }
        if (!phoneRegex.test(contact)) {
            showError('contact-error', '7–15 digits, + and - allowed.');
            ok = false;
        }

        if (!ok) {
            e.preventDefault();
            return;
        }

        // Optional: disable button to prevent double-submit
        const btn = form.querySelector('button[type="submit"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Creating account…'; }
    });
});