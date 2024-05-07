<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đơn Giản</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <header>
        <h1>Trang Chủ</h1>
    </header>

    <?php
    require_once "nav.php";
    ?>
    <main>
        <div class="container">
            <h2>Sản Phẩm Mới</h2>
            <div class="product-box">
                <div class="product">
                    <img src="public/img/hinh1.webp" alt="">
                    <h3>Sản Phẩm 1</h3>
                    <p>Mô tả sản phẩm 1.</p>
                </div>
                <div class="product">
                    <img src="public/img/hinh2.webp" alt="">
                    <h3>Sản Phẩm 2</h3>
                    <p>Mô tả sản phẩm 2.</p>
                </div>
                <div class="product">
                    <img src="public/img/hinh3.webp" alt="">
                    <h3>Sản Phẩm 3</h3>
                    <p>Mô tả sản phẩm 3.</p>
                </div>
                <div class="product">
                    <img src="public/img/hinh4.webp" alt="">
                    <h3>Sản Phẩm 4</h3>
                    <p>Mô tả sản phẩm 4.</p>
                </div>
                <div class="product">
                    <img src="public/img/hinh5.webp" alt="">
                    <h3>Sản Phẩm 5</h3>
                    <p>Mô tả sản phẩm 5.</p>
                </div>
                <div class="product">
                    <img src="public/img/hinh6.webp" alt="">
                    <h3>Sản Phẩm 6</h3>
                    <p>Mô tả sản phẩm 6.</p>
                </div>
            </div>
        </div>
    </main>
    <footer>&copy; 2023 BHZ Co.</footer>

</body>

</html>