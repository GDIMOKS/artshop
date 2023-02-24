<?php

require_once "../includes/classes/user.php";
require_once "../includes/classes/category.php";
require_once "../includes/classes/form.php";
require_once "../includes/classes/product.php";


session_start();

require_once "../includes/config.php";
require_once "../includes/functions.php";


$query = "SELECT * FROM pictures WHERE picture_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $_GET['picture_id']);
$stmt->execute();

$productInfo = $stmt->get_result()->fetch_assoc();

if (!$productInfo)
    header('Location: /');


$picture = new Product($productInfo);
if ($picture->is_deleted == 1)
    header('Location: /');



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$picture->name?></title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
<!--    <link rel="stylesheet" href="/assets/styles/orders.css">-->
    <link rel="stylesheet" href="/assets/styles/product.css">

    <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

</head>
<body>

<?php
require_once "../includes/header.php";
?>

<div class="workspace">

    <?php
    $picture->printFull();
    ?>


</div>
<script type="module" src="/assets/js/cabinet/seller/change_order_status.js"></script>
<script type="text/javascript" src="/assets/js/cart.js"></script>


</body>
</html>
