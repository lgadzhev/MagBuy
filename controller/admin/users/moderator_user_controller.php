<?php
//Include Error Handler
require_once '../../../utility/error_handler_dir_back.php';

//Include Admin check
require_once '../../../utility/admin_session.php';

//Autoload to require needed model files
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset($_GET['uid'])) {

    //Validation
    if (!($_GET['nrole'] == 1 || $_GET['nrole'] == 2)) {
        header('Location: ../../../view/error/error_400.php');
        die();
    }

    //Try to accomplish connection with the database
    try {
        $userId = $_GET['uid'];
        $newRole = $_GET['nrole'];

        $userDao = \model\database\UserDao::getInstance();
        $userDao->makeUnmakeModUser($userId, $newRole);

        header("Location: ../../../view/admin/users/users_view.php");

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
} else {
    header("Location: ../../../view/error/error_400.php");
    die();
}