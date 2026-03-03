# House of Stitches

A modern PHP-based e-commerce website for premium kidswear, featuring a responsive design, product catalog, shopping cart, and interactive UI components.

## Features

- Home page with video and Instagram feed
- About page with brand story and signature labels
- Shop page with product filters, sorting, and pagination
- Product detail page with carousel and related products
- Shopping cart with order summary and promo code
- Responsive design for desktop and mobile
- Integrated Bootstrap, Owl Carousel, GSAP animations

## Project Structure

```
.htaccess
about.php
cart.php
footer.php
header.php
index.php
product.php
shop.php
assets/
  bootstrap/
    bootstrap.min.css
  css/
    owl.carousel.min.css
    owl.theme.default.min.css
  gallery/
    cancel.png
    dots-green.svg
    houseofstitches-video.mp4
    img-grid-1.jpg
    img-grid-2.jpg
    img-grid-3.jpg
    interface.png
    logo.png
    product.webp
    showroom.jpg
  js/
    bootstrap.bundle.min.js
    jquery.min.js
    main.js
    owl.carousel.min.js
  scss/
    style.scss
    style.css
    style.css.map
README.md
robots.txt
```

## Getting Started

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/houseofstitches.git
   ```

2. **Setup local server:**
   - Place the project in your web server directory (e.g., `htdocs` for XAMPP).
   - Start Apache and MySQL if using XAMPP.

3. **Open in browser:**
   - Visit `http://localhost/houseofstitches/` to view the site.

## Dependencies

- [Bootstrap](assets/bootstrap/bootstrap.min.css)
- [Owl Carousel](assets/js/owl.carousel.min.js)
- [GSAP](https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js)
- [Bootstrap Icons](https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css)
- [jQuery](assets/js/jquery.min.js)

## Customization

- Update product images in [assets/gallery/](assets/gallery/)
- Modify styles in [assets/scss/style.scss](assets/scss/style.scss)
- Edit PHP pages for content and layout

## License

This project is licensed for educational and demonstration purposes.

---

© 2025 House of Stitches. All rights reserved.