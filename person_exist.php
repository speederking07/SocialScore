<?php
require_once __DIR__.'/model/ProfileModel.php';

session_start();
$model = new ProfileModel();
echo $model ->getNameByPesel($_REQUEST['pesel']);