<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="<?= BASE_PATH ?>/">Trang Chủ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_PATH ?>/product/list">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_PATH ?>/product/create">Thêm Sản Phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Giới Thiệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Liên Hệ</a>
            </li>
        </ul>
        <?php
        session_start(); // Add this line at the beginning of your script
        // Rest of your code...
        if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin']) : ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $_SESSION["username"] ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <p>ID: <?= $_SESSION["id"] ?></p>
                    <p>Username: <?= $_SESSION["username"] ?></p>
                    <p>Email: <?= $_SESSION["email_address"] ?></p>
                    <p>Address: <?= $_SESSION["address"] ?></p>
                    <p>Phone Number: <?= $_SESSION["phone_number"] ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>