<?php
require_once "product.php";
require_once "user.php";

session_start();

class Order
{
    private $id;
    private $client_id;
    private $seller_id;
    private $amount = 0;
    private $pictures = array();
    private $countOfPictures = 0;
    private $currentStatus = array();
    private $checkoutStatusTime;

    public function __construct($orderInfo = "")
    {
        $this->id = $orderInfo['order_id'] ?? "";
        $this->client_id = $orderInfo['client_id'] ?? "";
        $this->seller_id = $orderInfo['seller_id'] ?? "";
        $this->amount = $orderInfo['amount'] ?? "";

        if ($orderInfo != "") {
            $this->setPictures();
            $this->setCurrentStatus();
            $this->setCheckoutStatus();
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    private function setPictures() {
        global $connection;
        $query = "SELECT 
                    pictures.*, 
                    pictures_orders.count
                  FROM pictures_orders
                  INNER JOIN pictures
                  ON pictures.picture_id = pictures_orders.picture_id
                  WHERE pictures_orders.order_id = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (!$result)
            return;

        foreach ($result as $product) {
            $picture = new Product($product);
            $this->countOfPictures += $product['count'];
            $this->pictures[$picture->id] = ['picture' => $picture, 'count' => $product['count']];
        }
    }

    private function setCurrentStatus() {
        global $connection;
        $query = "SELECT 
                    orders_statuses.time, 
                    statuses.*
                  FROM orders_statuses
                  INNER JOIN statuses
                  ON statuses.status_id = orders_statuses.status_id
                  WHERE
                    orders_statuses.order_id = ? AND
                    orders_statuses.time = (SELECT MAX(time) FROM orders_statuses WHERE order_id=?)";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $this->id, $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $this->currentStatus = $result;

        if (!$result)
            return;

    }

    private function setCheckoutStatus() {
        global $connection;
        $query = "SELECT 
                    orders_statuses.time
                  FROM orders_statuses
                  INNER JOIN statuses
                  ON statuses.status_id = orders_statuses.status_id
                  WHERE
                    orders_statuses.order_id = ? AND
                    statuses.name = 'Оформлен'";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!$result)
            return;

        $this->checkoutStatusTime = $result['time'];
    }

    public function printPictures($action='view') {
        global $config;
        foreach (array_reverse($this->pictures, true) as $id => $picture) {
        ?>
            <a class="product_area" href="#">
                <div class="name_container">
                    <div class="cart_image_container">
                        <img class="mini_image" src="<?=$config['uploads'].$picture['picture']->image?>" alt="<?=$picture['picture']->name?>" class="mini_image">
                    </div>
                    <div class="product_info_container">
                        <div class="text title"><?=$picture['picture']->name?></div>
                    </div>

                </div>
                <div class="cart_container">
                    <div class="count_text_container text product_count_container">
                        Количество: &nbsp;
                        <div class="" id="count-<?=$id?>" style="font-weight: normal;">
                            <?=$picture['count'] ?? 0 ?>
                        </div>
                        &nbsp; штук
                    </div>
                <?php if ($action == 'checkout') :?>
                <div class="cart_buttons">
                    <div class="product_button del-from-cart order_btn_left"  data-id="<?=$id?>">
                        −
                    </div>
                    <div class="product_button add-to-cart order_btn_right"  data-id="<?=$id?>">
                        +
                    </div>

                </div>
                <?php endif; ?>
                    <div class="price_text_container text price">Цена: <?=$picture['picture']->selling_price?> рублей</div>

                </div>
                <div class="text cart_cost_container">Сумма: <?=$picture['picture']->selling_price * $picture['count']?> рублей</div>
            </a>
        <?php
        }
    }

    public function printOrder($action='view') {
    ?>

        <div class="order" <?php if ($action != 'checkout') echo 'data-id="'.$this->id.'"'; ?> >

            <?php if ($action != 'checkout'): ?>
            <div class="order_name text"><?='Заказ №'.$this->id.' от '.$this->checkoutStatusTime?></div>
            <?php endif; ?>
            <?php
            $this->printPictures($action);
            ?>
            <div class="sum_count">
                <div class="text count">Всего товаров: <?=$this->countOfPictures?></div>
                <div class="text sum">Общая сумма: <?=$this->amount?> рублей</div>
            </div>

            <?php if ($action == 'change_status'): ?>
            <button class="button change_status">
                <div>
                    Изменить статус заказа на &nbsp;
                </div>
                <select class="order_select" >
                    <?php
                    global $connection;
                    $query = "SELECT statuses.status_id, statuses.name FROM statuses";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();

                    $statuses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    foreach ($statuses as $status) {
                        echo '<option value="'.$status['status_id'].'"';
                        if ($status['status_id'] == $this->currentStatus['status_id'])
                            echo 'selected';
                        echo '>'.$status['name'].'</option>';
                    }
                    ?>
                </select>
            </button>

            <?php elseif ($action == 'checkout'): ?>
            <button class="button checkout">Оформить заказ</button>
            <?php endif; ?>
        </div>
    <?php
    }
}