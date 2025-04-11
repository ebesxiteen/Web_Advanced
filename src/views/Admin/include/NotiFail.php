<div id="failProductModal" class="absolute top-[-12] left-0 right-0 bottom-0 hidden">

    <div
        class="bg-gray-100 flex flex-col md:flex-row items-center justify-center min-h-screen space-y-4 md:space-y-0 md:space-x-8 p-4">

        <!-- HỘP THÔNG BÁO THÀNH CÔNG -->
        <div class="bg-white w-80 rounded-lg shadow p-6 text-center">
            <!-- Icon check (animation bounce) -->
            <div class="flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-500 animate-bounce" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <!-- Vòng tròn -->
                    <circle cx="12" cy="12" r="9" stroke-width="2" stroke="currentColor" fill="none"></circle>
                    <!-- Dấu check -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4"></path>
                </svg>
            </div>
            <!-- Nội dung -->
            <h2 class="text-xl font-semibold mb-2">Successfully!</h2>
            <p class="text-gray-600 mb-4">Your data has been created</p>
            <button class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                Close
            </button>
        </div>

        <!-- HỘP THÔNG BÁO THẤT BẠI -->
        <div class="bg-white w-80 rounded-lg shadow p-6 text-center">
            <!-- Icon X (animation pulse) -->
            <div class="flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <!-- Vòng tròn -->
                    <circle cx="12" cy="12" r="9" stroke-width="2" stroke="currentColor" fill="none"></circle>
                    <!-- Dấu X -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6"></path>
                </svg>
            </div>
            <!-- Nội dung -->
            <h2 class="text-xl font-semibold mb-2">Failed!</h2>
            <p class="text-gray-600 mb-4">Your data was not created</p>
            <button onclick="closeFailModal()"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                Close
            </button>
        </div>
    </div>
</div>