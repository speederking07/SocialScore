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
    if (!isset($_REQUEST['mother'])) $_REQUEST['mother'] = null;
    if (!isset($_REQUEST['father'])) $_REQUEST['father'] = null;
    if (!isset($_REQUEST['middleName'])) $_REQUEST['middleName'] = null;
    if (!isset($_REQUEST['city'])) $_REQUEST['city'] = null;
    if (!isset($_REQUEST['email'])) $_REQUEST['email'] = null;
    if (!isset($_REQUEST['phone'])) $_REQUEST['phone'] = null;
    if (empty($_FILES['photo']) || $_FILES['photo']['error'] != 0) $_REQUEST['photo'] = null;
    else {
        $info = pathinfo($_FILES['photo']['name']);
        $_REQUEST['photo'] = $info['extension'];
    }
    if (!isset($_REQUEST['pesel']) || !isset($_REQUEST['lastName']) || !isset($_REQUEST['firstName'])) {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'Not enough data',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'new_person.php']],]);
    } else if ($model->addPerson($_REQUEST['pesel'], $_REQUEST['mother'], $_REQUEST['father'], $_REQUEST['firstName'],
            $_REQUEST['middleName'], $_REQUEST['lastName'], $_REQUEST['city'], $_REQUEST['email'], $_REQUEST['phone'],
            $_REQUEST['photo']) == true) {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Success", 'icon' => 'done', 'message' => $_REQUEST['firstName'] . ' ' . $_REQUEST['lastName'] . ' has been successfully added',
            'buttons' => [['name' => 'Add another person', 'icon' => 'replay', 'link' => 'new_person.php']],]);
        if (!empty($_REQUEST['photo'])) {
            move_uploaded_file($_FILES['photo']['tmp_name'], 'img/' . $_REQUEST['pesel'] . '.' . $_REQUEST['photo']);
        }
    } else {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Error", 'icon' => 'error_outline', 'message' => 'Data base error occurred',
            'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'new_person.php']],]);
    }
}
