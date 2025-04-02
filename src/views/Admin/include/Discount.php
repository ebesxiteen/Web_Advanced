<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Sử dụng CDN Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title>Product Discount</title>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Phần container chính -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Tiêu đề & nút tạo discount mới -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 md:mb-0">Product Discount</h1>
            <button class="bg-blue-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md flex items-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add New Discount
            </button>
        </div>

        <!-- Thanh tìm kiếm (nếu cần) -->
        <div class="mb-6">
            <div class="relative max-w-sm">
                <input type="text"
                    class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search discount..." />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute top-2 left-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </div>
        </div>

        <!-- Bảng danh sách discount -->
        <div class="bg-white shadow-md rounded-md overflow-hidden">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 font-medium text-gray-700">No</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Discount Name</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Active Period</th>
                        <th class="py-3 px-4 font-medium text-gray-700">Status</th>
                        <th class="py-3 px-4 font-medium text-gray-700 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php
                        include __DIR__ ."/../../../controllers/DiscountController.php";

                        $discountsControllers = new DiscountController();

                        $discounts = $discountsControllers->getAllDiscounts();

                        foreach ($discounts as $discount) {
                        echo'
                        <tr>
                        <td class="py-3 px-4">1</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">

                                <div>
                                    <div class="text-gray-800 font-semibold">'.$discount->getDiscountName().'</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">
                            <div>'.$discount->getStartDate().'</div>
                            <div class="text-gray-400">→ '. $discount->getEndDate().'</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                Active
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">
                                Edit
                            </button>
                        </td>
                    </tr>
                        ';
                        }
                    ?>
                    <!-- Hàng 1 -->
                    <tr>
                        <td class="py-3 px-4">1</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <!-- Ảnh minh họa sản phẩm (nếu có) -->
                                <!-- <img src="https://via.placeholder.com/40" alt="Product Image"
                                    class="w-10 h-10 rounded object-cover" /> -->
                                <div>
                                    <div class="text-gray-800 font-semibold">Ristretto Bianco</div>

                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">
                            <div>01 Oct 2023 08:00 AM</div>
                            <div class="text-gray-400">→ 20 Oct 2023 11:59 PM</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                Active
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>