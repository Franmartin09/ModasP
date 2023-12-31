<?php
namespace App\Controllers;
use App\Models\User_Model;


class HomeController extends BaseController{
     
    private $session;
    private $db;

    public function __construct() {
        $this->session = \Config\Services::session();
    }
     
    public function index(){
        $page='Home';
        $data['title'] = ucfirst($page);
        $value['admin']="";
        $value['registrar']="";
        if(isset($_GET["registrar"])) $value['registrar']="true";
        else if($this->session->get('user')=='admin') $value['admin']="true";
        return view('templates/header', $data)
        . view('pages/home', $value)
        . view('templates/footer');
    }
    public function home_posts(){
        if (isset($_POST['logout'])) $this->logout();
        else if (isset($_POST['clients']))  return header("Location: /clients"); //header("Location: /clients");
        else if (isset($_POST['facturas']))  return header("Location: /facturas"); //header("Location: /facturas");
        else if (isset($_POST['historial'])) return header("Location: /historial");
        else if (isset($_POST['registrar'])) return header("Location: /home?registrar=true");
        else if (isset($_POST['cancelar'])) return header("Location: /home");
        else if (isset($_POST['guardar'])) {
            if(isset($_POST['username']) and isset($_POST['email']) and isset($_POST['pass'])){
                $username=$_POST['username'];
                $email=$_POST['email'];
                $pass=$_POST['pass'];
                $this->db = new User_Model();
                $this->db->create_user($username,$email,$pass);
            }
            return header("Location: /home");
        }
    }

    public function logout(){
        $this->session->destroy();
        return header("Location: /login");
    }
}
?>
