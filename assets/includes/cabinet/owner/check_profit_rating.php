<?php
session_start();
require_once '../../config.php';
require_once '../../functions.php';

error_reporting(-1);

if (isset($_POST['owner_action'])) {
    switch ($_POST['owner_action']) {
        case 'rating':
            $begin_date = $_POST['begin_date'];
            $end_date = $_POST['end_date'];

            if ($begin_date == null) {
                $begin_date = date("Y.m.d H:i:s", null);
            }
            if ($end_date == null) {
                $end_date = date("Y.m.d H:i:s");
            }

            $query = "SELECT
                        pictures.picture_id,
                        pictures.name,
                        pictures.imageHREF,
                        SUM(pictures_orders.count * (pictures.selling_price - pictures.purchase_price)) as total_price
                      FROM  pictures
                      INNER JOIN pictures_orders
                      ON pictures_orders.picture_id = pictures.picture_id
                      INNER JOIN orders_statuses
                      ON pictures_orders.order_id = orders_statuses.order_id
                      INNER JOIN statuses
                      ON orders_statuses.status_id = statuses.status_id
                      WHERE orders_statuses.time BETWEEN ? AND ? AND statuses.name = 'Оплачен'
                      GROUP BY pictures.picture_id
                      ORDER BY total_price DESC
                      LIMIT 3";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $begin_date, $end_date);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['code' => 'ok', 'pictures' => $result]);

            break;

        case 'profit':
            $begin_date = $_POST['begin_date'];
            $end_date = $_POST['end_date'];

            if ($begin_date == null) {
                $begin_date = date("Y.m.d H:i:s", null);
            }
            if ($end_date == null) {
                $end_date = date("Y.m.d H:i:s");
            }

            $query = "SELECT
                      SUM(pictures_orders.count * (pictures.selling_price - pictures.purchase_price)) as total_price
                      FROM  pictures
                      INNER JOIN pictures_orders
                      ON pictures_orders.picture_id = pictures.picture_id
                      INNER JOIN orders_statuses
                      ON pictures_orders.order_id = orders_statuses.order_id
                      INNER JOIN statuses
                      ON orders_statuses.status_id = statuses.status_id
                      WHERE orders_statuses.time BETWEEN ? AND ? AND statuses.name = 'Оплачен'";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $begin_date, $end_date);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            echo json_encode(['code' => 'ok', 'total_price' => $result['total_price'] ?? 0]);

            break;

    }
}
?>
<?php
