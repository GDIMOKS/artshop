<?php

require_once "../../../includes/classes/user.php";
require_once "../../../includes/classes/category.php";
require_once "../../../includes/classes/form.php";


session_start();

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (empty($_SESSION['auth']) || $_SESSION['user']->getRoleName() == 'Гость' || $_SESSION['user']->getRoleName() == 'Продавец')
{
    header('Location: /assets/pages/signin_page.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Редактировать даннные</title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/client_cabinet.css">


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
    <div class="edit_forms">
        <?php
        $data_form = new ClientForm('edit_form', 'edit_form', 'Обновить данные');
        $data_form->print();
        $password_form = new Form('password_form')
        ?>

        <form class="password_form" name="password_form">
            <?php
            $form = new Form('password_form');
            $form->setInput('Текущий пароль*', 'password', 'old_password', 'Введите текущий пароль');
            $form->setInput('Новый пароль*', 'password', 'new_password', 'Введите новый пароль');

            $form->print();

            ?>

            <button class="button" type="submit">Сменить пароль</button>

            <div class="error_block"></div>
        </form>
    </div>






</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/client/edit_data.js"></script>

</body>
</html>