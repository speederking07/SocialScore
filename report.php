<?php

require_once __DIR__ . "/controller/NavController.php";
require_once __DIR__ . "/model/ReportModel.php";
require_once __DIR__ . '/view/twig.php';

session_start();

if ($_SESSION['access'] < 1){
    header("Location: login.php");
    die();
}
$model = new ReportModel();
$nav = new NavController();
echo $twig->render('report.html.twig', ['nav' => $nav ->getNav(), 'deeds' => $model->getDeedsList()]);