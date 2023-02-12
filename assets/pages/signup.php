<?php
require_once "../includes/config.php";
require_once "../includes/header.php";
require_once "../includes/auth_form.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$config['title']?></title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
    ?>

    <div class="workspace">
        <form class="auth_reg" name="auth_form">
            <?php
            $form = new Form();

            $form->setInput('Имя', 'text', 'first_name', 'Введите своё имя');
            $form->setInput('Электронная почта', 'email', 'email', 'Введите свой email', 'autofocus');
            $form->setInput('Подтверждение пароля', 'password', 'password_2', 'Повторно введите пароль');

            $form->print();
            ?>


            <div class="g-recaptcha" data-sitekey="<?php echo $config['SITE_KEY'] ?>" style="margin: 0px auto 20px; ";></div>

            <button class="button" type="submit">Авторизоваться</button>

            <p class="p_reg">
                У вас уже есть аккаунт? - <a href="signin.php" class="a_reg">авторизуйтесь</a>!
            </p>

        </form>




    </div>

    </body>
</html>