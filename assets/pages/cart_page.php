<?php
require_once "../includes/classes/user.php";
require_once "../includes/classes/product.php";
require_once "../includes/classes/cart.php";

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
        <h1>Оформление заказа</h1>
        <div class="order">

            <?php if (isset($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $id => $picture): ?>
                    <a class="product_area" href="#">
                        <div class="name_container">
                            <div class="cart_image_container">
                                <img class="mini_image" src="<?=$config['uploads'].$picture['picture']->image?>" alt="<?=$picture['picture']->name?>" class="mini_image">
                            </div>
                            <div class="product_info_container">
                                <div class="text title"><?=$picture['picture']->name?></div>
                                <div class="product_price_container text"><?=$picture['picture']->selling_price?> рублей</div>
                            </div>

                        </div>
                        <div class="cart_container">
                            <div class="text count_text_container">
                                Количество: &nbsp;
                                <div class="" id="count-<?=$id?>" style="font-weight: normal;">
                                    <?=$picture['count'] ?? 0 ?>
                                </div>
                                &nbsp; штук
                            </div>
                            <div class="cart_buttons">
                                <div class="product_button del-from-cart product_btn_left"  data-id="<?=$id?>">
                                    −
                                </div>
                                <div class="product_button add-to-cart product_btn_right"  data-id="<?=$id?>">
                                    +
                                </div>
                            </div>
                        </div>
                        <div class="text cart_cost_container">Цена: <?=$picture['picture']->selling_price * $picture['count']?> рублей</div>
                    </a>
                <?php endforeach; ?>
            <?php endif;?>
            <div class="sum_count">
                <div class="text count">Всего товаров: <?=$_SESSION['cart.total_count'] ?? 0?></div>
                <div class="text sum">Общая сумма: <?=$_SESSION['cart.total_sum'] ?? 0?> рублей</div>
            </div>
            <button class="button checkout">Оформить заказ</button>
        </div>
    </div>
    <script type="module" src="/assets/js/cart.js"></script>


    </div>

    <script type="module" src="../js/cabinet_functions.js"></script>

    </body>
    </html>
<?php
