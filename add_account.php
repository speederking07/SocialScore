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
    if(!isset($_REQUEST['pesel']) || !isset($_REQUEST['login']) || !isset($_REQUEST['password']) || !isset($_REQUEST['access'])){
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'Not enough data was passed',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'new_account.php']],]);
    }
    else if ($model->addAccount($_REQUEST['login'], $_REQUEST['password'], $_REQUEST['pesel'], $_REQUEST['access']) == true) {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Success", 'icon' => 'done', 'message' => 'Account '. $_REQUEST['login']. ' was successfully added',
            'buttons' => [['name' => 'Add another', 'icon' => 'replay', 'link' => 'new_account.php'],
                ['name' => 'Change account', 'icon' => 'lock_outline', 'link' => 'logout.php']],]);
    } else {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'Data base error occurred',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'new_account.php']],]);
    }
}