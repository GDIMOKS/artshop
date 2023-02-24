<?php
require_once "../includes/classes/user.php";
require_once "../includes/classes/product.php";
require_once "../includes/classes/cart.php";
require_once "../includes/classes/order.php";
require_once "../includes/classes/category.php";


session_start();

require_once "../includes/config.php";
require_once "../includes/functions.php";

if (empty($_SESSION['auth']) || $_SESSION['user']->getRoleName() == 'Продавец')
{
    header('Location: /assets/pages/signin_page.php');
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Корзина</title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">
        <link rel="stylesheet" href="/assets/styles/orders.css">
        <link rel="stylesheet" href="/assets/styles/product.css">



        <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
    ?>

    <div class="workspace">

        <?php
        if (isset($_SESSION['cart'])) {
            $order = new Order();
            $order->pictures = $_SESSION['cart'];
            $order->amount = $_SESSION['cart.total_sum'];
            $order->countOfPictures = $_SESSION['cart.total_count'];

            echo '<h1>Оформление заказа</h1>';
            $order->printOrder('checkout');
        }
        ?>

    </div>
    <script type="module" src="/assets/js/cart.js"></script>


    </div>

    <script type="module" src="../js/cabinet_functions.js"></script>

    </body>
    </html>
<?php
