<?php

require_once __DIR__ . "/controller/NavController.php";
require_once __DIR__ . "/model/ProfileModel.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if ($_SESSION['access'] < 1){
    header("Location: login.php");
    die();
}
else if ($_SESSION['access'] < 2){
    $nav = new NavController();
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
        'title' => "Authorization required", 'icon' => 'lock_outline', 'message' => 'You do not have access to this function',
        'buttons' => [['name' => 'Change profile', 'icon' => 'lock_open', 'link' => 'logout.php']],]);
}
else {
    $model = new ProfileModel();
    $nav = new NavController();
    if (!isset($_GET['person']) )
    {
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Person not found", 'icon' => 'search', 'message' => 'Unable to find this profile',
            'buttons' => [['name' => 'Search another', 'icon' => 'replay', 'link' => 'search.php']],]);
        die();
    }
    $param = $model->getProfile($_GET['person']);
    if(empty($param)){
        echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
            'title' => "Person not found", 'icon' => 'search', 'message' => 'Unable to find this profile',
            'buttons' => [['name' => 'Search another', 'icon' => 'replay', 'link' => 'search.php']],]);
        die();
    }
    $param['nav'] = $nav->getNav();
    echo $twig->render('profile.html.twig', $param);
}