<div class="grid-container">

    <div class="grid-item photo">
        <img class="picture" src="" alt="Обложка картины">
    </div>

    <div class="grid-item file">
        <label>Изображение картины</label>
        <input type="file" name="image" >
    </div>

    <div class="grid-item name">
        <label>Название картины</label>
        <input type="text" name="name" placeholder="Введите название">
    </div>

    <div class="count_date">
        <div class="grid-item count">
            <label>Количество</label>
            <input type="number" name="count" placeholder="Введите количество">
        </div>

        <div class="grid-item date">
            <label>Дата создания</label>
            <input type="date" name="creation_date" placeholder="Введите дату">
        </div>
    </div>

    <div class="prices">
        <div class="grid-item purchase_price">
            <label>Закупочная цена</label>
            <input type="number" name="purchase_price" placeholder="Введите стоимость">
        </div>

        <div class="grid-item selling_price">
            <label>Цена продажи</label>
            <input type="number" name="selling_price" placeholder="Введите стоимость">
        </div>
    </div>




    <div class="category_author">
        <div class="grid-item author">
            <?php
            $query = "SELECT * FROM authors";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $authors = $stmt->get_result()->fetch_all( MYSQLI_ASSOC);
            ?>
            <label>Автор</label>
            <select name="authors" required>
                <?php foreach ($authors as $author): ?>
                <?php
                $full_name = $author['first_name'];
                if ($author['last_name'])
                    $full_name .= " " . $author['last_name'];

                if ($author['patronymic_name'])
                        $full_name .= " " . $author['patronymic_name'];
                ?>
                    <option data-id="<?=$author['id']?>"><?=htmlspecialchars($full_name)?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid-item category">
            <?php
            $query = "SELECT * FROM categories";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $all_categories = array();

            foreach ($categories as $category) {
                $all_categories[] = new Category($category);
            }

            foreach ($all_categories as $category) {
                $category->setChildren($all_categories);
                $category->setAllParents();
            }
            ?>
            <label>Категория</label>
            <div class="checkselect">
                <div class="checkselect-control">
                    <select name="categories" class="form-control"><option></option></select>
                    <div class="checkselect-over"></div>
                </div>
                <div class="checkselect-popup">
                    <?php foreach ($all_categories as $category) {
                        if (!$category->isChild()) {
                            $category->printAsCheckSelect();
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>







</div>
