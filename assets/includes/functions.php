<?php

function getDateTime() {
    $now = time();
    $days = array(
        'понедельник', 'вторник', 'среда',
        'четверг', 'пятница', 'суббота', 'воскресенье'
    );

    setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
    $date = date(', d.m.Y г., H:i:s');

    $dnum = date('w', strtotime($now));

    return $days[$dnum] . $date;
}

function debug($data){
    echo '<pre>' . print_r($data, 1) . '</pre>';
}




