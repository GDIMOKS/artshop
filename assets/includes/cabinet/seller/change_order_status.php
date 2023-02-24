<?php
require_once '../../classes/user.php';

session_start();
require_once '../../config.php';
require_once '../../functions.php';
require_once '../cabinet_functions.php';

error_reporting(-1);

if (empty($_SESSION['auth']) || ($_SESSION['user']->getRoleName() != 'Продавец' && $_SESSION['user']->getRoleName() != 'Продавец+'))
{
    header('Location: /assets/pages/signin_page.php');
}

if (isset($_POST['seller_action'])) {
    if ($_POST['seller_action'] == 'change_status') {
        $query = "INSERT INTO orders_statuses (order_id, status_id) VALUES (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $_POST['order_id'] , $_POST['status_id']);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) {
            $user_id = $_SESSION['user']->id;
            $query = "UPDATE orders SET seller_id=?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $result = $stmt->get_result();
            if (!$result) {
                echo json_encode(['code' => 'OK']);
            } else {
                echo json_encode(['code' => 'ERROR', 'message' => 'Error! Seller was not pinned!']);
            }
        } else {
            echo json_encode(['code' => 'ERROR', 'message' => 'Error! Status was not changed!']);
        }
    }
}