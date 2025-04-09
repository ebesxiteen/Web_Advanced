<?php
// addRecipe.php
header('Content-Type: application/json');
include_once __DIR__ . "/../../controllers/RecipeController.php"; // Đường dẫn đến controller của bạn

// Lấy dữ liệu từ POST
$recipeName    = $_POST['recipe_name'] ?? '';
$description   = $_POST['description'] ?? '';
$ingredientNames     = $_POST['ingredient_name'] ?? [];
$ingredientQuantities = $_POST['ingredient_quantity'] ?? [];
$ingredientUnits     = $_POST['ingredient_unit'] ?? [];

if (empty($recipeName) || empty($ingredientNames) || count($ingredientNames) !== count($ingredientQuantities) || count($ingredientNames) !== count($ingredientUnits)) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ hoặc thiếu nguyên liệu']);
    exit;
}

// Tạo mảng nguyên liệu
$ingredients = [];
for ($i = 0; $i < count($ingredientNames); $i++) {
    $ingredients[] = [
        'name' => trim($ingredientNames[$i]),
        'quantity' => floatval($ingredientQuantities[$i]),
        'unit' => trim($ingredientUnits[$i])
    ];
}

// Gọi controller để lưu dữ liệu
$controller = new RecipeController();
$result = $controller->createRecipe($recipeName, $description, $ingredients);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Lưu công thức thành công']);
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể lưu công thức']);
}