<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
</head>

<body>
    <header>
        <h1>Chi Tiết Sản Phẩm</h1>
    </header>
    <?php
    require_once "nav.php";
    ?>
    <main>
        <div class="container">
            <div class="product-detail">
                <div class="product-image">
                    <img src="<?= BASE_PATH ?>" alt="Product 1">
                </div>
                <div class="product-info">
                    <h2>Tên Sản Phẩm</h2>
                    <p>Mô tả chi tiết về sản phẩm. Sản phẩm này có những đặc điểm nổi bật và phù hợp cho...</p>
                    <p>Giá: <span>$89.99</span></p>
                    <button class="order-button">Đặt Hàng</button>
                </div>
            </div>

            <div class="related-products">
                <h3>Sản Phẩm Liên Quan</h3>
                <div class="product-box">
                    <div class="product">
                        <div class="product-image">
                            <img src="<?= BASE_PATH ?>" alt="Product 2">
                        </div>
                        <div class="product-info">
                            <h4>Tên Sản Phẩm 2</h4>
                            <p>Giá: <span>$79.99</span></p>
                        </div>
                    </div>
                    <div class="product">
                        <div class="product-image">
                            <img src="<?= BASE_PATH ?>" alt="Product 3">
                        </div>
                        <div class="product-info">
                            <h4>Tên Sản Phẩm 3</h4>
                            <p>Giá: <span>$89.99</span></p>
                        </div>
                    </div>
                    <div class="product">
                        <div class="product-image">
                            <img src="<?= BASE_PATH ?>" alt="Product 3">
                        </div>
                        <div class="product-info">
                            <h4>Tên Sản Phẩm 3</h4>
                            <p>Giá: <span>$99.99</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <footer>&copy; 2023 BHZ Co.</footer>
</body>

</html>