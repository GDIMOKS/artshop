<header>
    <div class="header_up">
        <nav>
            <a href="/" class="logo"><?=$config['logo']?></a>
            <div class="cartAndCabinet">
                <a href="/assets/pages/cart_page.php" class="cart_button">
                    <span>Корзина</span>
                    <span id="cart-num">0</span>
                </a>
                <a href="/assets/pages/cabinet_page.php" class="cabinet_button">
                    <div class="cabinet_button_text">Личный кабинет</div>
                </a>
            </div>
        </nav>
    </div>
    <div class="header_down">
        <nav>
            <?php
            $query = "SELECT * FROM categories";
            $result = $connection->query($query);
            $categories = $result->fetch_all(MYSQLI_ASSOC);
            $main_categories = array();
            foreach ($categories as $category) {
                $main_categories[] = new Category($category);
            }

            foreach ($main_categories as $category) {
                $category->setChildren($main_categories);
                $category->setAllParents();
            }
            ?>
            <?php foreach ($main_categories as $id => $main_category): ?>
            <?php
            ?>
            <?php endforeach; ?>

            <?php foreach ($main_categories as $id => $main_category): ?>

            <a class="categories_text cat<?=$id+1?>" href="/assets/pages/categories_page.php?category_id=<?=$main_category->id?>&category_name=<?=$main_category->name?>"><?=$main_category->name?></a>
            <div class="extra num<?=$id+1?>">
                <div class="extraMenu">
                    <?php foreach ($main_category->children as $sub_category): ?>
                    <div class="extraMenuItem">
                        <a href="/assets/pages/categories_page.php?category_id=<?=$sub_category->id?>&category_name=<?=$sub_category->name?>" class="nameOfSubCategory"><?=$sub_category->name?></a>
                        <?php foreach ($sub_category->children as $child_category): ?>
                            <a href="/assets/pages/categories_page.php?category_id=<?=$child_category->id?>&category_name=<?=$child_category->name?>"><?=$child_category->name?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        </nav>
    </div>
</header>
