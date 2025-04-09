<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Nhúng Tailwind CSS từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
    <title>Xem và Sửa Công Thức</title>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <!-- Tiêu đề trang -->
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Xem và Sửa Công Thức</h2>

        <!-- Form hiển thị và chỉnh sửa công thức -->
        <form id="edit-recipe-form" class="space-y-6">
            <!-- Tên công thức -->
            <div>
                <label for="recipe_name" class="block text-sm font-medium text-gray-600 mb-1">
                    Tên công thức
                </label>
                <input type="text" id="recipe_name" name="recipe_name" value="Espresso" required
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Mô tả công thức -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-600 mb-1">
                    Mô tả (tối đa 255 ký tự)
                </label>
                <textarea id="description" name="description" rows="3" maxlength="255"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Nhập mô tả cho công thức">Đây là công thức Espresso cơ bản với hương vị đậm đà...</textarea>
            </div>

            <!-- Danh sách nguyên liệu -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Nguyên liệu
                </label>
                <div id="ingredients" class="space-y-2  h-[150px] overflow-auto">
                    <!-- Nguyên liệu 1 -->
                    <div class="flex space-x-2">
                        <input type="text" name="ingredient_name[]" placeholder="Tên nguyên liệu" value="Coffee Beans"
                            class="flex-1 border rounded-md px-2 py-1" required />
                        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng" value="18"
                            class="w-24 border rounded-md px-2 py-1" required />
                        <select name="ingredient_unit[]" class="w-32 border rounded-md px-2 py-1">
                            <option value="g" selected>g</option>
                            <option value="ml">ml</option>
                            <option value="cup">cup</option>
                            <option value="tbsp">tbsp</option>
                        </select>
                    </div>
                    <!-- Nguyên liệu 2 -->
                    <div class="flex space-x-2">
                        <input type="text" name="ingredient_name[]" placeholder="Tên nguyên liệu" value="Water"
                            class="flex-1 border rounded-md px-2 py-1" required />
                        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng" value="30"
                            class="w-24 border rounded-md px-2 py-1" required />
                        <select name="ingredient_unit[]" class="w-32 border rounded-md px-2 py-1">
                            <option value="ml" selected>ml</option>
                            <option value="g">g</option>
                            <option value="cup">cup</option>
                            <option value="tbsp">tbsp</option>
                        </select>
                    </div>
                </div>
                <!-- Nút thêm nguyên liệu -->
                <button type="button" onclick="addIngredient()" class="mt-3 text-blue-600 hover:underline text-sm">+
                    Thêm nguyên liệu</button>
            </div>

            <!-- Nút cập nhật công thức -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none">
                    Cập nhật công thức
                </button>
            </div>
        </form>
    </div>

    <!-- Script thêm dòng nguyên liệu -->
    <script>
    function addIngredient() {
        const ingredientsDiv = document.getElementById("ingredients");

        const div = document.createElement("div");
        div.className = "flex space-x-2";

        div.innerHTML = `
        <input type="text" name="ingredient_name[]" placeholder="Tên nguyên liệu" class="flex-1 border rounded-md px-2 py-1" required />
        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng" class="w-24 border rounded-md px-2 py-1" required />
        <select name="ingredient_unit[]" class="w-32 border rounded-md px-2 py-1">
          <option value="ml">ml</option>
          <option value="g">g</option>
          <option value="cup">cup</option>
          <option value="tbsp">tbsp</option>
        </select>
      `;
        ingredientsDiv.appendChild(div);
    }

    // Xử lý submit form (demo)
    document.getElementById("edit-recipe-form").addEventListener("submit", function(e) {
        e.preventDefault();
        alert("Công thức đã được cập nhật thành công!");
        // Ở đây bạn có thể thêm logic gọi API hoặc xử lý lưu dữ liệu.
    });
    </script>
</body>

</html>