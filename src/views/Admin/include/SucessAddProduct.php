<div id="successProductModal" class="absolute top-[-12] left-0 right-0 bottom-0 hidden">

    <div class="bg-gray-100 flex items-center justify-center min-h-screen">

        <!-- Hộp thông báo thành công -->
        <div class="bg-white w-80 rounded-lg shadow p-6 text-center">
            <!-- Icon check -->
            <div class="flex items-center justify-center mb-4">
                <!-- Icon với animation bounce -->
                <svg class="w-12 h-12 text-green-500 animate-bounce" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <!-- Vòng tròn ngoài -->
                    <circle cx="12" cy="12" r="9" stroke-width="2" stroke="currentColor" fill="none" />
                    <!-- Dấu check -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4" />
                </svg>
            </div>

            <!-- Tiêu đề -->
            <h2 class="text-xl font-semibold mb-2">Successfully!</h2>
            <!-- Nội dung -->
            <p class="text-gray-600 mb-4">Your data has been created</p>
            <!-- Nút đóng -->
            <button onclick="closeSuccessModal()"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                Close
            </button>
        </div>

    </div>
</div>