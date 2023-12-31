<?php

namespace App\Models;
use CodeIgniter\Model;

/**
 * Model of Clients
 */
class Client_Model extends Model{
    public $table;
    public function __construct() {
        parent::__construct();
        $this->table="clientes";
    }
    //GET ALL
    public function getAllOrderBy($column){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY $column ASC");
        return $query->getResultObject();
    }
    
    public function getAllAOrderBy($column){
        $query=$this->db->query("SELECT * FROM $this->table WHERE estado='A' ORDER BY $column ASC");
        return $query->getResultObject();
    }
    
    public function getAllIOrderBy($column){
        $query=$this->db->query("SELECT * FROM $this->table WHERE estado='I' ORDER BY $column ASC");
        return $query->getResultObject();
    }
    //GET ONLY ONE
    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getResultObject();
    }
    public function getByRow($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getRow();
    }
    public function getByLike($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column LIKE '$value%'");       
         return $query->getResultObject();
    }
    //GET MAX ID CLIENTE
    public function getMaxIdCliente(){
        $query=$this->db->query("SELECT id_cliente as id_cliente FROM $this->table ORDER BY id_cliente DESC LIMIT 1");       
         return strval(intval($query->getRow()->id_cliente)+1);
    }

    //DELETE CLIENT
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }

    //CREATE CLIENT
    public function create_client($username,$email,$phone,$address,$cif){
        if($this->getBy('id_cliente',1)) $query=$this->db->query("INSERT INTO $this->table(id_cliente,name_surname,email_cliente,phone,addres,cif,fecha_alta,estado) VALUES (".$this->getMaxIdCliente().",'$username','$email','$phone','$address','$cif','" . date("Y-m-d H:i:s") . "','A')");
        else $query=$this->db->query("INSERT INTO $this->table(id_cliente,name_surname,email_cliente,phone,addres,cif,fecha_alta,estado) VALUES (1,'$username','$email','$phone','$address','$cif','" . date("Y-m-d H:i:s") . "','A')");
        return $query;
    }
    //EDIT CLIENT
    public function edit_client($id_cliente, $name, $email, $phone, $address, $cif){
        $query=$this->db->query("UPDATE $this->table SET id_cliente=$id_cliente, name_surname='$name', email_cliente='$email', phone='$phone', addres='$address', cif='$cif' WHERE id_cliente=$id_cliente");
        return $query;
    }
    //ARCHIVAR/DESARCHIVAR CLIENT
    public function archivar_client($id_cliente){
        if(($this->getByRow('id_cliente',$id_cliente)->estado)=='A') $query=$this->db->query("UPDATE $this->table SET estado='I',fecha_baja='".date("Y-m-d H:i:s")."' WHERE id_cliente=$id_cliente"); 
        else $query=$this->db->query("UPDATE $this->table SET estado='A',fecha_baja=NULL WHERE id_cliente=$id_cliente"); 
        return $query;
    }
    
}
?>
