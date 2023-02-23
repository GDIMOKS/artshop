<?php

require_once "../includes/classes/user.php";
require_once "../includes/classes/category.php";
require_once "../includes/classes/form.php";


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
    <title>Редактировать даннные</title>

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


    <div class="orders">
        <?php

        ?>

    </div>




</div>
<script type="module" src="/assets/js/cabinet/seller/change_order_status.js"></script>

</body>
</html>
