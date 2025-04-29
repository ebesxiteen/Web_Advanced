<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: ../../../../src/views/Auth/LoginAndSignUp.php?logout=success");
    exit();
}
?>
<header class="z-index-100">
    <div class="container-header">
        <div class="header-top">
            <div class="header-left">
                <span>Chào mừng bạn đến với coffee SGU</span>
                <div class="social-icons">
                    <a href="#" class="social"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <div class="header-right">
                <?php if (isset($_SESSION['user'])): ?>
                <!-- Khi đăng nhập thành công -->
                <div class="my-2 mx-2 d-flex justify-content-center align-items-center position-relative">
                    <div class="mx-2">
                        <span class="title-login">Xin chào <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                    </div>
                    <div class="dropdown">
                        <div class="dropdown-toggle border-spacing-2 " data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrBp4rAadRiXmk6NWl3redkvGJgWGDkBT4vA&s"
                                class="rounded-5" alt="Avatar" width="45px" height="45px">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../../../src/views/Auth/Profile.php">Xem thông tin cá
                                    nhân</a></li>
                            <li><a class="dropdown-item" href="?action=logout">Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                <!-- Khi chưa đăng nhập -->
                <div class="my-2 mx-2 d-flex justify-content-center">
                    <a href="../../../../Web_Advanced_Project/src/views/Auth/LoginAndSignUp.php">
                        <span class="title-login">Đăng nhập</span>
                        <button class="btn btn-login my-2 my-sm-0 mx-2" type="button">
                            <i class="fa-solid fa-user"></i>
                        </button>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="container-fluid">


            <nav class="navbar navbar-expand-lg  bg-dark position-relative rounded rounded-pill p-2">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex  justify-content-around" id="navbarSupportedContent">
                    <div class="list-item-left">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page" href="Home.php?isHome">Trang
                                    chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Giới thiệu</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Sản phẩm
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="image-logo">
                        <!-- <img src="../assets/images/logo_coffee.png" lt=""> -->
                        <img src="../assets/images/logo_coffee.png>
                    </div>
                    <div class=" list-item-right">
                        <ul class="navbar-nav  mb-2 mb-lg-0 ml-2">
                            <li class="nav-item">
                                <a class="nav-link " aria-disabled="true">Dịch vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-disabled="true">Tin tức</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-disabled="true">Liên hệ</a>
                            </li>

                        </ul>
                    </div>
                    <div class="search-cart d-flex justify-content-center align-items-center">

                        <a href="#" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i>
                        </a>

                        <a href="#" class="btn-cart position-relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p class="quantity-cart position-absolute">0</p>
                        </a>
                    </div>

                    <!-- <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->
                </div>
        </div>
        </nav>

    </div>
</header>
<?php
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Đăng xuất thành công!',
                text: 'Bạn đã đăng xuất khỏi hệ thống.',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}
?>