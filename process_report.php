<?php

require_once __DIR__ . "/controller/NavController.php";
require_once __DIR__ . "/model/ReportModel.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if ($_SESSION['access'] < 1) {
    header("Location: login.php");
    die();
}
$model = new ReportModel();
$nav = new NavController();
if($model->sendReport($_REQUEST['person'], $_REQUEST['deed'], $_REQUEST['desc']) == true) {
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
    'title' => "Success", 'icon' => 'done', 'message' => 'Deed was successfully reported. Thank you',
        'buttons' => [['name' => 'Another report', 'icon' => 'description', 'link' => 'report.php']],]);
}
else {
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
        'title' => "Error", 'icon' => 'error_outline', 'message' => 'Unexpected error occurred',
        'buttons' => [['name' => 'Try again', 'icon' => 'replay', 'link' => 'report.php']],]);
}