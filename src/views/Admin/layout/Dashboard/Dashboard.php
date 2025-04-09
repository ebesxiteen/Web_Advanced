<div class="bg-gray-100 font-sans w-full h-[400px]">
    <div class="flex h-screen">

        <!-- Sidebar -->
        <?php
        include __DIR__ . '/../../../admin/include/Sibar.php';
        ?>

        <main class="flex-1 p-8">

            <?php
    // Product
        // include __DIR__ . '/../../include/Product/Product.php';
        // include __DIR__ . '/../../include/Product/AddProduct.php';
        // include __DIR__ . '/../../include/Product/EditProduct.php';

    // Discount
        //  include __DIR__ .'/../../include/Discount/Discount.php';
        //  include __DIR__ .'/../../include/Discount/AddDiscount.php ';
        //  include __DIR__ .'/../../include/Discount/EditDiscount.php ';

    // Account
        // include __DIR__ .'/../../include/Account/Account.php';
        // include  __DIR__ .'/../../include/Account/DetailAccount.php';
        
    //Recipe
        // include __DIR__ ."/../../include/Recipe/Recipe.php";
        include __DIR__ ."/../../include/Recipe/AddRecipe.php";
        // include __DIR__ ."/../../include/Recipe/EditRecipe.php";

    //Unit    
        // include __DIR__ ."/../../include/Unit/AddUnit.php";
        // include __DIR__ ."/../../include/Unit/EditUnit.php";


            ?>
        </main>
    </div>
</div>