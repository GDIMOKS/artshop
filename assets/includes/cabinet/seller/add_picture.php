<?php
session_start();
require_once '../../config.php';
require_once '../../functions.php';

error_reporting(-1);

if (!empty($_FILES['image'])) {
    if ($_FILES['image']['name'] != 'no_image.jpg') {
        $file_name = time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../../../media/' . $file_name);
    } else
        $file_name = 'no_image.jpg';
} else {
    $file_name = 'no_image.jpg';
}

$query = "SELECT COUNT('id') AS `total_count` FROM `pictures` WHERE (`name` = ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $_POST['name']);
$stmt->execute();

$is_exist = $stmt->get_result()->fetch_assoc();


if ($is_exist['total_count'] != 0) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Такой товар уже существует!']));
}

$query = "INSERT INTO `pictures` (`name`, `author_id`, `creation_date`, `count`, `purchase_price`, `selling_price`, `imageHREF`) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $connection->prepare($query);
$stmt->bind_param("sisidds", $_POST['name'], $_POST['author_id'], $_POST['date'], $_POST['count'] , $_POST['purchase_price'],  $_POST['selling_price'], $file_name);
$stmt->execute();

$result = $stmt->get_result();
if (!empty($result)) {
    exit (json_encode(['code' => 'ERROR', 'message' => 'Ошибка во время добавления товара!']));
} else {
    $query = "SELECT * FROM `pictures` WHERE `name` = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $_POST['name']);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    foreach ($_POST['categories'] as $category) {
        $query = "INSERT INTO `pictures_categories` (`picture_id`, `category_id`) VALUES (?,?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $result['picture_id'], $category);
        $stmt->execute();
    }
    exit (json_encode(['code' => 'ok', 'message' => 'Товар успешно добавлен!','image' => $config['uploads'] . $file_name]));
}
