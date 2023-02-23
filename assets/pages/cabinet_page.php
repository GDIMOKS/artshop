<?php
require_once "../includes/classes/user.php";

session_start();

require_once "../includes/config.php";
require_once "../includes/functions.php";

if (empty($_SESSION['auth']))
{
    header('Location: /assets/pages/signin_page.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Личный кабинет</title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">

        <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
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
                        <?= getDateTime()?>
                    </span>
                </div>
            </div>


            <a class="button logout" href="../includes/authentication/logout.php">
                <div class="cabinet_button_text">Выйти из аккаунта</div>
            </a>
        </div>

        <div class="profile_buttons">
            <?php switch ($_SESSION['user']->getRoleName()): ?><?php case 'Владелец': ?>
                <a class="button check-profit" href="owner_cabinet/check-profit.php">Просмотр прибыли</a>
                <a class="button check-rating" href="owner_cabinet/check-rating.php">Просмотр рейтинга</a>
                <?php break; ?>

            <?php case 'Покупатель': ?>
                <a class="button edit-info">Редактирование данных</a>
                <a class="button show-orders" href="orders.php">Просмотр заказов</a>

                <?php break; ?>

            <?php case 'Продавец+': ?>
                <a class="button edit-info">Редактирование данных</a>
                <a class="button show-orders" href="orders.php">Просмотр заказов</a>
            <?php case 'Продавец': ?>
                <a class="button add-product" href="cabinet_subpages/seller/add_product_page.php">Добавить товар</a>
                <a class="button update-product" href="cabinet_subpages/seller/update_product_page.php">Изменить товар</a>
                <a class="button delete-product" href="cabinet_subpages/seller/delete_product_page.php">Удалить товар</a>
                <a class="button update-status" href="cabinet_subpages/seller/change_order_status_page.php">Изменить статус заказа</a>

                <?php break; ?>

            <?php endswitch ?>
        </div>


    </div>
    <script type="module" src="../js/cabinet_functions.js"></script>

    </body>
</html>
