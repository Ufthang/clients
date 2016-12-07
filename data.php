<?php
class data {
    
    function __construct() {
        
    }
    
    function page_default() {
        $d = array();
        $d['tpl'] = 'def.html';
        
        return $d;
    }
    
    function post_search() {
        global $db;
        $str = filter_input(INPUT_POST, 'name');
        $res = $db->query("SELECT * FROM work_clients WHERE name LIKE '%$str%'");
        $data = $res->fetch_all(MYSQLI_ASSOC);
        $res->free();
        return $data;
    }
}
