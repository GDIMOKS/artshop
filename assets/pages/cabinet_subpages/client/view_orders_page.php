<?php

require_once "../../../includes/classes/user.php";
require_once "../../../includes/classes/order.php";
require_once "../../../includes/classes/product.php";
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
    <title>Ваши заказы</title>

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

    <h1>Ваши заказы</h1>
    <div class="orders">
        <?php
        $query = "SELECT * FROM orders WHERE client_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $_SESSION['user']->id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $orderInfo) {
            $order = new Order($orderInfo);
            $order->printOrder();
        }
        ?>

    </div>




</div>
<script type="module" src="/assets/js/cabinet_functions.js"></script>
<script type="module" src="/assets/js/cabinet/seller/change_order_status.js"></script>

</body>
    </html><?php
