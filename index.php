<?php
require_once "assets/includes/classes/product.php";

session_start();

require_once "assets/includes/config.php";
require_once "assets/includes/functions.php";
require_once "assets/includes/authentication/cookie/cookie.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$config['title']?></title>

        <link rel="stylesheet" href="assets/styles/header.css">
        <link rel="stylesheet" href="assets/styles/main.css">
        <link rel="stylesheet" href="assets/styles/product.css">

        <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

    </head>
    <body>

    <?php
        require_once "assets/includes/header.php";
    ?>
    <?php
    $query = "SELECT * FROM pictures";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//    debug($pictures);
    ?>

    <div class="workspace">
        <div class="products">
            <?php
            foreach ($products as $product) {
                $picture = new Product($product);
                if (!$picture->is_deleted)
                    $picture->printMiniature();
            }
            ?>
        </div>
    </div>

    <script type="text/javascript" src="assets/js/cart.js"></script>
    </body>
</html>

<?php
$connection->close();
?>