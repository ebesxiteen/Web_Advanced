function openAddProductModal() {
  document.getElementById("productList").classList.add("hidden");
  document.getElementById("addProductModal").classList.remove("hidden");
}
function closeAddProductModal() {
  document.getElementById("productList").classList.remove("hidden");
  document.getElementById("addProductModal").classList.add("hidden");
}

function openSuccessModal() {
  closeAddProductModal();
  document.getElementById("successProductModal").classList.remove("hidden");
  event.preventDefault();
}
function closeSuccessModal() {
  document.getElementById("successProductModal").classList.add("hidden");
}

function openFailModal() {
  closeAddProductModal();
  document.getElementById("failProductModal").classList.remove("hidden");
  event.preventDefault();
}
function closeFailModal() {
  document.getElementById("failProductModal").classList.add("hidden");
}

document
  .getElementById("searchForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định

    const formData = new FormData(this);

    fetch("../../views/Admin/php/searchProduct.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("productTableBodySeacrh").innerHTML = data.html;
        document.getElementById("productTableBody").innerHTML = ""; // Xóa dữ liệu cũ
        window.location.href = "../../views/Admin/index.php"; // Chuyển hướng về index.php
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
