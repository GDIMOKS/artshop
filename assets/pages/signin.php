<?php
require_once "../includes/config.php";
require_once "../includes/header.php";
require_once "../includes/auth_form.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
    ?>

    <div class="workspace">
        <form class="auth_reg" name="auth_form">
            <?php
                $form = new Form();
                $form->setInput('Электронная почта', 'email', 'email', 'Введите свой email', 'autofocus');
                $form->setInput('Пароль', 'password', 'password', 'Введите пароль');

                $form->print();
            ?>


            <div class="g-recaptcha" data-sitekey="<?php echo $config['SITE_KEY'] ?>" style="margin: 0px auto 20px; ";></div>

            <button class="button" type="submit">Авторизоваться</button>

            <p class="p_reg">
                У вас нет аккаунта? - <a href="signup.php" class="a_reg">зарегистрируйтесь</a>!
            </p>

        </form>




    </div>
<!--    <script type="module" src="../js/auth.js"></script>-->

    </body>
</html>
