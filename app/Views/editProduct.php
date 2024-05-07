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
    <?php
    require_once "nav.php";
    ?>
    <main class="container">
        <form action="<?= BASE_PATH ?>/product/edit" method="post">
            <div class="form-group">
                <label for="bookname">Tên Sản Phẩm:</label>
                <input type="text" class="form-control" id="bookname" name="bookname">
            </div>
            <div class="form-group">
                <label for="mota">Mô Tả:</label>
                <input type="text" class="form-control" id="mota" name="mota">
            </div>

            <div class="row mb-2">
                <label>Hình ảnh</label>
                <br>
                <img src="../uploads/<?= $book['hinh'] ?>" class="card-img-top" alt="..." style="width: 200px; height: 200px;">
                <input type="file" name="hinh" class="mr-1 col-5" value="<?= $book['hinh'] ?>">
            </div>



            <input type="hidden" name="id" value="<?= $finalValue ?>">
            <button type="submit" class="btn btn-primary">Tạo Sản Phẩm</button>
        </form>
    </main>
    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            &copy; 2023 BHZ Co.
        </div>
    </footer>
</body>

</html>