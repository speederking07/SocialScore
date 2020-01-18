<?php


class NavController
{
    public function getNav()
    {
        $res = Array();
        if ($_SESSION['access'] >= 3) {
            array_push($res, ['link' => 'new_account.php', 'name' => 'Add account'],
                ['link' => 'new_person.php', 'name' => 'Add person'], ['link' => 'deed.php', 'name' => 'Process report']);
        }
        if ($_SESSION['access'] >= 2) {
            array_push($res, ['link' => 'search.php', 'name' => 'Search']);
        }
        if ($_SESSION['access'] >= 1) {
            array_push($res, ['link' => 'report.php', 'name' => 'Report deed'],
                ['link' => 'you.php', 'name' => $_SESSION['login']], ['link' => 'logout.php', 'name' => 'Logout']);
        }
        return $res;
    }
}