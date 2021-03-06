<?php
//Include Error Handler
require_once '../../utility/error_handler.php';

//Autoload to require needed model files
function __autoload($className) {
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}



//Check if request if from AJAX
if (isset($_GET['needle'])) {
//Echo empty JSON if search is empty
    if ($_GET['needle'] == "") {

        echo "{}";
    } else {

        //Try to accomplish connection with the database
        try {

            $searchDao = \model\database\ProductsDao::getInstance();

            $result = $searchDao->searchProduct($_GET['needle']);

            $resultJson = json_encode($result, JSON_UNESCAPED_SLASHES);
            echo $resultJson;


        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header('HTTP/1.1 500 Internal Server Error', true, 500);
            die();
        }

    }

} else {

    if (!trim($_GET['search']) == "") {

        try {
            $searchDao = \model\database\ProductsDao::getInstance();

            $result = $searchDao->searchProductNoLimit($_GET['search']);
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header('HTTP/1.1 500 Internal Server Error', true, 500);
            die();
        }

    } else {

        $result = array();
    }
}