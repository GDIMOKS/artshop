<?php
require_once '../../classes/user.php';

session_start();
require_once '../../config.php';
require_once '../../functions.php';
require_once '../cabinet_functions.php';

error_reporting(-1);

if (isset($_POST['seller_action'])) {
    if ($_POST['seller_action'] == 'change_status') {
        $query = "INSERT INTO orders_statuses (order_id, status_id) VALUES (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $_POST['order_id'] , $_POST['status_id']);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) {
            echo json_encode(['code' => 'OK']);
        } else {
            echo json_encode(['code' => 'ERROR', 'message' => 'Error! Status was not changed!']);
        }
    }
}