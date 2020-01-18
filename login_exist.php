<?php
require_once __DIR__.'/model/AuthModel.php';

session_start();
$model = new AuthModel();
if($model ->loginExist($_REQUEST['login'])) echo 'true';
else echo 'false';