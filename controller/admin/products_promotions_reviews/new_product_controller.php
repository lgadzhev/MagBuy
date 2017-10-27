<?php

//Autoload to require needed model files
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

//Include cropping image function
require_once '../../../utility/imageCrop.php';

if (isset($_POST['submit'])) {
    $product = new \model\Product();

    //product info
    $product->setTitle(htmlentities($_POST['title']));
    $product->setDescription(htmlentities($_POST['description']));
    $product->setPrice(htmlentities($_POST['price']));
    $product->setQuantity(htmlentities($_POST['quantity']));


    //product images
    $images = array();
//    for ($i = 1; $i < 4; $i++) {
//
//        $imagesDirectory = null;
//        $imageName = "pic$i";
//        $image = new \model\ProductImage();
//
//
//        if (!empty($_FILES[$imageName]['tmp_name'])) {
//
//            $tmpName = $_FILES[$imageName]['tmp_name'];
//
//
//            if (!is_uploaded_file($tmpName)) {
//                //Redirect to Error page
//                header('Location: ../../../view/error/admin_upload_error.php');
//            }
//
//            //Get the uploaded file's type, extension and size
//            $fileFormat = mime_content_type($tmpName);
//            $type = explode("/", $fileFormat)[0];
//            $extension = explode("/", $fileFormat)[1];
//            $fileSize = filesize($tmpName);
//
//
//            //Validate image file - image file below 2MB
//            if ($type == "image" && $fileSize < 2048576) {
//                $uploadTime = microtime();
//                $imagesDirectory = "../../../web/uploads/productImages/$uploadTime.$extension";
//
//            } else {
//                //Redirect to Error page
//                header('Location: ../../../view/error/admin_upload_error.php');
//            }
//
//            $image->setImageUrl($imagesDirectory);
//
//        } else {
//            //Redirect to Error page
//            header('Location: ../../../view/error/admin_upload_error.php');
//        }
//
//        move_uploaded_file($tmpName, $imagesDirectory);
//        cropImage($imagesDirectory, 450);
//
//        $images[] = $image;
//    }

    //product subcategory and specs
    $subcatId = $_POST['subcategory_id'];
    $product->setSubcategoryId(htmlentities($subcatId));
    $specs = array();
    $specsCount = $_POST['specsCount'];

    for ($i = 0; $i < $specsCount; $i++) {
        $specValue = $_POST['specValue-' . $i];
        $specId = $_POST['specValueId-' . $i];
        $specObj = new \model\ProductSpecification($specValue, $specId);
        $specs[] = $specObj;
    }
    //Try to accomplish connection with the database
    try {

        $productDao = \model\database\ProductsDao::getInstance();

        $id = $productDao->createNewProduct($product, $images, $specs);
        if ($id === false) {
            header("Location: ../../../view/error/pdo_error.php");
        } else {
            echo $id;
        }

        header("Location: ../../../view/admin/products_promotions_reviews/products_view.php");

    } catch (PDOException $e) {
        header("Location: ../../../view/error/pdo_error.php");
        die();
    }

} else {
    $subcatDao = \model\database\SubCategoriesDao::getInstance();
    $subcategories = $subcatDao->getAllSubCategories();
}