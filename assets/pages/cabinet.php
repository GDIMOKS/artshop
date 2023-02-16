<?php
session_start();
require_once "../includes/config.php";

if (empty($_SESSION['auth']))
{
    header('Location: /assets/pages/signin.php');
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
        <a class="button cabinet_button" href="../includes/authentication/logout.php">
            <div class="cabinet_button_text">Выйти из аккаунта</div>
        </a>

        <div class="current_time">

        </div>

    </div>
    <script type="module" src="../js/cabinet_functions.js"></script>

    </body>
</html>
