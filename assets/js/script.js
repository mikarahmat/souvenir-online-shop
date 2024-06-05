document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.querySelector(".navbar");
  const cartIcon = document.querySelector(".cart");
  const logoIcon = document.querySelector(".logo");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      navbar.classList.add("navbar-scrolled");
      cartIcon.src = "assets/image/cartblack.png"; // Change icon to black
      logoIcon.src = "assets/image/logo2.png"; // Change logo to black
    } else {
      navbar.classList.remove("navbar-scrolled");
      cartIcon.src = "assets/image/cartwhite.png"; // Revert to white
      logoIcon.src = "assets/image/logo.png"; // Revert to original
    }
  });

  // Auto-slide logic
  function autoSlide(sliderContainerSelector) {
    const sliderWrapper = document.querySelector(
      `${sliderContainerSelector} .slider-wrapper`
    );
    const slides = sliderWrapper.querySelectorAll(".slider img");
    const totalSlides = slides.length;
    let currentSlide = 0;

    function showNextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      const sliderWidth = sliderWrapper.clientWidth;
      sliderWrapper.scrollTo({
        left: sliderWidth * currentSlide,
        behavior: "smooth",
      });
    }

    // Change slides every 5 seconds
    setInterval(showNextSlide, 5000);
  }

  // Apply auto-slide to each slider container
  autoSlide(".slider-container-1");
  autoSlide(".slider-container-2");
});

function filterProducts() {
  const filterValue = document.getElementById("product-filter").value;
  const productCards = document.querySelectorAll(".product-card");
  const productsGrid = document.getElementById("products-grid");

  // Convert NodeList to an array for sorting
  let productsArray = Array.from(productCards);

  if (filterValue === "az") {
    productsArray.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
  } else if (filterValue === "za") {
    productsArray.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
  } else if (filterValue === "price-asc") {
    productsArray.sort(
      (a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price)
    );
  } else if (filterValue === "price-desc") {
    productsArray.sort(
      (a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price)
    );
  }

  // Clear and re-append sorted products
  productsGrid.innerHTML = "";
  productsArray.forEach((card) => productsGrid.appendChild(card));
}
