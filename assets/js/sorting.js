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
            cartIcon.src = 'assets/image/cartwhite.png'; // Revert to white
            logoIcon.src = 'assets/image/logo.png'; // Revert to original
        }
    });

    // Initialize product sorting
    const productsGrid = document.getElementById('products-grid');
    window.initialOrder = Array.from(productsGrid.children);
});

function filterProducts() {
    const filterValue = document.getElementById('product-filter').value;
    const productsGrid = document.getElementById('products-grid');

    let productsArray = Array.from(window.initialOrder);

    if (filterValue === 'az') {
        productsArray.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
    } else if (filterValue === 'za') {
        productsArray.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
    } else if (filterValue === 'price-asc') {
        productsArray.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    } else if (filterValue === 'price-desc') {
        productsArray.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
    }

    // Clear and re-append sorted products
    productsGrid.innerHTML = '';
    productsArray.forEach((card) => productsGrid.appendChild(card));
}

function searchProducts() {
    const searchQuery = document.getElementById('product-search').value.toLowerCase();
    const productsGrid = document.getElementById('products-grid');
    const productCards = Array.from(window.initialOrder);

    const filteredProducts = productCards.filter(card =>
        card.dataset.name.toLowerCase().includes(searchQuery)
    );

    // Clear and re-append filtered products
    productsGrid.innerHTML = '';
    filteredProducts.forEach((card) => productsGrid.appendChild(card));
}