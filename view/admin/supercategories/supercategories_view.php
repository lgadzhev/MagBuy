<?php
require_once "../../../controller/admin/supercategories/view_supercategories_controller.php";

//Check if user is blocked
require_once "../../../utility/blocked_user_dir_back.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Supercategories</title>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/remove.admin.js"></script>
</head>
<body>
<div align="center">
    <h2>Supercategories</h2>
    <p>Here you can add, edit or delete supercategories.</p>
    <a href="../admin_panel.php">
        <button class="btn btn-primary">Back to Admin Panel</button>
    </a>
    <a href="supercategories_create.php">
        <button class="btn btn-primary">New Supercategory</button>
    </a>
</div>
<div class="adminMainWindow">
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Options</th>
        </tr>
        <?php
        foreach ($superCats as $superCat) {
            ?>
            <tr id="delId-<?= $superCat['id'] ?>">
                <td><?= $superCat['id'] ?></td>
                <td><?= $superCat['name'] ?></td>
                <td>
                    <a href="supercategories_edit.php?scid=<?= $superCat['id'] ?>">
                        <button class="btn btn-warning">
                            Edit
                        </button>
                    </a>,
                    <button class="btn btn-danger" onclick="deleteSuperCat(<?= $superCat['id'] ?>)">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>