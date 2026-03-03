<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop Clothes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fafafa;
        }

        .product-card {
            border: 1px solid #e0e0e0;
            padding: 15px;
            cursor: pointer;
            background: #fff;
            transition: all .3s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .product-card img {
            width: 100%;
        }

        .main-img {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            background: #f3f3f3;
        }

        .color-thumb {
            width: 80px;
            height: 100px;
            border: 2px solid #ccc;
            cursor: pointer;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
            background: #fff;
        }

        .color-thumb.selected,
        .color-thumb:hover {
            border-color: #000;
        }

        .gallery-thumb {
            width: 70px;
            height: 90px;
            object-fit: cover;
            border: 1px solid #ccc;
            cursor: pointer;
            transition: .2s;
        }

        .gallery-thumb.active {
            border: 2px solid #000;
            transform: scale(1.05);
        }

        #sizeContainer {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .size-box {
            border: 2px solid #ccc;
            padding: 12px 18px;
            cursor: pointer;
            font-weight: 600;
            text-align: center;
            background: #fff;
            transition: .2s;
        }

        .size-box:hover {
            border-color: #000;
        }

        .size-box.selected {
            border-color: #000;
            background: #f5f5f5;
        }

        .size-error {
            display: none;
            color: #d60000;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .size-subinfo {
            display: none;
            width: 100%;
            margin-top: 6px;
            font-size: 13px;
            color: #666;
        }

        .size-subinfo span {
            border: 1px solid #ccc;
            padding: 3px 8px;
            margin-right: 6px;
            background: #fafafa;
            display: inline-block;
        }

        .cart-btn {
            background: #000;
            color: #fff;
            padding: 16px;
            width: 100%;
            border: none;
            margin-top: 20px;
            font-size: 16px;
            transition: .3s;
        }

        .cart-btn:hover {
            background: #222;
        }

        .detail-label {
            font-weight: 600;
            font-size: 14px;
        }

        .detail-value {
            font-size: 14px;
            color: #555;
        }

        .modal-content {
            position: relative;
        }

        .modal-content .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            .cart-btn {
                position: sticky;
                bottom: 10px;
                z-index: 10;
            }

            .modal-content {
                overflow-y: scroll;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                <div class="product-card" data-bs-toggle="modal" data-bs-target="#productModal"
                    data-name="Kids Cotton Shirt" data-brand="Urban Kids" data-sku="UK-SH-2001"
                    data-category="Kids Wear" data-subcategory="Shirts" data-fabric-category="Cotton"
                    data-fabric-type="Premium Soft Cotton" data-fabric="lycra"
                    data-composition="80% Cotton, 20% Polyester" data-price="1999" data-sale="1499"
                    data-description="Soft breathable cotton shirt for kids. Perfect for daily wear and parties."
                    data-images='[
  {
    "color": "Orange",
    "imgs": [
      "https://di2ponv0v5otw.cloudfront.net/posts/2025/05/07/681c0f1dfe4c68aafaf4d6b7/m_681c0f26ff03206f17162648.jpg",
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGTTKWMjv5mPh-jRq1oOfyYVQ2-iYvVVAw2Q&s",
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXdaWqikUuHvL4DsR30gJKr7bm7i6l5c9dlw&s"
    ]
  },
  {
    "color": "Black",
    "imgs": [
      "https://i.pinimg.com/736x/bf/85/07/bf850730e50924906c4c0190f249fa7c.jpg",
      "https://www.pinkblueindia.com/wp-content/uploads/2015/10/brown-and-black-baby-boy-party-wear-dress.jpg",
      "https://assets.myntassets.com/dpr_1.5,q_30,w_400,c_limit,fl_progressive/assets/images/2025/JULY/24/0qi9WP0X_79ec9731e9a440a2afce0fbeebee02cc.jpg"
    ]
  }
]'>
                    <img src="https://di2ponv0v5otw.cloudfront.net/posts/2025/05/07/681c0f1dfe4c68aafaf4d6b7/m_681c0f26ff03206f17162648.jpg"
                        alt="Kids Cotton Shirt">
                    <h6 class="mt-2 mb-0">Kids Cotton Shirt</h6>
                    <small class="text-muted">₹1499</small>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content p-4">
                <button class="btn-close" data-bs-dismiss="modal"></button>

                <div class="row">
                    <div class="col-md-6 text-center">
                        <img id="mainImage" class="main-img" alt="Product image">
                        <div class="d-flex justify-content-center gap-2 mt-3" id="galleryThumbs"></div>
                    </div>

                    <div class="col-md-6">
                        <h4 id="modalTitle" class="fw-bold"></h4>
                        <p class="mb-1 text-muted">Brand: <span id="brandName" class="text-dark fw-semibold"></span></p>

                        <div class="mb-3">
                            MRP: <span class="text-muted" id="modalMrp"></span>
                            <strong class="ms-2">WSP: </strong><span class="fs-5 fw-bold" id="modalSale"></span>
                        </div>
                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-6"><span class="detail-label">SKU:</span> <span class="detail-value"
                                    id="skuId"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric Category:</span> <span
                                    class="detail-value" id="fabricCategory"></span></div>
                            <div class="col-6"><span class="detail-label">Category:</span> <span class="detail-value"
                                    id="category"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric Type:</span> <span class="detail-value"
                                    id="fabricType"></span></div>
                            <div class="col-6"><span class="detail-label">Sub Category:</span> <span
                                    class="detail-value" id="subcategory"></span></div>
                            <div class="col-6"><span class="detail-label">Fabric:</span> <span class="detail-value"
                                    id="fabric"></span></div>
                            <div class="col-6"><span class="detail-label">Composition:</span> <span class="detail-value"
                                    id="composition"></span></div>
                        </div>

                        <p class="fw-semibold">Color: <span id="colorName"></span></p>
                        <div class="d-flex mb-2" id="colorThumbs"></div>

                        <div class="size-error fw-semibold" id="sizeError" role="alert">PLEASE SELECT A SIZE</div>
                        <p class="fw-semibold">Size <small class="text-muted">(Tap to see age breakup)</small></p>
                        <div id="sizeContainer"></div>

                        <p class="detail-label mt-3">Description</p>
                        <p class="detail-value" id="productDescription"></p>

                        <button class="cart-btn" id="addToCart" aria-label="Add product to cart">
                            Add to Cart
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modal = document.getElementById("productModal");
        const mainImage = document.getElementById("mainImage");
        const galleryThumbs = document.getElementById("galleryThumbs");
        const colorThumbs = document.getElementById("colorThumbs");
        const sizeContainer = document.getElementById("sizeContainer");
        const sizeError = document.getElementById("sizeError");
        const addToCart = document.getElementById("addToCart");
        const colorName = document.getElementById("colorName");

        let images = [], selectedColor = "", selectedSize = "";

        const betweenSizes = {
            "2-5 Years": ["2-3", "3-4", "4-5"],
            "6-16 Years": ["6-8", "8-12", "12-16"],
            "0-24 Months": ["0-6m", "6-12m", "12-24m"]
        };

        modal.addEventListener("show.bs.modal", e => {
            const c = e.relatedTarget;

            modalTitle.innerText = c.dataset.name;
            brandName.innerText = c.dataset.brand;
            skuId.innerText = c.dataset.sku;
            category.innerText = c.dataset.category;
            subcategory.innerText = c.dataset.subcategory;
            fabricCategory.innerText = c.dataset.fabricCategory;
            fabricType.innerText = c.dataset.fabricType;
            fabric.innerText = c.dataset.fabric;
            composition.innerText = c.dataset.composition;

            modalMrp.innerText = "₹" + c.dataset.price;
            modalSale.innerText = "₹" + c.dataset.sale;
            productDescription.innerText = c.dataset.description;

            images = JSON.parse(c.dataset.images);
            selectedColor = images[0].color;
            selectedSize = "";
            sizeError.style.display = "none";

            renderColors();
            loadColor(selectedColor);
            renderSizes();
        });
        function renderColors() {
            colorThumbs.innerHTML = "";

            images.forEach(obj => {
                const d = document.createElement("div");
                d.className = "color-thumb" + (obj.color === selectedColor ? " selected" : "");
                d.innerHTML = `<img src="${obj.imgs[0]}" width="60">`;

                d.onmouseenter = () => colorName.innerText = obj.color;
                d.onmouseleave = () => colorName.innerText = selectedColor;

                d.onclick = () => {
                    selectedColor = obj.color;
                    selectedSize = "";
                    sizeError.style.display = "none";
                    renderColors();
                    loadColor(selectedColor);
                };

                colorThumbs.appendChild(d);
            });

            colorName.innerText = selectedColor;
        }
        function loadColor(color) {
            const obj = images.find(i => i.color === color);
            const gallery = obj.imgs;

            mainImage.src = gallery[0];
            galleryThumbs.innerHTML = "";

            gallery.forEach((img, i) => {
                const t = document.createElement("img");
                t.src = img;
                t.className = "gallery-thumb" + (i === 0 ? " active" : "");

                t.onclick = () => {
                    mainImage.src = img;
                    document.querySelectorAll(".gallery-thumb").forEach(g => g.classList.remove("active"));
                    t.classList.add("active");
                };

                galleryThumbs.appendChild(t);
            });

            colorName.innerText = selectedColor;
        }
        function renderSizes() {
            sizeContainer.innerHTML = "";
            Object.keys(betweenSizes).forEach(size => {
                const wrap = document.createElement("div");
                wrap.style.display = "flex";
                wrap.style.flexDirection = "column";

                const box = document.createElement("div");
                box.className = "size-box";
                box.innerText = size;

                const sub = document.createElement("div");
                sub.className = "size-subinfo";
                betweenSizes[size].forEach(s => {
                    const sp = document.createElement("span");
                    sp.innerText = s;
                    sub.appendChild(sp);
                });

                box.onclick = () => {
                    document.querySelectorAll(".size-box").forEach(b => b.classList.remove("selected"));
                    document.querySelectorAll(".size-subinfo").forEach(d => d.style.display = "none");
                    box.classList.add("selected");
                    sub.style.display = "block";
                    selectedSize = size;
                    sizeError.style.display = "none";
                };

                wrap.appendChild(box);
                wrap.appendChild(sub);
                sizeContainer.appendChild(wrap);
            });
        }

        addToCart.onclick = () => {
            if (!selectedSize) {
                sizeError.style.display = "block";
                return;
            }
            alert(`Added to cart\nColor: ${selectedColor}\nSize: ${selectedSize}`);
        };
    </script>

</body>

</html>