<?php
    include_once __DIR__ ."/../../../controllers/RecipeController.php";
    include_once __DIR__ ."/../../../controllers/UnitController.php";
    include_once __DIR__ . "/../../../controllers/ProductController.php";
    include_once __DIR__ ."/../../../views/Admin/include/SucessAddProduct.php";
    
    
    
    $recipeController = new RecipeController();
    $unitController = new UnitController();
    $recipes = $recipeController->getAllRecipes();
    $units = $unitController->getAllUnits();

    $POST['product_name'] = '';
    $POST['final_price'] = '';
    $POST['recipe'] = '';
    $POST['unit'] = '';
    ?>

<div id="addProductModal" class="absolute top-0 left-0 right-0 bottom-0 hidden">
    <div class="bg-gray-100 min-h-screen p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-md shadow-md p-6">
            <!-- Tiêu đề -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between border-b pb-4 mb-4">
                <div>
                    <h1 class="text-xl font-semibold">Add New Product</h1>
                    <p class="text-sm text-gray-500">Vui lòng điền thông tin bên dưới để thêm dữ liệu!</p>
                </div>
                <!-- Product Existing -->
                <div class="mt-4 md:mt-0 flex items-center space-x-2">
                    <button onclick="closeAddProductModal()" class="text-gray-500 focus:outline-none">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Khu vực form chính -->
            <form action="../../views/Admin/php/addProduct.php" method="POST" class="space-y-6">
                <!-- Basic Information -->
                <div>
                    <h2 class="text-lg font-semibold mb-3">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Product Name -->
                        <div>
                            <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">Product
                                Name</label>
                            <input type="text" id="product-name" name="product_name" class="block w-full border border-gray-300 rounded-md py-2 px-3
                     focus:outline-none focus:ring focus:ring-blue-300" placeholder="Enter name" />
                        </div>



                    </div>
                </div>


                <!-- Recipe -->
                <div>
                    <h2 class="text-lg font-semibold mb-3">Recipe</h2>
                    <div class="flex flex-wrap gap-4">
                        <select name="recipe" id="recipe">
                            <option value="">Select a recipe</option>
                            <?php foreach ($recipes as $recipe) { 
                            echo '
                            <option value="' . $recipe->getId() . '">' . $recipe->getRecipeName() . '</option>';
                    }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Unit -->

                <div>
                    <h2 class="text-lg font-semibold mb-3">Unit</h2>
                    <div class="flex flex-wrap gap-4">
                        <select name="unit" id="unit">
                            <option value="">Select a Unit</option>
                            <?php foreach ($units as $unit) { 
                            echo '
                            <option value="' . $unit->getId() . '">' . $unit->getType() . '</option>';
                    }
                            ?>
                        </select>
                    </div>
                </div>




                <!-- Product Pricing -->
                <div>
                    <h2 class="text-lg font-semibold mb-3">Product Pricing</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label for="final-price" class="block text-sm font-medium text-gray-700 mb-1">Final
                                Price</label>
                            <input type="number" id="final-price" name="final_price" class="block w-full border border-gray-300 rounded-md py-2 px-3
                     focus:outline-none focus:ring focus:ring-blue-300" placeholder="0" />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-3">Product Image</h2>
                    <p class="text-sm text-gray-500 mb-2">
                        Ảnh nên có định dạng .jpg hoặc .png, kích thước tối thiểu 300x300 px. <br />
                        Đối với hình ảnh quảng cáo lớn, dùng tối thiểu 1200x1200 px.
                    </p>
                    <input type="file" id="product-image" name="product_image" accept="image/*" class="block w-full text-sm text-gray-500
                 file:mr-4 file:py-2 file:px-4
                 file:rounded file:border-0
                 file:text-sm file:font-semibold
                 file:bg-blue-50 file:text-blue-700
                 hover:file:bg-blue-100" />
                </div>

                <!-- Nút tạo sản phẩm -->
                <div class="pt-4 border-t">
                    <form action="../../views/Admin/php/addProduct.php" method="post" style="display:inline;">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md"
                            value="Create product" name="create_product">
                            Create Product
                        </button>
                    </form>
                </div>

            </form>
        </div>
    </div>
</div>