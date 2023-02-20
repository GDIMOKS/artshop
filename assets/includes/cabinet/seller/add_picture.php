<?php
session_start();
require_once '../../config.php';
require_once '../../functions.php';

error_reporting(-1);

$query = "SELECT COUNT('id') AS `total_count` FROM `pictures` WHERE (`name` = ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $_POST['name']);
$stmt->execute();

$is_exist = $stmt->get_result()->fetch_assoc();


if ($is_exist['total_count'] != 0) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Такой товар уже существует!']));
}
$file_name = checkImage();

$query = "INSERT INTO `pictures` (`name`, `author_id`, `creation_date`, `count`, `purchase_price`, `selling_price`, `imageHREF`) VALUES (?, ?, ?, ?, ?, ?, ?)";

$date = (empty($_POST['date'])) ? null : $_POST['date'];
$stmt = $connection->prepare($query);
$stmt->bind_param("sisidds", $_POST['name'], $_POST['author_id'], $date, $_POST['count'] , $_POST['purchase_price'],  $_POST['selling_price'], $file_name);
$stmt->execute();

$result = $stmt->get_result();
if (!empty($result)) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Ошибка во время добавления товара!']));
} else {
    foreach ($_POST['categories'] as $category) {
        $query = "INSERT INTO `pictures_categories` (`picture_id`, `category_id`) VALUES (?,?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $connection->insert_id(), $category);
        $stmt->execute();
    }
    exit (json_encode(['code' => 'OK', 'message' => 'Товар успешно добавлен!','mode'=>'add','image' => $config['uploads'] . $file_name]));
}
