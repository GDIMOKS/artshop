<header>
    <div class="header_up">
        <ul>
            <li>
                <a href="/" class="logo"><?=$config['logo']?></a>

            </li>

            <li>
                <a href="/assets/pages/cart_page.php" class="header_button cart-button">
                    <div>Корзина</div>
                    <div id="cart-num"><?=$_SESSION['cart.total_count'] ?? 0 ?></div>
                </a>

                <?php
                    if (!empty($_SESSION['auth'])) {
                        $href = '/assets/pages/cabinet_page.php';
                    } else {
                        $href = '/assets/pages/signin_page.php';
                    }
                ?>

                <a class="header_button cabinet_button" href="<?=$href?>">
                    <div class="cabinet_button_text">Личный кабинет</div>
                </a>
            </li>
        </ul>
    </div>

    <?php
        $query = "SELECT * FROM `categories` WHERE `parentcategory_id` IS NULL";
        $result = $connection->query($query);
        $main_categories = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="header_down">
        <ul>
            <?php foreach ($main_categories as $category): ?>
                <li>
                    <a class="categories_text" href="/assets/pages/categories.php?category=<?=$category['category_id']?>"><?= $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</header>
