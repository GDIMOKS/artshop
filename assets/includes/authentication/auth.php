<?php
session_start();
require_once "../config.php";
require_once "../functions.php";
require_once "../classes/user.php";
require_once "./cookie/cookie_functions.php";

$email =  $_POST['email'];
$password = $_POST['password'];
$remember_me = $_POST['remember_me'];

$query = 'SELECT * FROM users WHERE email = ?';

$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();

$userResult = $stmt->get_result()->fetch_assoc();

$dbPassword = $userResult['password'];

if (password_verify($password, $dbPassword)) {
    $_SESSION['auth'] = true;

    $user = new User($userResult);

    $_SESSION['user'] = $user;

    $_SESSION['message'] = 'Здравствуйте, ' . htmlspecialchars($_SESSION['user']->first_name). '!';
    $output = ['status' => 'OK', 'message' => $_SESSION['message']];

    if ($remember_me)
        updateCookie();

} else {
    $_SESSION['message'] = 'Неправильные логин или пароль!';
    $output = ['status' => 'ERROR', 'message' => $_SESSION['message']];
}
$connection->close();

exit(json_encode($output));

?>