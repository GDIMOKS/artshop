<?php
require_once "product.php";
require_once "user.php";

session_start();

class Cart
{
//    private $total_count = 0;
//    private $total_sum = 0;
//    private $pictures = array();

    public static function getTotalSum() {
        return $_SESSION['cart.total_sum'];
    }

    public static function getTotalCount() {
        return $_SESSION['cart.total_count'];
    }

    public static function getPictures() {
        return $_SESSION['cart'];
    }

    public static function getPictureCount($id) {
        return $_SESSION['cart'][$id]['count'] ?? 0;
    }


    public static function addPicture($pict) {
        $picture = new Product($pict);


        if (isset($_SESSION['cart'][$picture->id])) {
            $_SESSION['cart'][$picture->id]['count']++;
        } else {
            $_SESSION['cart'][$picture->id] = ['picture' => $picture, 'count' => 1];
        }
        if (empty($_SESSION['cart.total_count'])){
            $_SESSION['cart.total_count'] = 1;
            $_SESSION['cart.total_sum'] = $picture->selling_price;
        } else {
            $_SESSION['cart.total_count']++;
            $_SESSION['cart.total_sum'] += $picture->selling_price;
        }
    }

    public static function deletePicture($pict) {
        $picture = new Product($pict);

        if (isset($_SESSION['cart'][$picture->id])) {
            if ($_SESSION['cart'][$picture->id]['count'] > 0) {
                $_SESSION['cart'][$picture->id]['count']--;
                $_SESSION['cart.total_count']--;
                $_SESSION['cart.total_sum'] -= $picture->selling_price;
            }
            if ($_SESSION['cart'][$picture->id]['count'] == 0) {
                unset($_SESSION['cart'][$picture->id]);
            }

            if ($_SESSION['cart.total_count'] < 0) {
                $_SESSION['cart.total_count'] = 0;
                $_SESSION['cart.total_sum'] = 0;
            }
        }
    }

    public static function clearCart() {
        unset($_SESSION['cart']);
        $_SESSION['cart.total_count'] = 0;
        $_SESSION['cart.total_sum'] = 0;
    }

    public static function checkoutOrder() {
        global $connection;
        if (isset($_SESSION['cart'])) {
            if(isset($_SESSION['user'])) {

                $user_id = $_SESSION['user']->id;
                $query = "INSERT INTO orders (client_id, amount) VALUES (?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ii", $user_id,  $_SESSION['cart.total_sum']);
                $stmt->execute();

                $order_id = $connection->insert_id;


                foreach ($_SESSION['cart'] as $id => $product) {
                    $query = "INSERT INTO pictures_orders (order_id, picture_id, count) VALUES (?, ?, ?)";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("iii", $order_id, $id, $product['count']);
                    $stmt->execute();

                    $result = $stmt->get_result();
                }

                $status = 1;

                $query = "INSERT INTO orders_statuses (status_id, order_id) VALUES (?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ii", $status, $order_id);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result) {
                    echo json_encode(['code' => 'error', 'answer' => 'Error product']);
                } else {
                    self::clearCart();
                    echo json_encode(['code' => 'ok', 'answer' => $order_id]);
                }

            }

        }
    }

}