<?php
session_start();
require_once "cookie_functions.php";

if (empty($_SESSION['auth'])) {
    $user = checkCookie();

    if (!empty($user)) {
        $_SESSION['auth'] = true;
        $_SESSION['user'] = $user;

        updateCookie();
    }
}