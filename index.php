<?php

require_once __DIR__ . '/view/twig.php';

// Sample data
$foo = ['nav' => [
    ['link' => 'e.php', 'name' => 'Alice'],
    ['link' => 'e.php', 'name' => 'Bob'],
    ['link' => 'e.php', 'name' => 'Eve'],
    ],
    'first_name' => "Marek",
    'last_name' => "Bauer",
    'pesel' => "98020703216",
    'birthday' => "1998-02-07",
    'sex' => 'M',
    'deeds' => [
        ['name' => 'littering', 'date' => '1998-02-03', 'points' => '-12', 'id' => '1']
    ],
    'search' => 'Marek',
    'people' => [
        ['pesel' => "dsadasd", 'first_name' => 'M', "last_name" => "Kyouma", 'birthday' => '1998-02-08', 'points' => '21']
    ],
    'title' => 'error',
    'icon' =>'description',
    'message' => 'dasdasdasfafezdefasdeawdaecwacefwafweceawc',
    'buttons' => [
        ['name' => 'OK', 'icon' => 'done', 'link' => 'bla.php'],
        ['name' => 'Cancel', 'icon' => 'done', 'link' => 'bla.php'],
    ],
];

// Render our view
echo $twig->render('report.html.twig', $foo);