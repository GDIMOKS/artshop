<?php

require_once "../../../includes/classes/user.php";
require_once "../../../includes/classes/category.php";
require_once "../../../includes/classes/form.php";


session_start();

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (empty($_SESSION['auth']) || $_SESSION['user']->getRoleName() != 'Владелец')
{
    header('Location: /assets/pages/signin_page.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Просмотр рейтинга и прибыли</title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/orders.css">
    <link rel="stylesheet" href="/assets/styles/product.css">



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
    <div class="profit_rating_area">
        <form class="profit_rating" name="profit_rating">
            <?php
            $form = new Form('profit_rating');
            $form->setInput('Начальная дата', 'date', 'begin_date', '', 'autofocus');
            $form->setInput('Конечная дата', 'date', 'end_date', '');

            $form->print();

            ?>

            <button class="button" name="profit">Посмотреть прибыль</button>
            <button class="button" name="rating">Посмотреть рейтинг</button>

            <div class="error_block"></div>
        </form>

<!--        <div class="order_area">-->
<!---->
<!--        </div>-->
    </div>






</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/owner/check_profit_rating.js"></script>

</body>
</html>
