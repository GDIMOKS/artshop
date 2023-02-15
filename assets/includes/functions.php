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
    //session_start();
    global $connection;

    $key = generateSalt();
    $hash_key = hash('sha256', $key);

    setcookie('login', $_SESSION['user']->email, time() + 86400, '/');
    setcookie('key', $hash_key,  time() + 86400, '/');

    $query = "UPDATE `users` SET `cookie`=? WHERE `email`=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $hash_key, $_SESSION['user']->email);
    $stmt->execute();
}