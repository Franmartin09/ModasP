<?php

namespace App\Models;

use CodeIgniter\Model;
class Conectar extends Model{
   
    public function __construct() {
      parent::__construct();
    }
     
    public function conexion(){
         return $this->db;
    }
     
    public function startFluent(){
        // require_once "FluentPDO/FluentPDO.php";
         
        // if($this->driver=="mysql" || $this->driver==null){
        //     $pdo = new PDO($this->driver.":dbname=".$this->database, $this->user, $this->pass);
        //     $fpdo = new FluentPDO($pdo);
        // }
         
        // return $fpdo;
    }
}
?>
