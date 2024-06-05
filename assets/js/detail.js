document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const cartIcon = document.querySelector('.cart');
    const logoIcon = document.querySelector('.logo');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.classList.add('navbar-scrolled');
            cartIcon.src = 'assets/image/cartblack.png'; // Change icon to black
            logoIcon.src = 'assets/image/logo2.png'; // Change logo to black
        } else {
            navbar.classList.remove('navbar-scrolled');
            cartIcon.src = 'assets/image/cartblack.png'; // Revert to white
            logoIcon.src = 'assets/image/logoblack.png'; // Revert to original
        }
    });
});