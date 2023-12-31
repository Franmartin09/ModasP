<?php
namespace App\Controllers;
use App\Models\Client_Model;
use App\Models\Detalle_Model;
use App\Models\Invoice_Model;

class DetallesController extends BaseController{
     
    private $db;
    private $db_items;
    private $db_clientes;
    private $session;

    // Datos de factura en un array
    private $facturaData = [
        'numero_factura',
        'fecha_factura',
        'id_factura',
        'fecha',
        'reference', 
        'importe_neto ',
        'iva',
        'importe_total', 
        'numero_factura ',
        'id_cliente',
    ];
    private $itemsDatas = [];
    public function __construct() {
        $this->db = new Invoice_Model();
        $this->db_clientes = new Client_Model();
        $this->db_items = new Detalle_Model();
        $this->session = \Config\Services::session();
    }
     
    public function index(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            return header("Location: /login");
        }else{
            $value['id_cliente'] = "";
            $value['n_factura'] = "";
            $value['reference'] = "";
            $page='Create Invoice';  
            if($this->db->getByRow("id_factura",$_GET["id_factura"])==NULL){
                if(isset($_GET["id_cliente"])){
                    $this->db->create_invoice($_GET["id_cliente"], $_GET["id_factura"]);
                    $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
                    $value['id_cliente'] = $datos->id_cliente;
                    $value['reference'] = $datos->reference;
                    $value['n_factura'] = $datos->numero_factura;
                    $page="Create Invoice to Client";
                }
            }
            else{
                $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
                $value['reference']=$datos->reference;
                $value['n_factura'] =$datos->numero_factura;
                $value['id_cliente'] = $datos->id_cliente;
                $page="Create Invoice to Client";
            }
            $data['title'] = ucfirst($page);
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);

            $value['editar']="";
            $value['añadir']="";
            $value['autocomplete'] ="";
            $_SESSION['editar'] = 'false';
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function posts(){
        if (isset($_POST['logout'])) $this->logout();
        else if(isset($_POST["home"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
            else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
            return header("Location: /home");
        }
        else if(isset($_POST["guardar_factura"])){
            if($_POST["guardar_factura"]!="[]"){
                $arr=json_decode($_POST["guardar_factura"]);
                $this->db_items->añadir_nuevos($_GET["id_factura"],array_reverse($arr));
                $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
            }
            else $this->db->deleteBy('id_factura',$_GET["id_factura"]);

            if(isset($_GET["id_cliente"])) return header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else return header("Location: /facturas");
        }
        else if(isset($_POST["cancelar_factura"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);

            if(isset($_GET["id_cliente"])) return header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else return header("Location: /facturas");
        }
        else if(isset($_POST["eliminar_item"])){
            $this->db->deleteBy( 'id_iteam',$_POST["eliminar_item"]);
            if(isset($_GET["id_cliente"])) return header("Location: /añadir_item?id_factura=".$_GET["id_factura"]."&id_cliente=".$_GET["id_cliente"]);
            else return header("Location: /añadir_item?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["comprobar_cliente"])){
            $value=intval($_POST["cliente"]);
            $max = intval($this->db_clientes->getMaxIdCliente());
            if (is_int($value) && $value<$max){
                    if($this->db_clientes->getby("id_cliente",$_POST["cliente"])) return header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]."&id_cliente=".$_POST["cliente"]);
            }
            else return header("Location: /crear_facturas?id_factura=".$_GET["id_factura"]);
        }
        else if(isset($_POST["volver"])){
            if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
            else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
            if(isset($_GET["id_cliente"])) return header("Location: /facturas?id_cliente=".$_GET["id_cliente"]);
            else return header("Location: /facturas");
        } 
        exit;
        
    }
    public function editar_factura(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            return header("Location: /login");
        }else{
            $datos=$this->db->getByRow("id_factura",$_GET["id_factura"]);
            $value['reference']=$datos->reference;
            $value['n_factura'] =$datos->numero_factura;
            $value['id_cliente'] = $datos->id_cliente;
            $page="Edit Invoice to Client";
            $data['title'] = ucfirst($page);
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);

            $value['editar']="true";
            $value['añadir']="";
            $value['autocomplete'] ="";
            $_SESSION['editar'] = 'true';
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function añadir_item(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            return header("Location: /login");
        }else{
            $datos=$this->db->getByRow("id_factura", $_GET["id_factura"]);
            if(isset($_GET["id_cliente"])){
                $idCliente = $_GET["id_cliente"];
                $value['id_cliente'] = $idCliente;
                if($_SESSION['editar']=='false') $page="Create Invoice to Client";
                else $page="Edit Invoice to Client";
                $data['title'] = ucfirst($page); 
                $value['n_factura']=intval($this->db->getMaxNfactureBy('numero_factura','id_cliente',$idCliente))+1;
            }
            $value['reference']=$datos->reference;
            $value['n_factura'] =$datos->numero_factura;
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);
            $value['editar']="";
            $value['añadir']="añadir";
            $value['autocomplete'] ="";
            
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
    }
    public function editar_item(){
        if($this->session->get('user')!='admin' and $this->session->get('user')!='true'){
            return header("Location: /login");
        }else{
            $idFactura=$_GET["id_factura"];
            $datos=$this->db->getByRow("id_factura", $idFactura);
            $value['id_cliente'] = $datos->id_cliente;
            if($_SESSION['editar']=='false')$page="Create Invoice to Client";
            else $page="Edit Invoice to Client";
            $data['title'] = ucfirst($page); 
            $value['n_factura']=$datos->numero_factura;
            $value['id_cliente'] = $datos->id_cliente;
            $value['reference'] = $datos->reference;
            $value['n_factura'] = $datos->numero_factura;
            $value['detalle']=$this->db_items->getBy('id_factura',$_GET["id_factura"]);
            $value['editar']="";
            $value['añadir']="";
            $value['autocomplete'] = $this->db_items->getBy('id_iteam',$_GET["id_item"]);
    
            return view('templates/header', $data)
            . view('pages/make_invoice', $value)
            . view('templates/footer');
        }
       
    }
    public function logout(){
        if($this->db_items->getBy('id_factura',$_GET["id_factura"])==NULL) $this->db->deleteBy('id_factura',$_GET["id_factura"]);
        else $this->db->updateimporte($_GET["id_factura"], $this->db_items->importe_neto_total($_GET["id_factura"]));
        $this->session->destroy();
        return header("Location: /login");
    }
}
?>
