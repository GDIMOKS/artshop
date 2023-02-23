<?php
function add_and_update($type) {
    global $connection;
    global $config;
}

function checkImage() {
    if (!empty($_FILES['image'])) {
        if ($_FILES['image']['name'] != 'no_image.jpg') {
            $file_name = time() . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], '../../../../media/' . $file_name);
        } else
            $file_name = $_FILES['image']['name'];
    } else {
        $file_name = $_POST['image'];
    }

    return $file_name;
}