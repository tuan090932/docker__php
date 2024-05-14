<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
    <?php
    //require_once "components/header.php";
    include "../app/Views/components/header.php";

    ?>


</head>





<body>
    <header class="" style="margin-top: 100px;">

    </header>

    <div class="container">
        <img src="/image/tiki.png" alt="Banner Quảng cáo Shop Sách! 1" style="width:100%;">

        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_PATH ?>/logout_post">Đăng xuất</a>
        </li>

        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <?php
                        $bookId = $product['id_book'];
                        $product1 = $product['hinh'];
                        echo "<img src=\"/image/{$product1}\" alt=\"\" class=\"card-img-top img-thumbnail img-fluid\" width=\"200\" height=\"200\">";
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['bookname'] ?></h5>
                            <p class="card-text"><?= $product['mota'] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="list/view/<?= $bookId ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="list/form_editProduct/<?= $bookId ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="list/delete/<?= $bookId ?>" class="btn btn-sm btn-outline-secondary">Delete</a>
                                </div>
                                <small class="text-muted"><?= $product['price'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

<?php
//require_once "components/footer.php";
include "../app/Views/components/footer.php";
?>

</html>

<style>
    .container {
        background-color: #f8f9fa;
        /* Màu nền */
        padding: 20px;
        /* Khoảng cách giữa nội dung và biên của container */
        border-radius: 10px;
        /* Độ cong của góc container */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* Hiệu ứng bóng */
    }
</style>