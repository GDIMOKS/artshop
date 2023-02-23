
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
            Текущая дата: <span class="current_time special_text"><?= getDateTime()?></span>
        </div>
    </div>


    <a class="button logout" href="/assets/includes/authentication/logout.php">
        <div class="cabinet_button_text">Выйти из аккаунта</div>
    </a>
</div>

<div class="profile_buttons">
    <?php switch ($_SESSION['user']->getRoleName()): ?><?php case 'Владелец': ?>
        <a class="button check-profit" href="/assets/pages/cabinet_subpages/owner/check_profit_rating_page.php">Просмотр прибыли и рейтинга</a>
    <?php case 'Покупатель': ?>
        <a class="button edit-info" href="/assets/pages/cabinet_subpages/client/edit_data_page.php">Редактирование данных</a>
        <a class="button show-orders" href="/assets/pages/cabinet_subpages/client/view_orders_page.php">Просмотр заказов</a>

        <?php break; ?>

    <?php case 'Продавец+': ?>
        <a class="button edit-info" href="/assets/pages/cabinet_subpages/client/edit_data_page.php">Редактирование данных</a>
        <a class="button show-orders" href="/assets/pages/cabinet_subpages/client/view_orders_page.php">Просмотр заказов</a>
    <?php case 'Продавец': ?>
        <a class="button add-product" href="/assets/pages/cabinet_subpages/seller/add_product_page.php">Добавить товар</a>
        <a class="button update-product" href="/assets/pages/cabinet_subpages/seller/update_product_page.php">Изменить товар</a>
        <a class="button delete-product" href="/assets/pages/cabinet_subpages/seller/delete_product_page.php">Удалить товар</a>
        <a class="button update-status" href="/assets/pages/cabinet_subpages/seller/change_order_status_page.php">Изменить статус заказа</a>

        <?php break; ?>

    <?php endswitch ?>
</div>
