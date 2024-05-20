<?php
//session_start();




?>

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

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">

        <a class="navbar-brand" href="<?= BASE_PATH ?>/">Trang Chủ</a>
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
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                        echo '<a class="nav-link" href="/createProduct">Tạo sản phẩm</a>';
                    }
                    ?>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        các loại iphone
                    </a>
                    <div class="dropdown-menu m-0 bg-secondary rounded-0" aria-labelledby="navbarDropdown">
                        <?php
                        foreach ($brands as $brand) {
                        ?>
                            <a class="dropdown-item" href="<?= "/brand/" . $brand['id'] ?>"><?= $brand['name'] ?></a> <?php } ?>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="/search" method="get">
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Tìm kiếm" name="query">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm</button>
            </form>



            <h1><?php echo $_COOKIE['username']; ?></h1>

            <!-- Ô tìm kiếm -->

            <!-- Kết thúc ô tìm kiếm -->
        </div>
    </nav>

    <header class="" style="margin-top: 100px;">
    </header>

    <div class="container">
        <h1 style="color:red">

            <?php
            if (isset($_SESSION['warning'])) {
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
            }
            if (isset($_SESSION['errorMessage'])) {
                echo $_SESSION['errorMessage'];
                unset($_SESSION['errorMessage']);
            }


            if (isset($_SESSION['statusDeleteProduct'])) {
                echo $_SESSION['statusDeleteProduct'];
                unset($_SESSION['statusDeleteProduct']);
            }
            if (isset($_SESSION['statusEditProduct'])) {
                echo $_SESSION['statusEditProduct'];
                unset($_SESSION['statusEditProduct']);
            }

            if (isset($_SESSION['statusInsertCart'])) {
                echo $_SESSION['statusInsertCart'];
                unset($_SESSION['statusInsertCart']);
            }
            ?>


        </h1>


        <img src="/image/tike.jpg" alt="Banner Quảng cáo Shop Sách! 1" style="width:100%;height: 300px;">

        <li class="nav-item">
            <a class="nav-link" href="/logout_post">Đăng xuất</a>
        </li>

        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <?php
                        echo "<img src=\"/{$product['image']}\" alt=\"\" class=\"card-img-top img-thumbnail img-fluid\" style=\"max-width:100%; height:auto;\">";                        ?>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-muted"><?= $product['name'] ?></h3>
                                    <!-- Add the additional price here -->
                                </div>
                                <div class="btn-group">
                                    <a href="/view/<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary align-btn">View</a>
                                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
                                        <a href="/form_editProduct/<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary align-btn">Edit</a>
                                        <a href="/delete/<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary align-btn">Delete</a>
                                    <?php } ?>
                                </div>
                                <h2>giá:</h2>
                                <h1 class="text-muted"><?= $product['price'] ?></h1>
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

    .align-btn {
        height: 36px;
        /* Adjust the height as needed */
        line-height: 36px;
        /* Adjust the line height as needed */
        margin-right: 5px;
        /* Add margin between buttons */
    }
</style>