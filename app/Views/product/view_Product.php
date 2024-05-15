<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">

        <a class="navbar-brand" href="/">Trang Chủ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/cart">Giỏ hàng</a>
                </li>
                <li class="nav-item">

                    <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                        echo '<a class="nav-link" href="/editPhone">Chỉnh sữa loại iphone</a>';
                    }
                    ?>
                </li>

            </ul>

        </div>
    </nav>


    <header class="" style="margin-top: 100px;">

    </header>

    <div class="container">
        <div class="product">
            <h2><?php echo $product['name']; ?></h2>
            <p>Price: <?php echo $product['price']; ?></p>
            <?php
            echo "<img src=\"/{$product['image']}\" alt=\"\" class=\"card-img-top img-thumbnail img-fluid\" style=\"width: 300px; height: 300px;\">";
            ?>

            <form action="post_cart" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="user_id" value="<?= $_COOKIE['user_id'] ?>">
                <button type="submit" class="btn btn-primary">Lưu vào giỏ hàng</button>
            </form>

        </div>
    </div>


    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">&copy; 2023 BHZ Co.</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>