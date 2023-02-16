<?php

function generateSalt() {
    $salt = '';
    $saltLength = 60; //длина соли
    for($i = 0; $i < $saltLength; $i++) {
        $salt .= chr(mt_rand(33, 126)); //символ из ASCII-table
    }

    return $salt;
}

function updateCookie() {
    global $connection;

    $key = generateSalt();
    $hash_key = hash('sha256', $key);
    $email = $_SESSION['user']->email;

    setcookie('login', $_SESSION['user']->email, time() + 86400, '/');
    setcookie('key', $hash_key,  time() + 86400, '/');

    $query = "UPDATE users SET cookie=? WHERE email=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $hash_key, $email);
    $stmt->execute();
}

function checkCookie() {
    global $connection;
    if (!empty($_COOKIE['login']) && !empty($_COOKIE['key'])) {

        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $_COOKIE['login']);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    }
}
