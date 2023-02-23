<?php

session_start();

class Product
{
    private $id, $name, $creation_date, $purchase_price, $selling_price, $image, $size, $is_deleted;
    private $categories = array();
    public function __construct($productInfo)
    {
        $this->id = $productInfo['picture_id'];
        $this->name = $productInfo['name'];
        $this->creation_date = $productInfo['creation_date'];
        $this->purchase_price = $productInfo['purchase_price'];
        $this->selling_price = $productInfo['selling_price'];
        $this->image = $productInfo['imageHREF'];
        $this->size = $productInfo['size'];
        $this->is_deleted = $productInfo['is_deleted'];
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

    public function printMiniature($action='view') {
        require_once "user.php";
        global $config;
        $count = $_SESSION['cart'][$this->id]['count'] ?? 0;
    ?>
        <div class="product" >
            <div class="product_image">
                <a href="#"><img src="<?=$config['uploads'].$this->image?>" alt="<?=$this->name?>" class="mini_image"></a>
            </div>
            <div class="product_info">
                <a class="product_name" href="#"><?=$this->name?></a>
                    <div class="product_price">
                    <?=$this->selling_price .' ₽'?>
                    </div>
            </div>

            <div class="product_buttons">
                <?php if ($action =='view' && $_SESSION['user']->getRoleName() != 'Продавец'): ?>
                    <div class="product_btn_left">
                        <div class="product_button card-btn del-from-cart mini_left_button" data-id="<?=$this->id?>">−</div>
                            <div class="product_count" id="count-<?=$this->id?>"><?=$count?></div>
                        <div class="product_button card-btn add-to-cart" data-id="<?=$this->id?>">+</div>
                    </div>
                    <a class="product_button product_btn_right" href="/assets/pages/cart_page.php">В корзину</a>
                <?php elseif ($action == 'delete'):?>
                    <div class="product_button product_btn del-from-db" data-id="<?=$this->id?>">Удалить</div>
                <?php endif; ?>
            </div>
        </div>
    <?php
    }

    public function printFull() {

    }
}