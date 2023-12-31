<?php

namespace App\Models;
use CodeIgniter\Model;
use DateTime;

/**
 * Model of Invoices
 */

class Invoice_Model extends Model{
    public $table;
    public function __construct() {
        parent::__construct();
        $this->table="facturas";
    }

    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getResultObject();
    }
    public function getAllOrderBy($column){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY $column ASC");
        return $query->getResultObject();
    }
    public function getByRow($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");       
         return $query->getRow();
    }
    public function getMaxByinRow($column){
        $query=$this->db->query("SELECT $column FROM $this->table ORDER BY $column DESC LIMIT 1");       
         return $query->getRow();
    }
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'");
        return $query;
    }
    public function getMaxNfactureBy($column,$column2,$value){ //MEJORARRRRRRRRRRRRRRRRRRRRRRRR
        $query=$this->db->query("SELECT $column FROM $this->table WHERE $column2=$value ORDER BY $column DESC LIMIT 1");
        if($query->getRow()==NULL){
            return "0";
        }
        else{
            return $query->getRow()->numero_factura;
        }
    }

    public function create_invoice($id_cliente,$id_factura){
        $fecha = date("Y-m-d H:i:s");
        $iva='21.0';

        if($this->getMaxNfactureBy('numero_factura','id_cliente',$id_cliente)){
            $n_facturas = intval($this->getMaxNfactureBy('numero_factura','id_cliente',$id_cliente))+1;
        }
        else $n_facturas = 1;

        $str = strval($id_cliente);
        $str_with_zeros = str_pad($str, 4, '0', STR_PAD_LEFT); 
        $reference="C". $str_with_zeros;
        $str = strval($n_facturas); 
        $str_with_zeros = str_pad($str, 4, '0', STR_PAD_LEFT); 
        $referencia=$reference."F". $str_with_zeros;
        
        $query=$this->db->query("INSERT INTO $this->table(id_factura,fecha,reference,importe_neto,iva,importe_total,numero_factura,id_cliente) VALUES ('$id_factura', '$fecha','$referencia','0','$iva','0','$n_facturas','$id_cliente')");
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
            if($query->getRow()->importe > $resultado['total']) $resultado['total'] = $query->getRow()->importe;
        }

        if($resultado['total']!=0) $resultado['total']=round($resultado['total'],2);
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
            if($query->getRow()->importe > $resultado['total']) $resultado['total'] = $query->getRow()->importe;
            $day++;
        }
        if($resultado['total']!=0) $resultado['total']=round($resultado['total'],2);
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

}
?>
