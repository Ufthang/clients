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
        $d = [];
        $id = filter_input(INPUT_GET, 'id');
        $d['id'] = $id;
        $d['tpl'] = 'show_org.html';
        $res = $this->db->query("SELECT * FROM work_clients WHERE org_id='$id'");
        $d['org'] = $res->fetch_assoc();
        $res = $this->db->query("SELECT * FROM clients_desc WHERE org_id='$id'");
        if ($res->num_rows>0) {
            $d['desc'] = $res->fetch_all(MYSQLI_ASSOC);
        } else {
            $d['desc'] = NULL;
        }
        $res = $this->db->query("SELECT * FROM contacts WHERE org_id='$id'");
        if ($res->num_rows>0) {
            $d['cont'] = $res->fetch_all(MYSQLI_ASSOC);
        } else {
            $d['cont'] = NULL;
        }
        $d['data'] = date('Y-m-d');
        $d['datatime'] = date('Y-m-d h:i');
        $res->free();
        return $d;
    }
    
    function page_add_contact() {
        $d = [];
        $id = filter_input(INPUT_GET, 'id');
        $d['id'] = $id;
        $d['tpl'] = 'add_contact.html';
        $res = $this->db->query("SELECT name FROM work_clients WHERE org_id='$id'");
        $d['name'] = $res->fetch_assoc();
        $d['data'] = date('Y-m-d');
        return $d;
    }
            
    function post_search() {
        $str = filter_input(INPUT_POST, 'name');
        $res = $this->db->query("SELECT * FROM work_clients WHERE name LIKE '%$str%'");
        $data = $res->fetch_all(MYSQLI_ASSOC);
        $res->free();
        return $data;
    }
    
    function post_add_contact() {
        $res = $this->db->query('SHOW COLUMNS FROM contacts');
        $fields = $res->fetch_all(MYSQLI_ASSOC);
        $res->free();
        $fkeys = []; $vars = [];
        foreach ($fields as $key => $val) {
            if ($key > 0) {
                $fkeys[] = $val['Field'];
                $vars[] = filter_input(INPUT_POST, $val['Field']);
            }
        }
        $fstr = implode(", ", $fkeys);
        $vstr = implode("', '", $vars);
        $query = "INSERT INTO contacts ($fstr) VALUES ('$vstr')";
        $res = $this->db->query($query);
        if ($res) { echo 'Контакт добавлен!'; }
    }
}
