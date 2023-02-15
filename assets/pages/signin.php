<?php
session_start();
require_once "../includes/config.php";
require_once "../includes/classes/form.php";

if (!empty($_SESSION['auth']))
{
    header('Location: /assets/pages/cabinet.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>

        <link rel="stylesheet" href="/assets/styles/header.css">
        <link rel="stylesheet" href="/assets/styles/main.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="text/javascript" src="/assets/js/jquery-3.6.1.min.js"></script>

    </head>
    <body>

    <?php
    require_once "../includes/header.php";
    ?>

    <div class="workspace">
        <form class="auth_reg" name="auth_form">
            <?php
                $form = new Form('auth_form');
                $form->setInput('Электронная почта', 'email', 'email', 'Введите свой email', 'autofocus');
                $form->setInput('Пароль', 'password', 'password', 'Введите пароль');

                $form->print();
            ?>


            <div class="g-recaptcha" data-sitekey="<?php echo $config['SITE_KEY'] ?>" style="margin: 0px auto 20px; ";></div>

            <button class="button" type="submit">Авторизоваться</button>

            <p class="p_reg">
                У вас нет аккаунта? - <a href="signup.php" class="a_reg">зарегистрируйтесь</a>!
            </p>

            <div class="error_block">

            </div>
        </form>




    </div>
    <script type="module" src="../js/auth.js"></script>

    </body>
</html>
