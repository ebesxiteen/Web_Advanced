<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <div class="bg-gray-100 font-sans w-full h-[400px]">
            <div class="flex h-screen">
                <!-- Sidebar -->
                <?php
                  include __DIR__ . '/../../../admin/include/Sibar.php';
                ?>

                <!-- Main container chứa nội dung module -->
                <main id="dashboard" class="flex-1 p-8">
                    <div id="module-container">
                        <?php
                        // include __DIR__ . '/../../../admin/include/Product/Product.php';
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Script AJAX để load module -->
    <script>
    // Định nghĩa mapping giữa sectionId và URL endpoint của file PHP
    const moduleEndpoints = {
        product: '/../../include/Product/Product.php',
        productsAdd: '/../../include/Product/AddProduct.php',
        productsEdit: '/../../include/Product/EditProduct.php',
        discounts: '/../../include/Discount/Discount.php',
        discountsAdd: '/../../include/Discount/AddDiscount.php',
        discountsEdit: '/../../include/Discount/EditDiscount.php',
        account: '/../../include/Account/Account.php',
        recipe: '/../../include/Recipe/Recipe.php',


        // statistic: '/path/to/statistic.php', // Thêm đường dẫn tương ứng nếu có
        // orders: '/../../include/Order/Order.php',
        // producer: '/path/to/producer.php', // Cập nhật đường dẫn chính xác
        // ingredient: '/path/to/ingredient.php', // Cập nhật đường dẫn chính xác
        // import: '/path/to/import.php' // Cập nhật đường dẫn chính xác
    };

    async function switchSection(sectionId) {
        const container = document.getElementById('module-container');
        container.innerHTML = ''; // Xóa nội dung cũ

        if (moduleEndpoints[sectionId]) {
            // console.log('Load module:', moduleEndpoints[sectionId]);

            const pageFetch = 'views/Admin' + moduleEndpoints[sectionId];
            try {
                const response = await fetch(pageFetch);
                if (response.ok) {
                    const htmlContent = await response.text();
                    container.innerHTML = htmlContent;
                } else {
                    container.innerHTML = '<p>Lỗi khi tải nội dung: ' + response.status + '.</p>';
                }
            } catch (error) {
                console.error('Error khi load module:', error);
                container.innerHTML = '<p>Lỗi khi tải nội dung!</p>';
            }
        } else {
            container.innerHTML = '<p>Module không tồn tại!</p>';
        }
    }
    </script>
</body>