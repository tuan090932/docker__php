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



    <?php
    include "../app/Views/components/header.php";
    ?>
    <header class="" style="margin-top: 100px;">

    </header>



    <main class="container">
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
                    echo "<a href='delete/{$bookId}' class='btn btn-danger btn-margin'>Delete</a> ";
                    echo "<a href='view/{$bookId}' class='btn btn-primary btn-margin'>View</a> ";
                    echo "<a href='form_editProduct/{$bookId}' class='btn btn-success btn-margin'>Edit</a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">&copy; 2023 BHZ Co.</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>