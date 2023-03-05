<?php
require_once './classes/user.php';
require_once './classes/cart.php';
require_once './classes/product.php';

session_start();

require_once './config.php';
require_once './functions.php';

//if (empty($_SESSION['auth']))// || $_SESSION['user']->getRoleName() == 'Продавец')
//{
//    header('Location: /assets/pages/signin_page.php');
//}

error_reporting(-1);

if (isset($_GET['cart'])) {
    switch ($_GET['cart']) {
        case 'delete':
        case 'add':
        cartAction();
            break;

    }
}

if (isset($_POST['cart'])) {
    switch ($_POST['cart']) {
        case 'checkout':
            Cart::checkoutOrder();
            break;
    }
}

?>


