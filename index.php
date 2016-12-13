<?php
include 'cfg.php';
include 'data.php';
var_dump($_SERVER);
$data = new data();

$post = filter_input(INPUT_POST, 'submit');
if ($post) {
    $fID = filter_input(INPUT_POST, 'fID');
    $key = array_key_exists($fID, $page_cfg);
    if ($fID && $key) {
        $func = $page_cfg[$fID];
        $d = $data->$func();
        $req_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        header('Location: '.$req_uri);
    } else {
        header('Location: /index.php');
    }
}

$page_type = filter_input(INPUT_GET, 'page');
$page = array_key_exists($page_type, $page_cfg) ? $page_cfg[$page_type] : $page_cfg['def'];
$p = $data->$page();
include 'main.html';