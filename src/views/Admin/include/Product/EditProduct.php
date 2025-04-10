    <script>
const product_id = localStorage.getItem('editProductId');
document.getElementById('product_id').value = product_id;
    </script>
    <?php


include_once __DIR__ ."/../../../../controllers/RecipeController.php";
include_once __DIR__ ."/../../../../controllers/UnitController.php";
include_once __DIR__ ."/../../../../controllers/ProductController.php";

$recipeController = new RecipeController();
$unitController = new UnitController();
$productController = new ProductController();

$productId = $_POST['product_id'] ?? 1;

echo $productId;

$product = $productController->getProductById($productId);

if(!$product) {
    echo "Không tìm thấy sản phẩm";
    exit;
}
?>

    <body>

        <form id="addProductForm" method="POST" class="space-y-6 h-[750px] overflow-auto">

            <input id="product_id" type="hidden" name="product_id" />
            <div id=" addProductModal" class=" bg-gray-50 min-h-screen relative h-[600px] overflow-y-scroll">
                <div class=" bg-gray-100 min-h-screen p-4">
                    <div class="max-w-4xl mx-auto bg-white rounded-md shadow-md p-6">
                        <!-- Tiêu đề -->
                        <div
                            class="flex flex-col md:flex-row items-start md:items-center justify-between border-b pb-4 mb-4">
                            <div>
                                <h1 class="text-xl font-semibold">Sửa sản phẩm</h1>
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
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Thông tin cơ bản</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tên sản phẩm -->
                                <div>
                                    <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">Tên
                                        sản
                                        phẩm</label>
                                    <input type="text" id="product-name" name="product_name"
                                        value="<?= htmlspecialchars($product->getProductName()) ?>"
                                        class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring focus:ring-blue-300" />
                                </div>
                            </div>
                        </div>


                        <!-- Recipe -->
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Công thức</h2>
                            <select name="recipe" id="recipe">
                                <option value="">Chọn công thức</option>
                                <?php foreach ($recipeController->getAllRecipes() as $recipe): ?>
                                <option value="<?= $recipe->getId() ?>"
                                    <?= $recipe->getId() == $product->getRecipeId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($recipe->getRecipeName()) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Đơn vị -->
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Đơn vị tính</h2>
                            <select name="unit" id="unit">
                                <option value="">Chọn đơn vị</option>
                                <?php foreach ($unitController->getAllUnits() as $unit): ?>
                                <option value="<?= $unit->getId() ?>"
                                    <?= $unit->getId() == $product->getUnitId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($unit->getType()) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>




                        <!-- Product Pricing -->
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Giá sản phẩm</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <div>
                                    <label for="final-price"
                                        class="block text-sm font-medium text-gray-700 mb-1">Giá</label>
                                    <input value="<?= $product->getPrice() ?>" type="number" id="final-price"
                                        name="final_price" class="block w-full border border-gray-300 rounded-md py-2 px-3
                         focus:outline-none focus:ring focus:ring-blue-300" placeholder="0" />
                                </div>
                            </div>
                        </div>




                        <!-- Hình ảnh sản phẩm -->
                        <div>
                            <h2 class="text-lg font-semibold mb-3">Hình ảnh sản phẩm</h2>
                            <p class="text-sm text-gray-500 mb-2">
                                Ảnh nên có định dạng .jpg hoặc .png, kích thước tối thiểu 300x300 px. <br />
                                Đối với hình ảnh quảng cáo lớn, dùng tối thiểu 1200x1200 px.
                            </p>
                            <?php if ($product->getLinkImage() != ''): ?>
                            <img src="<?= $product->getLinkImage() ?>" alt="Ảnh sản phẩm hiện tại"
                                class="w-32 h-32 object-cover rounded mb-2" />
                            <?php endif; ?>
                            <input type="hidden" name="old_image" value="<?= $product->getLinkImage() ?>" />
                            <input type="file" id="product-image" name="product_image" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>

                        <!-- Nút tạo sản phẩm -->
                        <div class="pt-4 border-t">

                            <button id="save-product" type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md"
                                value="Create product" name="create_product">
                                Cập nhật sản phẩm
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>


        <script>
        document.getElementById("save-product").addEventListener("click", function(event) {
            event.preventDefault();

            const productName = document.getElementById("product-name").value.trim();
            const recipe = document.getElementById("recipe").value;
            const unit = document.getElementById("unit").value;
            const finalPrice = document.getElementById("final-price").value.trim();
            const image = document.getElementById("product-image").files[0];

            // Kiểm tra các trường bắt buộc
            if (!productName) {
                alert("Vui lòng nhập tên sản phẩm.");
                document.getElementById("product-name").focus();
                return;
            }

            if (!recipe) {
                alert("Vui lòng chọn công thức.");
                document.getElementById("recipe").focus();
                return;
            }

            if (!unit) {
                alert("Vui lòng chọn đơn vị.");
                document.getElementById("unit").focus();
                return;
            }

            if (!/^\d+(\.\d+)?$/.test(finalPrice) || parseFloat(finalPrice) <= 0) {
                alert("Vui lòng nhập giá hợp lệ.");
                document.getElementById("final-price").focus();
                return;
            }

            // Tạo FormData và gửi
            const form = document.getElementById("addProductForm");
            const formData = new FormData(form);

            fetch("./php/Product/editProduct.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Phản hồi từ PHP:", text);
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            alert("Cập nhật sản phẩm thành công!");
                            // redirect nếu muốn: window.location.href = "./productList.php";
                        } else {
                            alert("Lỗi: " + data.message);
                        }
                    } catch (err) {
                        alert("Đã xảy ra lỗi khi xử lý phản hồi.");
                    }
                })
                .catch(error => {
                    console.error("Lỗi fetch:", error);
                    alert("Có lỗi xảy ra khi gửi dữ liệu.");
                });
        });
        </script>


    </body>