<?php

                include __DIR__ . '/../../../controllers/ProductController.php';
                
                $productController = new ProductController();
                
                $productListItem = $productController->getAllProducts();
                
                function getImagePath($name, $id) {
                    return  $name .'_'. $id ;
                }
                
                
                function getImagePathByName($imageName) {
                    $imageDirectory = 'assets/img/'; 
                    $extensions = ['jpg', 'jpeg', 'png', 'gif']; 
                    
                    foreach ($extensions as $extension) {
                        $fullPath = $imageDirectory . $imageName . '.' . $extension;
                        if (file_exists($fullPath)) {
                            return $fullPath; 
                        }
                    }
                    
                    return null; 
                }

                    if (!empty($productListItem)) {
                    foreach ($productListItem as $product) {
                    // Kiểm tra xem các key có tồn tại hay không
                    $id = $product->getId();
                    $name = $product->getProductName();
                    $price = $product->getPrice();
                    $price = $price *100;
                    $recipeId = $product->getRecipeId();
                    
                    $imgae = getImagePath($name, $id);
                    
                    $imagePath = getImagePathByName($imgae) ? getImagePathByName($imgae) : '#';
                    
                    echo '<tr>
                        <td class="py-2">' . $id . '</td>
                        <td class="py-2 flex items-center">
                            <img src="' . $imagePath . '" alt="' . $name . '" class="w-10 h-10 rounded mr-2">
                            <div>
                                <span class="block">' . $name . '</span>
                            </div>
                        </td>
                        <td class="py-2">' . $price . '</td>
                        <td class="py-2">' . $recipeId . '</td>
                    
                        <td class="py-2">
                            <button onclick="openEditProductModal(' . $id . ')" class="text-blue-500 focus:outline-none">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="../../views/Admin/php/deleteProduct.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value=' . $id . '>
                    <button type="submit" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này không?\')"
                        class="text-red-500 focus:outline-none ml-2">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    </form>
                    </td>
                    </tr>';
                    }
                    } else {
                    echo '<tr>
                        <td colspan="6">No products found.</td>
                    </tr>';
                    }


                    
    ?>