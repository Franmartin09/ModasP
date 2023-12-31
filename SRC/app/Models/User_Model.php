<?php

namespace App\Models;
use CodeIgniter\Model;

/**
 * Model of Users
 */

 class User_Model extends Model{
    public $table;
    public function __construct() {
        parent::__construct();
        $this->table="usuarios";
    }
    
    //CREATE USER
    public function create_user($username,$email,$pass){
        if($this->getAllOrderBy('id_user')){
            $query=$this->db->query("INSERT INTO $this->table(id_user,username,email,pass) VALUES ((SELECT MAX(id_user)+1 FROM $this->table),'$username','$email','$pass')");
        }
        return $query;
    }
    //GET USERNAME WITH VALUE="VALUE"
    public function getByRow($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getRow();
    }
    //GET ALL USERS
    public function getAllOrderBy($column){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY $column ASC");
        return $query->getResultObject();
    }  
}
?>
