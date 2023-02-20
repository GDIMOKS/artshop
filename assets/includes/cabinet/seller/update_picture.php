<?php
session_start();
require_once '../../config.php';
require_once '../../functions.php';
require_once '../cabinet_functions.php';
require_once '../../classes/user.php';

error_reporting(-1);

if (isset($_POST['seller_action'])) {
    switch ($_POST['seller_action']) {
        case 'choose':
            $query = "SELECT pictures.*, 
                             authors.first_name, 
                             authors.last_name, 
                             authors.patronymic_name
                        FROM pictures  
                        INNER JOIN authors
                        ON authors.author_id = pictures.author_id
                        WHERE picture_id =?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $_POST['picture_id']);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            $result['imageHREF'] = $config['uploads'] . $result['imageHREF'];

            $authorInfo = [
                'author_id' => $result['author_id'],
                'first_name'=> $result['first_name'],
                'last_name' => $result['last_name'],
                'patronymic_name' => $result['patronymic_name']
                ];
            $result['author'] = new Author($authorInfo);
            $result['author'] = $result['author']->getFullName();

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
            $query = "SELECT COUNT('id') AS `total_count` FROM `pictures` WHERE (`picture_id` = ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("s", $_POST['picture_id']);
            $stmt->execute();

            $is_exist = $stmt->get_result()->fetch_assoc();

            if ($is_exist['total_count'] == 0) {
                exit (json_encode(['code' => 'ERROR', 'message' => 'Такого товара не существует!']));
            }

            $file_name = checkImage();
            $query = "UPDATE pictures 
                      SET name=?, 
                          author_id=?,
                          creation_date=?,
                          count=?,
                          purchase_price=?,
                          selling_price=?,
                          imageHREF=?
                      WHERE picture_id=?";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("sisiiisi",
                $_POST['name'],
                 $_POST['author_id'],
                      $_POST['creation_date'],
                      $_POST['count'],
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