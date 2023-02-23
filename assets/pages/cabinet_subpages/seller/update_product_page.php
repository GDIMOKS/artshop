<?php
require_once "../../../includes/classes/user.php";
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
    <title>Изменить товар</title>

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

    <div class="update_forms">
        <form class="picture_form">
            <?php
            $query = "SELECT * FROM pictures";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $pictures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            ?>
            <select class="upd_select" style="width: 100%">
                <option value="default">Выберите картину...</option>
                <?php foreach ($pictures as $picture): ?>
                    <option data-id="<?=$picture['picture_id']?>"><?=$picture['name']?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php
        $form = new ProductForm('update_picture_form', 'update_picture_form', 'Изменить товар');
        $form->print();
        ?>
    </div>






</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/seller/update_product.js"></script>
<script type="module" src="/assets/js/cabinet/seller/select_checkbox.js"></script>

</body>
    </html><?php
