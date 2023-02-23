<?php

require_once "../../../includes/classes/user.php";
require_once "../../../includes/classes/product.php";
require_once "../../../includes/classes/category.php";
require_once "../../../includes/classes/form.php";


session_start();

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (empty($_SESSION['auth']) || $_SESSION['user']->getRoleName() != 'Продавец' || $_SESSION['user']->getRoleName() != 'Продавец+')
{
    header('Location: /assets/pages/signin_page.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Удалить товар</title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/product.css">
    <link rel="stylesheet" href="/assets/styles/seller_cabinet.css">

    <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

</head>
<body>

<?php
require_once "../../../includes/header.php";
?>

<div class="workspace">
    <?php
    require_once "../../../includes/cabinet/cabinet_general.php";
    ?>

    <?php
    $query = "SELECT * FROM pictures WHERE is_deleted = 0";
    $stmt = $connection->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    ?>
    <div class="products">

        <?php foreach ($result as $product) {
            $picture = new Product($product);
            if (!$picture->is_deleted)
                $picture->printMiniature('delete');
        }?>

    </div>




</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/seller/delete_product.js"></script>

</body>
</html>