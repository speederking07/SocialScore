<?php

require_once __DIR__ . "/model/ProfileModel.php";
require_once __DIR__ . "/controller/NavController.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if ($_SESSION['access'] < 1){
    header("Location: login.php");
    die();
}
$model = new ProfileModel();
$pesel = $model ->getPeselByLogin($_SESSION['login']);
if(empty($pesel)){
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
        'title' => "Error", 'icon' => 'error_outline', 'message' => 'You are not a person',
        'buttons' => [['name' => 'Back', 'icon' => 'arrow_back', 'link' => 'index.php']],]);
}
else {
    $param = $model->getProfile($pesel);
    $nav = new NavController();
    $param['nav'] = $nav->getNav();

    echo $twig->render("profile.html.twig", $param);
}