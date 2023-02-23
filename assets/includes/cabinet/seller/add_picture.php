<?php
session_start();
require_once '../../config.php';
require_once '../../functions.php';
require_once '../cabinet_functions.php';

error_reporting(-1);

$query = "SELECT COUNT('picture_id') AS `total_count` FROM `pictures` WHERE (`name` = ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $_POST['name']);
$stmt->execute();

$is_exist = $stmt->get_result()->fetch_assoc();


if ($is_exist['total_count'] != 0) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Такой товар уже существует!']));
}
$file_name = checkImage();

$query = "INSERT INTO `pictures` (`name`, `creation_date`, `purchase_price`, `selling_price`, `imageHREF`) VALUES (?, ?, ?, ?, ?)";

$date = (empty($_POST['date'])) ? null : $_POST['date'];
$stmt = $connection->prepare($query);
$stmt->bind_param("ssdds", $_POST['name'], $date, $_POST['purchase_price'],  $_POST['selling_price'], $file_name);
$stmt->execute();

$result = $stmt->get_result();
if (!empty($result)) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Ошибка во время добавления товара!']));
} else {
    $id = $connection->insert_id;
    foreach ($_POST['categories'] as $category) {
        $query = "INSERT INTO `pictures_categories` (`picture_id`, `category_id`) VALUES (?,?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $id, $category);
        $stmt->execute();
    }
    exit (json_encode(['code' => 'OK', 'message' => 'Товар успешно добавлен!','mode'=>'add','image' => $config['uploads'] . $file_name]));
}
