<?php

require_once "../../../includes/classes/user.php";
require_once "../../../includes/classes/product.php";
require_once "../../../includes/classes/category.php";
require_once "../../../includes/classes/form.php";


session_start();

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (empty($_SESSION['auth']))
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
    <div class="profile_info">
        <div class="profile_status">
            <div>
                <p>
                    Личный кабинет <span class="special_text"><?= $_SESSION['user']->getFullName()?></span>
                </p>
                <p>
                    Статус: <span class="special_text"><?=$_SESSION['user']->getRoleName()?></span>
                </p>
            </div>
            <div class="time_div">
                Текущая дата:
                <span class="current_time special_text">
                        <?=getDateTime()?>
                    </span>
            </div>
        </div>


        <a class="button logout" href="/assets/includes/authentication/logout.php">
            <div class="cabinet_button_text">Выйти из аккаунта</div>
        </a>
    </div>

    <div class="profile_buttons">
        <?php if ($_SESSION['user']->getRoleName() == "Продавец+"): ?>
            <a class="button edit-info">Редактирование данных</a>
            <a class="button show-orders" href="orders.php">Просмотр заказов</a>
        <?php endif;?>
        <a class="button add-product" href="/assets/pages/cabinet_subpages/seller/add_product_page.php">Добавить товар</a>
        <a class="button update-product" href="/assets/pages/cabinet_subpages/seller/update_product_page.php">Изменить товар</a>
        <a class="button delete-product" href="/assets/pages/cabinet_subpages/seller/delete_product_page.php">Удалить товар</a>
        <a class="button update-status" href="/assets/pages/cabinet_subpages/seller/change_order_status_page.php">Изменить статус заказа</a>
    </div>

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
<script type="module" src="/assets/js/cabinet/seller/delete_product.js"></script>

</body>
</html>