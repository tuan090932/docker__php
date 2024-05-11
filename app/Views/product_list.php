<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">


    <?php
    require_once "nav.php";
    ?>

</head>





<body>





    <header class="" style="margin-top: 100px;">

    </header>

    <div class="container">
        <img src="/image/tiki.png" alt="Banner Quảng cáo Shop Sách! 1" style="width:100%;">
        <div class="" style="margin-top: 30px;margin-bottom:30px">


            <form action="/product/list/search" method="get" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm sách" aria-label="Search" name="query">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>

            <!-- create a drop dow in order to handle sort price desend and ascend use boostrap -->

        </div>



        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_PATH ?>/logout_post">Đăng xuất</a>
        </li>

        <main class="">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Image</th>
                        <th>Rating</th>
                        <th>Publisher</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                        $bookId = $product['id_book'];
                        $product1 = $product['hinh'];
                        echo "<tr>";
                        echo "<td>{$product['bookname']}</td>";
                        echo "<td>{$product['mota']}</td>";
                        echo "<td><img src=\"/image/{$product1}\" alt=\"\" class=\"img-thumbnail img-fluid\" width=\"200\" height=\"200\"></td>";
                        echo "<td>{$product['rating']}</td>";
                        echo "<td>{$product['nxb']}</td>";
                        echo "<td>{$product['author']}</td>";
                        echo "<td>{$product['price']}</td>";
                        echo "<td>";
                        echo "<div class='btn-group' role='group' aria-label='Basic example'>";
                        echo "<a href='list/delete/{$bookId}' class='btn btn-danger btn-margin'>Delete</a> ";
                        echo "<a href='list/view/{$bookId}' class='btn btn-primary btn-margin'>View</a> ";
                        echo "<a href='list/form_editProduct/{$bookId}' class='btn btn-success btn-margin'>Edit</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>


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