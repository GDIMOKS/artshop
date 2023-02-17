<?php
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

    </head>
    <body>

    <?php
        require_once "assets/includes/header.php";
    ?>
    <div class="workspace">
    </div>
    </body>
</html>

<?php
$connection->close();
?>