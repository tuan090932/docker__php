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
    //include "../app/Views/components/header.php";
    ?>

    <main class="container">
        <form action="<?= BASE_PATH ?>/product/edit" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="bookname">Title:</label>
                <input type="text" class="form-control" id="bookname" name="bookname">
            </div>

            <div class="form-group">
                <label for="mota">Body:</label>
                <input type="text" class="form-control" id="mota" name="mota">
            </div>

            <div class="form-group">
                <label for="Rating">Rating:</label>
                <input type="number" class="form-control" id="Rating" name="Rating">
            </div>

            <div class="form-group">
                <label for="Publisher">Publisher:</label>
                <input type="text" class="form-control" id="Publisher" name="Publisher">
            </div>

            <div class="form-group">
                <label for="Author">Author:</label>
                <input type="text" class="form-control" id="Author" name="Author">
            </div>

            <div class="form-group">
                <label for="Price">Price:</label>
                <input type="number" class="form-control" id="Price" name="Price">
            </div>

            <div class="form-group">
                <label for="Category_Id">Category Id:</label>
                <input type="number" class="form-control" id="Category_Id" name="Category_Id">
            </div>




            <div class="row mb-2">
                <label>Hình ảnh</label>
                <br>
                <img src="../image/<?= $book['hinh'] ?>" class="card-img-top" alt="..." style="width: 200px; height: 200px;">
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

<?php
//require_once "components/footer.php";
include "../app/Views/components/footer.php";
?>

</html>


<script>
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('img.card-img-top').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>