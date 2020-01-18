<?php
require_once __DIR__ . "/model/AuthModel.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if (isset($_SESSION['login'])) {
    header("Location: index.php");
} else if (isset($_POST['login']) && isset($_POST['password'])) {
    $model = new AuthModel();
    $res = $model->login($_POST['login'], $_POST['password']);
    if ($res == 'password') {
        $param = [
            'password_invalid' => true,
            'login' => $_POST['login']
        ];
        echo $twig->render('login.html.twig', $param);
    } else if ($res == 'login') {
        $param = [
            'login_invalid' => true,
        ];
        echo $twig->render('login.html.twig', $param);
    } else {
        $_SESSION['access'] = $res;
        $_SESSION['login'] = $_POST['login'];
        header("Location: index.php");
    }
} else {
    echo $twig->render('login.html.twig');
}