<?php

$page = isset($_GET['LoginAndSignUp']) ? 'LoginAndSignUp' : (isset($_GET['page']) ? $_GET['page'] : 'home');
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../config/head.php' ?>

<body>
    <?php include '../layout/includes/Header.php'; ?>

    <div class="main-content">
        <?php
        if ($page === 'product-details') {

            include '../Components/Products/ProductDetails.php';
            include '../layout/includes/Footer.php';
        } else {
            include '../Components/Banner/Banner.php';
            include '../Components/Products/Products.php';
            include '../Components/Feature/Feature.php';
            include '../layout/includes/Footer.php';
        }
        ?>
    </div>
    <?php include '../config/script.php'; ?>
</body>

</html>