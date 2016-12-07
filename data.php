<?php
class data {
    private $host       = '127.0.0.1';
    private $username   = 'root';
    private $passwd     = '';
    private $dbname     = 'clients';
    private $db;
                
    function __construct() {
        $this->db = new mysqli($this->host, $this->username, $this->passwd, $this->dbname);
    }
    
    function __destruct() {
        $this->db->close();
    }
            
    function page_default() {
        $d = array();
        $d['tpl'] = 'def.html';
        
        return $d;
    }
    
    function page_show_org() {
        $d = array();
        $id = filter_input(INPUT_GET, 'id');
        $d['tpl'] = 'show_org.html';
        $res = $this->db->query("SELECT * FROM work_clients WHERE org_id='$id'");
        $d['org'] = $res->fetch_assoc();
        $d['id'] = $id;
        $res = $this->db->query("SELECT * FROM clients_desc WHERE org_id='$id'");
        if ($res->num_rows>0) {
            $d['desc'] = $res->fetch_assoc();
        } else {
            $d['desc'] = NULL;
        }
        
        $res->free();
        
        return $d;
    }
            
    function post_search() {
        $str = filter_input(INPUT_POST, 'name');
        $res = $this->db->query("SELECT * FROM work_clients WHERE name LIKE '%$str%'");
        $data = $res->fetch_all(MYSQLI_ASSOC);
        $res->free();
        return $data;
    }
}
