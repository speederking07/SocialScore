<?php
require_once __DIR__ . "/controller/NavController.php";
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
    $nav = new NavController();
    exec('C:\xampp\mysql\bin\mysqldump.exe --routines -u root socialscore > sql\backup.sql');
    echo $twig->render('message.html.twig', ['nav' => $nav->getNav(),
        'title' => "Backup finished", 'icon' => 'backup', 'message' => 'Data base was successfully preserved',
        'buttons' => [['name' => 'Download', 'icon' => 'file_download', 'link' => 'sql/backup.sql']],]);
}