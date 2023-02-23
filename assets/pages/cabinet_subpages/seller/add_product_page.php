<?php
require_once "../../../includes/classes/user.php";
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
    <title>Добавить товар</title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/select_checkbox.css">
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
    $form = new ProductForm('add_picture_form', 'add_picture_form', 'Добавить товар');
    $form->print();
    ?>





</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/seller/add_product.js"></script>
<script type="module" src="/assets/js/cabinet/seller/select_checkbox.js"></script>

</body>
</html>