<head>
    <style>
    /* Ẩn các section trong main */
    .content-section {
        display: none;
    }

    /* Hiện section đang active */
    .active-section {
        display: block;
    }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">

        <div class="bg-gray-100 font-sans w-full h-[400px]">
            <div class="flex h-screen">

                <!-- Sidebar -->
                <?php
              include __DIR__ . '/../../../admin/include/Sibar.php';
              ?>

                <main class="flex-1 p-8">


                    <!-- Phần sidebar Thành Trọng -->

                    <!-- Product -->
                    <div id="product" class="content-section   active-section">
                        <?php
                          include __DIR__ . '/../../include/Product/Product.php';
                          ?>
                    </div>

                    <div id="productsAdd" class="content-section">
                        <?php
                          include __DIR__ . '/../../include/Product/AddProduct.php';
                          ?>
                    </div>

                    <div id="productsEdit" class="content-section">

                        <?php
                          include __DIR__ . '/../../include/Product/EditProduct.php';
                          ?>
                    </div>






                    <!-- Discount -->
                    <div id="discounts" class="content-section">
                        <?php
                          include __DIR__ . '/../../include/Discount/Discount.php';
                          ?>
                    </div>

                    <!-- Account -->
                    <div id="account" class="content-section">
                        <?php
                        include __DIR__ . '/../../include/Account/Account.php';
                        ?>
                    </div>

                    <!-- Recipe and Unit -->
                    <div id="recipe" class="content-section">
                        <?php
                        include __DIR__ . "/../../include/Recipe/Recipe.php";
                        ?>
                    </div>


                    <!-- Phần sidebar Thái -->
                    <!-- Statistic -->
                    <div id="statistic" class="content-section">
                        <?php
                        
                        ?>
                    </div>

                    <!-- Orders -->
                    <div id="orders" class="content-section">
                        <?php
                        include __DIR__ . '/../../include/Order/Order.php';
                        ?>
                    </div>

                    <!-- Producer -->
                    <div id="producer" class="content-section">
                        <?php
                        
                        ?>
                    </div>

                    <!-- Ingredient -->
                    <div id="producer" class="content-section">
                        <?php
                        
                        ?>
                    </div>

                    <!-- Import -->
                    <div id="import" class="content-section"></div>
                    <?php
                        
                        ?>
            </div>

            </main>
        </div>
    </div>
    </div>

    <script>
    function switchSection(sectionId) {
        // Lấy tất cả các section con trong main
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.classList.remove('active-section');
        });

        // Hiển thị section tương ứng
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.classList.add('active-section');
        }
    }
    </script>
</body>