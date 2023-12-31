<?php

namespace App\Models;
use CodeIgniter\Model;

/**
 * Model of Items
 */

class Detalle_Model extends Model{
    public $table;
    public function __construct() {
        parent::__construct();
        $this->table="items";
    }
    //GET ONLY ONE BY 
    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getResultObject();
    }
    //GET IMPORTE NETO DE LOS ITEMS DE LA FACTURA
    public function importe_neto_total($idfactura){
        $query=$this->db->query("SELECT SUM(price * quantity) AS total FROM $this->table where id_factura=$idfactura");
        return $query->getRow()->total;
    }
    //ADD ITEM
    public function add_iteam($id_factura,$overview,$price,$quantity){

        if($this->getBy('id_iteam',1)){        
            $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES ((SELECT MAX(id_iteam)+1 FROM $this->table),'$overview','$price','$quantity','$id_factura')");
        }
        else{
            $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES (1,'$overview','$price','$quantity','$id_factura')");
        }
        return $query;
    }
    //EDIT ITEM
    public function edit_item($id_item,$price,$overview,$quantity){
        $query=$this->db->query("UPDATE $this->table SET overview='$overview',price='$price',quantity='$quantity' WHERE id_iteam=$id_item");
        return $query;
    }
    //COMPROVAR ITEM AND SUM QUANTITIES
    public function commprovar_item($id_factura,$overview,$quantity,$price){
        $query=$this->db->query("SELECT * FROM $this->table WHERE id_factura = $id_factura AND overview ='$overview' AND price = $price");
        if ($query->getRow()) {
            $id_item = $query->getRow()->id_iteam;
            $cantidad_nueva=($query->getRow()->quantity)+$quantity;
            $query2=$this->db->query("UPDATE $this->table SET quantity = $cantidad_nueva WHERE id_iteam = $id_item");
            return true;
        } else {
            return false;
        }

    }

    public function añadir_nuevos($id_factura,$array){
        $query=$this->db->query("DELETE FROM $this->table WHERE id_factura=$id_factura");
        foreach ($array as $valor) {
            if($valor->id_iteam == ""){
                if($this->getBy('id_iteam',1)){        
                    $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES ((SELECT MAX(id_iteam)+1 FROM $this->table),'$valor->overview','$valor->price','$valor->quantity','$id_factura')");
                }
                else{
                    $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES (1,'$valor->overview','$valor->price','$valor->quantity','$id_factura')");
                }
            }
            else{
                $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES ($valor->id_iteam,'$valor->overview','$valor->price','$valor->quantity','$id_factura')");
            }
        }
        return $query;
    }
    
}
?>

