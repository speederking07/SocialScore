<?php

require_once __DIR__ . '/view/twig.php';
require_once __DIR__ . '/controller/NavController.php';

session_start();
// Sample data
$nav = new NavController();
// Render our view
echo $twig->render('about_us.html.twig', ['nav' => $nav->getNav()]);