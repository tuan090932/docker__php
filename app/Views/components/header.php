<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">

    <a class="navbar-brand" href="<?= BASE_PATH ?>/">Trang Chủ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_PATH ?>/product/list">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_PATH ?>/product/create">Thêm Sản Phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thông Tin Cá Nhân</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Liên Hệ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    các loại iphone
                </a>
                <div class="dropdown-menu m-0 bg-secondary rounded-0" aria-labelledby="navbarDropdown">
                    <?php
                    foreach ($brands as $item) {
                        $url = BASE_PATH . "/product/" . strtolower($item['name']);
                    ?>
                        <a class="dropdown-item" href="<?= $url ?>"><?= $item['name'] ?></a>
                    <?php } ?>
                </div>
            </li>
        </ul>
        <form action="/product/list/search" method="get" class="form-inline my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm sách" aria-label="Search" name="query">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
        </form>
    </div>
</nav>