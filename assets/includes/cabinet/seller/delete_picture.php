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
    if ($_POST['seller_action'] == 'delete') {
        $query = "UPDATE pictures SET is_deleted=1  WHERE picture_id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $_POST['picture_id']);
        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            echo json_encode(['code' => 'OK']);
        } else {
            echo json_encode(['code' => 'ERROR', 'message' => 'Error! Product was not deleted!']);
        }
    }
}