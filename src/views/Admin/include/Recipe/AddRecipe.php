<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
    <title>Thêm Công Thức Pha Chế</title>
</head>

<body class="bg-gray-100 p-6">


    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Thêm Công Thức Pha Chế</h2>

        <form id="recipe-form" class="space-y-6">
            <!-- Tên công thức -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tên công thức</label>
                <input type="text" name="recipe_name"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required />
            </div>

            <!-- Mô tả -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Mô tả</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Nguyên liệu -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nguyên liệu</label>
                <div id="ingredients" class="space-y-2  h-[150px] overflow-auto">
                    <!-- Dòng nguyên liệu -->
                    <div class="flex space-x-2">
                        <input type="text" name="ingredient_name[]" placeholder="Tên nguyên liệu"
                            class="flex-1 border rounded-md px-2 py-1" required />
                        <input type="number" name="ingredient_quantity[]" placeholder="Số lượng"
                            class="w-24 border rounded-md px-2 py-1" required />
                        <select name="ingredient_unit[]" class="w-32 border rounded-md px-2 py-1">
                            <option value="ml">ml</option>
                            <option value="g">g</option>
                            <option value="cup">cup</option>
                            <option value="tbsp">tbsp</option>
                        </select>
                        <button type="button" onclick="removeIngredient(this)"
                            class="text-red-600 hover:underline text-sm bg-red-100 rounded-md px-2 py-1">X</button>
                    </div>
                </div>

                <!-- Nút thêm dòng nguyên liệu -->
                <button type="button" onclick="addIngredient()" class="mt-3 text-blue-600 hover:underline text-sm">+
                    Thêm nguyên liệu</button>
            </div>

            <!-- Nút lưu -->
            <div class="pt-4">
                <button onclick="addRecipe()" type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Lưu công
                    thức</button>
            </div>
        </form>
    </div>

    <!-- Script thêm dòng nguyên liệu -->
    <script>
    document.getElementById("recipe-form").addEventListener("submit", function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const element = document.createElement("div"); // Container cho thông báo

        fetch("./php/RecipeController.php?action=store", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log("Dữ liệu nhận được:", text);
                try {
                    const jsonData = JSON.parse(text.trim());
                    return jsonData;
                } catch (error) {
                    console.error("Lỗi khi parse JSON:", error);
                }
            })
            .then(data => {
                if (!data) return; // Nếu JSON parse lỗi

                if (data.success) {
                    // Gọi NotiSuccess.php
                    element.innerHTML = `<?php echo include __DIR__ . '/../NotiSuccess.php'; ?>`;
                    console.log(data.message);
                    document.getElementById("recipe-form").reset();
                } else {
                    // Gọi NotiFail.php
                    element.innerHTML = `<?php echo include __DIR__ . '/../NotiFail.php'; ?>`;
                    console.error(data.message);
                }

                document.body.appendChild(element);
                setTimeout(() => {
                    element.remove();
                }, 3000);
            })
            .catch(error => {
                console.error("Lỗi gửi dữ liệu:", error);
            });
    });




    function removeIngredient(button) {
        const ingredientDiv = button.parentNode;
        ingredientDiv.remove();
    }

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
        <button type="button" onclick="removeIngredient(this)" class="text-red-600 hover:underline text-sm bg-red-100 rounded-md px-2 py-1">X</button>
      `;
        ingredientsDiv.appendChild(div);
    }

    // Xử lý submit form (demo)
    document.getElementById("recipe-form").addEventListener("submit", function(e) {
        e.preventDefault();
        alert("Công thức đã được lưu!");
        // Ở đây bạn có thể thêm logic gửi dữ liệu về server
    });
    </script>
</body>

</html>