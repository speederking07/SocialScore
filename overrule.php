<?php

require_once __DIR__ . "/controller/NavController.php";
require_once __DIR__ . "/model/AdminModel.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if ($_SESSION['access'] < 1) {
    header("Location: login.php");
    die();
} else if ($_SESSION['access'] < 3) {
    $nav = new NavController();
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
        'title' => "Authorization required", 'icon' => 'lock_outline', 'message' => 'You do not have access to this function',
        'buttons' => [['name' => 'Change profile', 'icon' => 'lock_open', 'link' => 'logout.php']],]);
} else {
    $model = new AdminModel();
    $nav = new NavController();
    if(!isset($_REQUEST['id'])){
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'No id was passed',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'deed.php']],]);
    }
    else if ($model->overruleReport($_REQUEST['id']) == true) {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Success", 'icon' => 'done', 'message' => 'Report was successfully overruled',
            'buttons' => [['name' => 'Process another report', 'icon' => 'replay', 'link' => 'deed.php']],]);
    } else {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'Report has been already processed',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'deed.php']],]);
    }
}