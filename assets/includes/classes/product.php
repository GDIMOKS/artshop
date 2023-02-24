<?php

session_start();


class Product
{
    private $id, $name, $creation_date, $purchase_price, $selling_price, $image, $size, $is_deleted;
    private $categories = array();
    private $author = array();
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

    public function setAuthor() {
        global $connection;

        $query = "SELECT 
            categories.name,
            categories.category_id    
          FROM pictures_categories 
          INNER JOIN categories
          ON pictures_categories.category_id = categories.category_id
          WHERE pictures_categories.picture_id = ? AND
                categories.parentcategory_id = 7";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result)
            $this->author = $result->fetch_assoc();
    }

    public function printMiniature($action='view') {
        require_once "user.php";
        global $config;
        $count = $_SESSION['cart'][$this->id]['count'] ?? 0;
    ?>
        <div class="product" >
            <div class="product_image">
                <a href="/assets/pages/product_page.php?picture_id=<?=$this->id?>"><img src="<?=$config['uploads'].$this->image?>" alt="<?=$this->name?>" class="mini_image"></a>
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
        global $config;
        $count = $_SESSION['cart'][$this->id]['count'] ?? 0;
        $this->setAuthor();
        ?>
        <div class="product_page_area">
            <div class="product_page_info_container">
                <div class="text title"><?=$this->name?></div>
                <div class="product_author">Автор: &nbsp;
                    <?php
                    if ($this->author['name'] != '')
                        echo '<a href="/assets/pages/categories_page.php?category_id='.$this->author['category_id'].'">'. $this->author['name'] .'</a>';
                    else
                        echo 'Без автора';
                    ?>
                </div>
            </div>
            <div class="product_name_container">
                <div class="product_image_container">
                    <img class="mini_image" src="<?=$config['uploads'].$this->image?>" alt="<?=$this->name?>" class="mini_image">
                </div>
                <div class="info_of_product">
                    <div class="product_creation_date">
                        Дата создания:
                        <?php
                        if ($this->creation_date != '')
                            echo $this->creation_date;
                        else
                            echo 'неизвестна';
                        ?>
                    </div>
                    <?php if (!$this->is_deleted): ?>
                    <div class="product_page_cart_container">
                        <div class="product_page_buttons">
                            <div class="product_page_btn_left">
                                <div class="product_button card-btn del-from-cart product_page_mini_left_button" data-id="<?=$this->id?>">−</div>
                                <div class="product_count" id="count-<?=$this->id?>"><?=$count?></div>
                                <div class="product_button card-btn add-to-cart" data-id="<?=$this->id?>">+</div>
                            </div>
                            <a class="product_button product_page_btn_right" href="/assets/pages/cart_page.php">В корзину</a>
                        </div>

                    </div>
                    <div class="price_text_container text price">Цена: <span><?=$this->selling_price?></span>  рублей</div>
                    <?php else: ?>
                    <div>Нет в наличии</div>
                    <?php endif; ?>
                </div>



            </div>
        </div>
<?php
    }
}