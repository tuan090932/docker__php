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
    <header class="" style="margin-top: 100px;"></header>

    <main class="container mt-5">
        <div class="form-group">
            <h1 stype="color:red"><?php
                                    if (isset($_SESSION['errorDeleteBrand'])) {
                                        echo $_SESSION['errorDeleteBrand'];
                                        unset($_SESSION['errorDeleteBrand']); // delete sesion này
                                    }
                                    ?>
            </h1>

            <h1 style="color:chartreuse">

                <?php

                if (isset($_SESSION['sucesssfullDeleteBrand'])) {

                    echo $_SESSION['sucesssfullDeleteBrand'];
                    unset($_SESSION['sucesssfullDeleteBrand']); // delete sesion này
                }
                ?>

            </h1>



            <label for="brand_name">Brand:</label>
            <ul class="list-group" id="brand_list">
                <?php foreach ($brand as $product) : ?>
                    <li class="list-group-item">
                        <?= $product['name'] ?>
                        <a href="deleteBrandByID/<?= $product['id'] ?>" class="btn btn-sm btn-danger float-right">Xóa</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>



        <form action="/postBrand" method="post">
            <div class="mb-3">
                <label for="brand-name" class="form-label">Tên thương hiệu</label>
                <input type="text" class="form-control" id="brand-name" name="nameBrand">
            </div>
            <button type="submit" class="btn btn-primary">
                Thêm thương hiệu
            </button>

        </form>

        <span style="color:red">
            <?php

            //echo $_SESSION['email_erro'];
            // echo $_SESSION['errorBrand'];

            if (isset($_SESSION['errorBrand'])) {
                echo $_SESSION['errorBrand'];
                unset($_SESSION['errorBrand']);
            }


            ?>
        </span>

        <span style="color:chartreuse">
            <?php

            //echo $_SESSION['email_erro'];
            // echo $_SESSION['errorBrand'];
            if (isset($_SESSION['successfullBrand'])) {
                echo $_SESSION['successfullBrand'];
                unset($_SESSION['successfullBrand']);
            }


            ?>
        </span>


    </main>

    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">&copy; 2023 BHZ Co.</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        // Xử lý sự kiện khi nhấn nút Lưu trong modal
        document.getElementById("saveBrandBtn").addEventListener("click", function() {
            var brandName = document.getElementById("brand-name").value;
            // Do something with the brandName, like sending it to the server
            console.log("Tên thương hiệu mới: " + brandName);
            // Submit the form
            document.getElementById("addBrandForm").submit();
            // Đóng modal sau khi lưu
            $('#brandModal').modal('hide');
        });
    </script>
</body>

</html>