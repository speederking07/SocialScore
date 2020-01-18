<?php
    session_start();

    $_SESSION['login'] = null;
    $_SESSION['access'] = null;
    header("Location: login.php");