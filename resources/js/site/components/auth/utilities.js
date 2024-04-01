export function handlePasswordEyeBtns() {
    const eyeBtns = document.querySelectorAll('.password-eye_show');

    eyeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const inputs = btn.closest('form').querySelectorAll('input[name*="password"]');

            if (btn.classList.contains('password-eye_show')) {
                inputs.forEach((input, index) => {
                    input.type = 'text';
                    btn.classList.replace('password-eye_show', 'password-eye_hide');
                    if (!index) {
                        input.focus();
                    }
                });
            } else {
                inputs.forEach((input, index) => {
                    input.type = 'password';
                    btn.classList.replace('password-eye_hide', 'password-eye_show');
                    if (!index) {
                        input.focus();
                    }
                });
            }
        });
    });
}