<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Sử dụng CDN Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <title>Add Voucher Discount</title>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Container chính -->
    <div class="max-w-5xl mx-auto p-4 md:p-6 h-[700px] overflow-y-scroll">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-2">
            <a href="#" class="hover:text-gray-700">Home</a>
            <span class="mx-1">/</span>
            <a href="#" class="hover:text-gray-700">Discounts</a>
            <span class="mx-1">/</span>
            <a href="#" class="hover:text-gray-700">Voucher Discount</a>
            <span class="mx-1">/</span>
            <span class="text-gray-700">Add</span>
        </nav>

        <!-- Tiêu đề trang -->
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Add Voucher Discount</h1>

        <!-- Form chính -->
        <form class="space-y-8">
            <!-- BASIC INFORMATION -->
            <div class="bg-white p-6 rounded-md shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Basic Information</h2>
                <p class="text-sm text-gray-500 mb-4">
                    Add the description of the voucher here.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Voucher Name -->
                    <div>
                        <label for="voucherName" class="block text-sm font-medium text-gray-700 mb-1">
                            Voucher Name
                        </label>
                        <input type="text" id="voucherName" name="voucherName" placeholder="e.g. JulyPayday"
                            class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>

                    <!-- Voucher Code -->
                    <!-- <div class="relative">
                        <label for="voucherCode" class="block text-sm font-medium text-gray-700 mb-1">
                            Voucher Code
                        </label>
                        <input type="text" id="voucherCode" name="voucherCode" placeholder="e.g. julyday20"
                            class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div> -->
                </div>

                <!-- Chọn loại khách hàng (All Customer / Specific Customer) -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Who can use this voucher?
                    </label>
                    <div class="flex items-center space-x-4">
                        <!-- All Customer -->
                        <label class="inline-flex items-center group cursor-pointer">
                            <input type="radio" name="customerType" value="all" checked
                                class="form-radio text-orange-500 focus:ring-orange-500" />
                            <span class="ml-2 text-gray-700">All Customer</span>
                            <!-- Tooltip -->
                            <div
                                class="relative ml-2 group-hover:opacity-100 group-hover:scale-100 transition transform origin-left opacity-0 scale-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 cursor-pointer"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zM9 4a1 1 0 102 0 1 1 0 00-2 0zm1 3a1 1 0 00-1 1v2a1 1 0 002 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <!-- Nội dung tooltip -->
                                <div
                                    class="absolute top-5 left-0 bg-gray-800 text-white text-xs rounded py-1 px-2 w-44">
                                    Voucher will be displayed on the website and can be used by all visitors.
                                </div>
                            </div>
                        </label>


                    </div>
                </div>
            </div>

            <!-- ACTIVE PERIOD -->
            <div class="bg-white p-6 rounded-md shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Active Period</h2>
                <p class="text-sm text-gray-500 mb-4">
                    Set the discount period and time range.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                    <!-- Start & End Time -->
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">
                            Start & End Time
                        </label>
                        <div class="flex space-x-2">
                            <input type="date" id="startTime"
                                class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            <input type="date" id="endTime"
                                class="block w-1/2 border border-gray-300 rounded-md py-2 px-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                    </div>


                </div>
            </div>
            <!-- PRODUCT TYPE -->
            <div class="bg-white p-6 rounded-md shadow-sm">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Product Type</h2>
                <p class="text-sm text-gray-500 mb-4">
                    Choose the product range to apply this voucher.
                </p>
                <div class="flex items-center space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="productType" value="all"
                            class="form-radio text-orange-500 focus:ring-orange-500" checked />
                        <span class="ml-2 text-gray-700">All Product</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="productType" value="specific"
                            class="form-radio text-orange-500 focus:ring-orange-500" />
                        <span class="ml-2 text-gray-700">Specific Product</span>
                    </label>
                </div>
            </div>

            <!-- Nút điều hướng -->
            <div class="flex items-center justify-end space-x-4">
                <button type="button" class="text-gray-500 hover:text-gray-700">
                    Cancel
                </button>

                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">
                    Save
                </button>
            </div>
        </form>
    </div>
</body>

</html>