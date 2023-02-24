<?php
require_once "../includes/classes/user.php";
require_once "../includes/classes/product.php";
require_once "../includes/classes/category.php";


session_start();

require_once "../includes/config.php";
require_once "../includes/functions.php";
require_once "../includes/authentication/cookie/cookie.php";

if (empty($_SESSION['user'])) {
    $_SESSION['user'] = new User();
}
$query = "SELECT pictures.*
          FROM pictures
          INNER JOIN pictures_categories
          ON pictures_categories.picture_id = pictures.picture_id
          INNER JOIN categories
          ON categories.category_id = pictures_categories.category_id 
          WHERE pictures.is_deleted = 0 AND categories.category_id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $_GET['category_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$category = $_GET['category_name'];

$products = $result;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$category?></title>

    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/product.css">

    <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

</head>
<body>

<?php
require_once "../includes/header.php";
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

<script type="text/javascript" src="/assets/js/cart.js"></script>
</body>
</html>

<?php
$connection->close();
?>
