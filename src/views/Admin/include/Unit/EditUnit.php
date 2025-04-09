<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Nhúng Tailwind CSS từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet">
    <title>Sửa Đơn Vị Tính</title>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Sửa Đơn Vị Tính</h2>

        <form id="edit-unit-form" class="space-y-6">
            <!-- Mã đơn vị (read-only) -->
            <div>
                <label for="unit_code" class="block text-sm font-medium text-gray-600 mb-1">Mã đơn vị</label>
                <input type="text" id="unit_code" name="unit_code" value="DV001" readonly
                    class="w-full border rounded-md px-3 py-2 bg-gray-100 text-gray-700 cursor-not-allowed" />
            </div>

            <!-- Tên đơn vị -->
            <div>
                <label for="unit_name" class="block text-sm font-medium text-gray-600 mb-1">Tên đơn vị</label>
                <input type="text" id="unit_name" name="unit_name" value="Cup" placeholder="VD: Cup, ml, ..." required
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <!-- Mô tả (với giới hạn 255 ký tự) -->
            <div>
                <label for="unit_description" class="block text-sm font-medium text-gray-600 mb-1">
                    Mô tả (tối đa 255 ký tự)
                </label>
                <textarea id="unit_description" name="unit_description" rows="3" maxlength="255"
                    placeholder="Nhập mô tả cho đơn vị"
                    class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">Mô tả về đơn vị tính...
        </textarea>
            </div>

            <!-- Nút cập nhật -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 focus:outline-none">
                    Cập nhật đơn vị
                </button>
            </div>
        </form>
    </div>

    <!-- Script demo xử lý submit form -->
    <script>
    document.getElementById("edit-unit-form").addEventListener("submit", function(e) {
        e.preventDefault();
        // Xử lý logic cập nhật đơn vị tại đây
        alert("Đơn vị đã được cập nhật thành công!");
    });
    </script>
</body>

</html>