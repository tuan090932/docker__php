<?php
//session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Sản Phẩm Mới</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
</head>

<body>
    <header class="mb-4">
        <h1 class="text-center">Tạo Sản Phẩm Mới</h1>
    </header>
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

                <h1 style="color:red"><?php
                                        if (isset($_SESSION['statusCreateProduct'])) {
                                            echo $_SESSION['statusCreateProduct'];
                                            unset($_SESSION['statusCreateProduct']);
                                        }
                                        ?></h1>
            </ul>

        </div>
    </nav>
    <main class="container">
        <form action="handleCreateProduct" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price">
            </div>



            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <img src="" class="card-img-top" alt="Preview" style="width: 200px; height: 200px; display: none;">
            </div>

            <div class="form-group">
                <label for="brand_name">Brand:</label>
                <select class="form-control" id="brand_name" name="brand_name">
                    <?php foreach ($Brand as $product) : ?>
                        <option value="<?= $product['name'] ?>"> <?= $product['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="id" value="<?= $finalValue ?>">
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </main>

    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            &copy; 2023 BHZ Co.
        </div>
    </footer>

    <?php
    //require_once "components/footer.php";
    include "../app/Views/components/footer.php";
    ?>

    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewImage = document.querySelector('img.card-img-top');
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
</body>

</html>