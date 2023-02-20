<header>
    <div class="header_up">
        <nav>
            <ul>
                <li>
                    <a href="/">
                        <p class="logo"><?=$config['logo']?></p>
                    </a>

                </li>

                <li>
                    <a href="/assets/pages/cart.php" class="header_button cart-button">
                        <span>Корзина</span>
                        <span id="cart-num"><?=$_SESSION['cart.count'] ?? 0 ?></span>
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
        </nav>
    </div>

    <?php
        $query = "SELECT * FROM `categories` WHERE `parentcategory_id` IS NULL";
        $result = $connection->query($query);
        $main_categories = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="header_down">

        <nav>
            <ul>
                <?php foreach ($main_categories as $category): ?>
                    <li>
                        <a class="categories_text" href="/assets/pages/categories.php?category=<?=$category['category_id']?>"><?= $category['name'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

    </div>
</header>
