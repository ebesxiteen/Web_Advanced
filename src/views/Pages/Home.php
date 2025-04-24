<?php

$page = isset($_GET['LoginAndSignUp']) ? 'LoginAndSignUp' : (isset($_GET['page']) ? $_GET['page'] : 'home');
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ .'/../config/head.php' ?>

<body>
    <?php include_once __DIR__ . '/../layout/includes/Header.php'; ?>

    <div class="main-content">
        <?php
        if ($page === 'product-details') {

            include_once __DIR__ . '/../Components/Products/ProductDetails.php';
            include_once   __DIR__ . '/../layout/includes/Footer.php';
        } else {
            include_once __DIR__ . '/../Components/Banner/Banner.php';
            include_once __DIR__ . '/../Components/Products/Products.php';
            include_once __DIR__ . '/../Components/Feature/Feature.php';
            include_once __DIR__ . '/../layout/includes/Footer.php';
        }
        ?>
    </div>
    <?php include_once __DIR__. '/../config/script.php'; ?>
</body>

</html>