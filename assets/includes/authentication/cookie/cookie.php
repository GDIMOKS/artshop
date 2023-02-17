<?php
session_start();

require_once __DIR__ . "/cookie_functions.php";
//require_once dirname(__DIR__, 2) . "/classes/user.php";


if (empty($_SESSION['auth'])) {
    $user = checkCookie();

    if (!empty($user)) {
        $_SESSION['auth'] = true;
        $_SESSION['user'] = new User($user);

        updateCookie();
    }
}