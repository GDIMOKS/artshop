<?php
session_start();
require_once "./config.php";
require_once "./functions.php";

$name = $_POST['first_name'];
$email =  $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$role_id = 2;

$query = 'SELECT COUNT(user_id) as total_count FROM users WHERE email = ?';

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user_exist = $result->fetch_assoc();

if ($user_exist['total_count'] == 0) {
    $query = 'INSERT INTO users (first_name, role_id, email, password) VALUES (?, ?, ?, ?)';

    $stmt = $connection->prepare($query);
    $stmt->bind_param("siss", $name, $role_id, $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if (empty($result)) {
        $message = 'Вы успешно зарегистрировались!';
        $output = ['status' => 'OK', 'message' => $message];
    } else {
        $message = 'Во время регистрации произошла ошибка!';
        $output = ['status' => 'ERROR', 'message' => $message];
    }

} else {
    $message = 'Пользователь с таким email уже существует!';
    $output = ['status' => 'ERROR', 'message' => $message];
}

$connection->close();

exit(json_encode($output));
