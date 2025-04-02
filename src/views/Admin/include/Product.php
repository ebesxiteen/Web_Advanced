<div class="relative h-full">

    <div id="productList" class="bg-gray-100 p-8 rounded-r-lg ">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-semibold">Products</h2>
                <p class="text-xs text-gray-500">Home / Products / Product List</p>
            </div>

        </header>

        <div class="flex justify-between items-center mb-6">

            <div class="flex items-center border rounded">
                <form id="searchForm" method="post">

                    <input name="searchKeyword" type="text" placeholder="Search name product"
                        class="border-0 p-2 focus:outline-none">
                    <button type="submit" id="searchButton" name="searchButton"
                        class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                        <i class="fas fa-search text-gray-500 mr-2">
                        </i>
                    </button>

                </form>


            </div>
            <div class="flex items-center">
                <!-- <button class="bg-gray-200 px-4 py-2 rounded mr-2">Filter</button> -->

                <button onclick="openAddProductModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add New Product</button>
            </div>
        </div>
        <hr>
        <div class="h-[500px] overflow-y-scroll">

            <table id="productTable" class="w-full ">
                <thead>
                    <tr>
                        <th class="text-left py-2">Id</th>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Price</th>
                        <th class="text-left py-2">RecipeID</th>

                        <th class="text-left py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php
                    include __DIR__ ."/../php/loadProduct.php";
                    ?>
                </tbody>
                <tbody id="productTableBodySeacrh">

                </tbody>
            </table>
        </div>
    </div>



    <?php
    include __DIR__ .'/../../../views/Admin/include/AddProduct.php';
    ?>


</div>