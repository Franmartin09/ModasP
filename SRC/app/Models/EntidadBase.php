<?php

namespace App\Models;
use DateTime;

/**
 * ALL Model In This Model EntidadBase
 */
class EntidadBase{
    private $table;
    private $db;
    private $conectar;
 
    public function __construct($table) {
        $this->table=(string) $table;
        require_once 'Conectar.php';
        $this->conectar=new Conectar();
        $this->db=$this->conectar->conexion();
    }
     
    public function getConetar(){
        return $this->conectar;
    }
     
    public function db(){
        return $this->db;
    }
    //CLIENTES
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
    public function getMaxByinRow($column){
        $query=$this->db->query("SELECT $column FROM $this->table ORDER BY $column DESC LIMIT 1");       
         return $query->getRow();
    }
    public function getMaxNfactureBy($column,$column2,$value){
        $query=$this->db->query("SELECT $column FROM $this->table WHERE $column2=$value ORDER BY $column DESC LIMIT 1");
        if($query->getRow()==NULL){
            return "0";
        }
        else{
            return $query->getRow()->numero_factura;
        }
    }

    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }
     
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */

    //USUARIOS
    public function create_user($username,$email,$pass){
        if($this->getAllOrderBy('id_user')){
            $query=$this->db->query("INSERT INTO $this->table(id_user,username,email,pass) VALUES ((SELECT MAX(id_user)+1 FROM $this->table),'$username','$email','$pass')");
        }
        return $query;
    }
    //CLIENTES
    public function create_client($username,$email,$phone,$address,$cif){
        $today = date("Y-m-d H:i:s");
        if($this->getBy('id_cliente',1)){
            $id_cliente=$this->db->query("SELECT MAX(id_cliente)+1 as id_cliente FROM $this->table")->getRow()->id_cliente;
            $query=$this->db->query("INSERT INTO $this->table(id_cliente,name_surname,email_cliente,phone,addres,cif,fecha_alta,estado) VALUES ($id_cliente,'$username','$email','$phone','$address','$cif','$today','A')");
        }
        else{
            $query=$this->db->query("INSERT INTO $this->table(id_cliente,name_surname,email_cliente,phone,addres,cif,fecha_alta,estado) VALUES (1,'$username','$email','$phone','$address','$cif','$today','A')");
        }
        return $query;
    }
    public function edit_client($id_cliente, $name, $email, $phone, $address, $cif){
        $query=$this->db->query("UPDATE $this->table SET id_cliente=$id_cliente, name_surname='$name', email_cliente='$email', phone='$phone', addres='$address', cif='$cif' WHERE id_cliente=$id_cliente");
        return $query;
    }
    public function archivar_client($id_cliente){
        $estado=($this->getByRow('id_cliente',$id_cliente)->estado);
        if($estado=='A'){ //archivar
            $estado="I";
            $today = date("Y-m-d H:i:s");
            $query=$this->db->query("UPDATE $this->table SET estado='$estado',fecha_baja='$today' WHERE id_cliente=$id_cliente");
        }
        else if($estado=='I'){ //descarchivar
            $estado="A";
            $query=$this->db->query("UPDATE $this->table SET estado='$estado',fecha_baja=NULL WHERE id_cliente=$id_cliente");
        }
        
       
        return $query;
    }


    //INVOICES
    public function create_invoice($id_cliente,$id_factura){
        $fecha = date("Y-m-d H:i:s");
        $iva='21.0';

        if($this->getMaxNfactureBy('numero_factura','id_cliente',$id_cliente)){
            $n_facturas = intval($this->getMaxNfactureBy('numero_factura','id_cliente',$id_cliente))+1;
        }
        else $n_facturas = 1;

        $str = strval($id_cliente); // convierte el número en una cadena
        $str_with_zeros = str_pad($str, 4, '0', STR_PAD_LEFT); // añade ceros al principio de la cadena
        $reference="C". $str_with_zeros;
        $str = strval($n_facturas); // convierte el número en una cadena
        $str_with_zeros = str_pad($str, 4, '0', STR_PAD_LEFT); // añade ceros al principio de la cadena
        $referencia=$reference."F". $str_with_zeros;
        
        $query=$this->db->query("INSERT INTO $this->table(id_factura,fecha,reference,importe_neto,iva,importe_total,numero_factura,id_cliente) VALUES ('$id_factura', '$fecha','$referencia','0','$iva','0','$n_facturas','$id_cliente')");
        return $query;
    }


    //ITEMS
    public function add_iteam($id_factura,$overview,$price,$quantity){

        if($this->getBy('id_iteam',1)){        
            $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES ((SELECT MAX(id_iteam)+1 FROM $this->table),'$overview','$price','$quantity','$id_factura')");
        }
        else{
            $query=$this->db->query("INSERT INTO $this->table(id_iteam, overview, price, quantity, id_factura) VALUES (1,'$overview','$price','$quantity','$id_factura')");
        }
        return $query;
    }
    public function edit_item($id_item,$price,$overview,$quantity){
        $query=$this->db->query("UPDATE $this->table SET overview='$overview',price='$price',quantity='$quantity' WHERE id_iteam=$id_item");
        return $query;
    }

    public function updateimporte($id_factura,$importe){
        $importe_neto=round($importe,2);
        $query=$this->db->query("UPDATE $this->table SET importe_neto='$importe_neto' WHERE id_factura=$id_factura");
        $iva=($this->getByRow('id_factura',$id_factura)->iva);
        $valor_iva=$importe_neto*$iva/100;
        $importe_total=$importe_neto+$valor_iva;
        $importe_total=round( $importe_total,2);
        $query=$this->db->query("UPDATE $this->table SET importe_total='$importe_total' WHERE id_factura=$id_factura");
        return $query;
    }
    public function importe_neto_total($idfactura){
        $query=$this->db->query("SELECT SUM(price * quantity) AS total FROM $this->table where id_factura=$idfactura");
        return $query->getRow()->total;
    }
    //HISTORY
    public function getinvoiceSemanal($fecha){
        $date = DateTime::createFromFormat('Y-m-d', $fecha); 
        $resultado = array();
        $resultado['total'] = 0;
        for ($i=1; $i<=7; $i++) {
        $fecha_inicial=$date->format('Y-m-d');
        $date->modify("+1 day");
        $fecha_final=$date->format('Y-m-d');
        $query=$this->db->query("SELECT SUM(importe_total) as importe FROM $this->table WHERE fecha >= timestamp '$fecha_inicial 00:00:00' and fecha < timestamp '$fecha_final 00:00:00'");
          $resultado[date('l', strtotime($fecha_inicial))] =  $query->getRow();
          if($query->getRow()->importe > $resultado['total']) {
              $resultado['total'] = $query->getRow()->importe;
          }
        }

        if($resultado['total']!=0)$resultado['total']=round($resultado['total'],2);
        else $resultado['total']=1;
        return $resultado;
    }

    public function getinvoiceMensual($fecha){
        $date = DateTime::createFromFormat('Y-m-d', $fecha);
        $date->setDate($date->format('Y'), $date->format('m'), 1);
        $resultado[]=array();
        $day = 1;
        $resultado['total'] = 0;
        while ($day <= 31) {
            $fecha_inicial=$date->format('Y-m-d');
            $date->modify("+1 day");
            $fecha_final=$date->format('Y-m-d');
            $query=$this->db->query("SELECT SUM(importe_total) as importe FROM $this->table WHERE fecha >= timestamp '$fecha_inicial 00:00:00' and fecha < timestamp '$fecha_final 00:00:00'"); //añadir dia final
            $resultado["$day"] = $query->getRow();
            if($query->getRow()->importe > $resultado['total']) {
                $resultado['total'] = $query->getRow()->importe;
            }
            $day++;
        }
        if($resultado['total']!=0)$resultado['total']=round($resultado['total'],2);
        else $resultado['total']=1;
        return $resultado;
    }

    public function getinvoiceAnual($fecha){
        $resultado[]=array();
        $resultado['total'] = 0;

		$date = DateTime::createFromFormat('Y-m-d', $fecha);
        $date->setDate($date->format('Y'), 1, 1);

        for ($mes = 1; $mes <= 12; $mes++) {
        	$fecha_inicial=$date->format('Y-m-d');
            $date->modify("+1 month");
            $fecha_final=$date->format('Y-m-d');
            $query=$this->db->query("SELECT SUM(importe_total) as importe FROM $this->table WHERE fecha >= timestamp '$fecha_inicial 00:00:00' and fecha < timestamp '$fecha_final 00:00:00'");
            $resultado[$mes] = $query->getRow();
            if ($query->getRow()->importe > $resultado['total']) {
                $resultado['total'] = $query->getRow()->importe;
            }
        }

        if ($resultado['total'] != 0) $resultado['total'] = round($resultado['total'], 2);
        else  $resultado['total'] = 1;
        return $resultado;
    }
    //comprueba si existe el item en la misma facuta i si es asi modifica la cantidad desdeada.
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
    
}
?>
