<body id="discount" class="bg-gray-50 min-h-screen ">
    <!-- Phần container chính -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Tiêu đề & nút tạo discount mới -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 md:mb-0">Product Discount</h1>
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center shadow-md">
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
                <input type="text" id="searchInput"
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
        <div class="bg-white shadow-md rounded-md h-[500px] overflow-y-scroll">
            <table id="discountTable" class="min-w-full text-left ">
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
                        include __DIR__ ."/../../../../controllers/DiscountController.php";

                        $discountsControllers = new DiscountController();

                        $discounts = $discountsControllers->getAllDiscounts();
                        
                        $today = date('Y-m-d');

                        foreach ($discounts as $discount) {
                            $startDate = $discount->getStartDate();

                            $endDate   = $discount->getEndDate();

                            $today = date('Y-m-d');
                            
                            if ( $today >= $startDate && $today <= $endDate) {
                                $DivActive = '<span class="text-green-700 bg-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                Active
                                </span>';
                            } else {
                                $DivActive = '<span class="text-red-700 bg-red-100 px-3 py-1 rounded-full text-sm font-medium">
                                Inactive
                            </span>';
                            }
                            

                    echo'
                        <tr>
                        <td class="py-3 px-4">'. $discount->getId().'</td>
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
                            '.$DivActive.'
                        </td>
                        <td class="py-3 px-4 text-right">
                        
                        
                        <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium bg-gray-100 px-3 py-1 rounded-full">
                            Edit
                        </button>

                        <button type="submit" 
                        onclick="deleteDiscount('.$discount->getId().')"
                        class="text-red-600 hover:text-red-800 font-medium bg-gray-100 px-3 py-1 rounded-full">
                            Delete
                        </button>
                        
                        </td>
                    </tr>
                        ';
                        }
                    ?>

                </tbody>
            </table>
            <!-- Phân trang -->
            <div class="flex items-center justify-between mt-6">
                <span class="text-sm text-gray-600">
                    <span id="paginationInfo">1 - 10</span>
                </span>
                <div class="flex space-x-2">
                    <button id="prevPage"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Prev</button>
                    <button id="nextPage"
                        class="px-3 py-1 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function deleteDiscount(discountId) {
        if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
            fetch('./php/Discount/deleteDiscount.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: discountId
                    })
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Dữ liệu nhận được:", text);
                    try {
                        // Xóa bỏ khoảng trắng đầu/cuối nếu có
                        const jsonData = JSON.parse(text.trim());
                        return jsonData;
                        console.log("Parsed JSON:", jsonData);
                    } catch (error) {
                        console.error("Lỗi khi parse JSON:", error);
                    }
                })
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload(); // Reload nếu xóa thành công
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đã xảy ra lỗi khi gửi yêu cầu xóa.");
                });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.querySelector('#discountTable tbody');
        const allRows = Array.from(tableBody.querySelectorAll('tr'));
        const paginationInfo = document.getElementById('paginationInfo');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        const rowsPerPage = 5;
        let currentPage = 1;
        let filteredRows = allRows;

        function displayRows(rows, page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            allRows.forEach(row => row.style.display = 'none');
            rows.slice(start, end).forEach(row => row.style.display = '');

            const showingStart = rows.length === 0 ? 0 : start + 1;
            const showingEnd = Math.min(end, rows.length);
            paginationInfo.textContent = `${showingStart} - ${showingEnd} of ${rows.length}`;
        }

        function updatePaginationButtons(rows) {
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage >= totalPages;

            prevBtn.classList.toggle('opacity-50', currentPage === 1);
            nextBtn.classList.toggle('opacity-50', currentPage >= totalPages);
        }

        function goToPage(page, rows) {
            currentPage = page;
            displayRows(rows, currentPage);
            updatePaginationButtons(rows);
        }

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            filteredRows = allRows.filter(row => {
                const discountNameCell = row.querySelectorAll('td')[1];
                return discountNameCell && discountNameCell.textContent.toLowerCase().includes(keyword);
            });

            currentPage = 1;
            goToPage(currentPage, filteredRows);
        }

        searchInput.addEventListener('input', filterTable);

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                goToPage(currentPage - 1, filteredRows);
            }
        });

        nextBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage < totalPages) {
                goToPage(currentPage + 1, filteredRows);
            }
        });

        // Khởi tạo lần đầu
        goToPage(currentPage, filteredRows);
    });
    </script>
</body>