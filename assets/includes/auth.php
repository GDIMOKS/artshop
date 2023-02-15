<?php
session_start();
require_once "./config.php";
require_once "./functions.php";
require_once "./classes/user.php";

$email =  $_POST['email'];
$password = $_POST['password'];

$query = 'SELECT * FROM `users` WHERE `email` = ?';

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$userResult = $result->fetch_assoc();

$dbPassword = $userResult['password'];

if (password_verify($password, $dbPassword)) {
    $_SESSION['auth'] = true;

    $user = new User($userResult);

    $_SESSION['user'] = $user;

    $_SESSION['message'] = 'Здравствуйте, ' . htmlspecialchars($_SESSION['user']->first_name). '!';
    $output = ['status' => 'OK', 'message' => $_SESSION['message']];

    updateCookie();

} else {
    $_SESSION['message'] = 'Неправильные логин или пароль!';
    $output = ['status' => 'ERROR', 'message' => $_SESSION['message']];
}
$connection->close();

exit(json_encode($output));

?>