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

function cartAction() {
    global $connection;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $query = "SELECT * FROM pictures WHERE picture_id=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $picture = $stmt->get_result()->fetch_assoc();

    if (!$picture) {
        echo json_encode(['code' => 'error', 'answer' => 'Error product']);
    } else {

        if ($_GET['cart'] == 'add')
            Cart::addPicture($picture);
        elseif ($_GET['cart'] == 'delete')
            Cart::deletePicture($picture);

        echo json_encode(
            ['code' => 'ok',
                'picture' => $picture,
                'total_count' => Cart::getTotalCount(),
                'count' => Cart::getPictureCount($picture['picture_id']),
                'total_sum' => Cart::getTotalSum()
            ]);
    }
}


