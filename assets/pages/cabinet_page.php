<?php
require_once "../includes/classes/user.php";
require_once "../includes/classes/category.php";


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
        <?php
        require_once "../includes/cabinet/cabinet_general.php";
        ?>

    </div>

    <script type="module" src="../js/cabinet_functions.js"></script>

    </body>
</html>
