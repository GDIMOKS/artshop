<?php

function getDateTime() {
    $now = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));
    $days = array(
        'воскресенье', 'понедельник', 'вторник', 'среда',
        'четверг', 'пятница', 'суббота'
    );

    setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
    $date = date(', d.m.Y г., H:i:s');


    return $days[$now] . $date;
}

function debug($data){
    echo '<pre>' . print_r($data, 1) . '</pre>';
}




