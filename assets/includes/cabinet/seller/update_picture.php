<?php
require_once '../../classes/user.php';

session_start();
require_once '../../config.php';
require_once '../../functions.php';
require_once '../cabinet_functions.php';

error_reporting(-1);

if (isset($_POST['seller_action'])) {
    switch ($_POST['seller_action']) {
        case 'choose':
            $query = "SELECT pictures.*
                        FROM pictures  
                        WHERE picture_id =?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $_POST['picture_id']);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            $result['imageHREF'] = $config['uploads'] . $result['imageHREF'];

            $query = "SELECT category_id FROM pictures_categories WHERE picture_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $_POST['picture_id']);
            $stmt->execute();

            $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($categories as $category) {
                $result['categories'][] = $category['category_id'];
            }

            echo json_encode(['code' => 'OK', 'picture' => $result]);

            break;

        case 'update':
//            $query = "SELECT COUNT('picture_id') AS `total_count` FROM `pictures` WHERE (`picture_id` = ?)";
//            $stmt = $connection->prepare($query);
//            $stmt->bind_param("s", $_POST['picture_id']);
//            $stmt->execute();
//
//            $is_exist = $stmt->get_result()->fetch_assoc();
//
//            if ($is_exist['total_count'] == 0) {
//                exit (json_encode(['code' => 'ERROR', 'message' => 'Такого товара не существует!']));
//            }

            $file_name = checkImage();
            $query = "UPDATE pictures 
                      SET name=?, 
                          creation_date=?,
                          purchase_price=?,
                          selling_price=?,
                          imageHREF=?
                      WHERE picture_id=?";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssiisi",
                $_POST['name'],
                 $_POST['date'],
                      $_POST['purchase_price'],
                      $_POST['selling_price'],
                      $file_name,
                      $_POST['picture_id']
            );
            $stmt->execute();

            $result = $stmt->get_result();
            if (!empty($result)) {
                exit (json_encode(['code' => 'ERROR', 'message' => 'Ошибка во время изменения товара!']));
            } else {
                $query = "DELETE FROM `pictures_categories` WHERE `picture_id` = ?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("s", $_POST['picture_id']);
                $stmt->execute();

                foreach ($_POST['categories'] as $category) {
                    $query = "INSERT INTO `pictures_categories` (`picture_id`, `category_id`) VALUES (?,?)";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("ii", $_POST['picture_id'], $category);
                    $stmt->execute();
                }
                exit (json_encode(['code' => 'OK', 'message' => 'Товар успешно обновлен!', 'mode'=>'update','image' => $config['uploads'] . $file_name]));
            }


            break;
    }
}