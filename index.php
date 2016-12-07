<?php
$host       = '127.0.0.1';
$username   = 'root';
$passwd     = '';
$dbname     = 'clients';

$db = new mysqli($host, $username, $passwd, $dbname);

include 'main.html';
?>