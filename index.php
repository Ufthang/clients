<?php
include 'cfg.php';
include 'data.php';

$host       = '127.0.0.1';
$username   = 'root';
$passwd     = '';
$dbname     = 'clients';

$db = new mysqli($host, $username, $passwd, $dbname);
$data = new data();

$post = filter_input(INPUT_POST, 'submit');
if ($post) {
    $fID = filter_input(INPUT_POST, 'fID');
    if ($fID) {
        $func = $page_cfg[$fID];
        $d = $data->$func();
    } else {
        header('Location: /index.php');
    }
}

$page = isset($_GET['page']) ? $_GET['page'] : 'def';
$page = $page_cfg[$page];
$p = $data->$page();

include 'main.html';