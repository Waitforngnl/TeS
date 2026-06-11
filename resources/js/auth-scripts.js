document.addEventListener('DOMContentLoaded', () => {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    if (signUpButton && signInButton && container) {
        // Nút Đăng ký (trên overlay) -> Trượt sang form Đăng ký
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        // Nút Đăng nhập (trên overlay) -> Trượt về form Đăng nhập
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    }
});