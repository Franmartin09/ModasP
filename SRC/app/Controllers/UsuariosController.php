<?php
namespace App\Controllers;
use App\Models\User_Model;

class UsuariosController extends BaseController{
     
    private $db;
    private $session;
    public function __construct() {
        $this->db = new User_Model();
        $this->session = \Config\Services::session();
        if (!$this->session->has('user')) {
            $this->session->set('user', 'false');
        }
    }
     
    public function index(){
        $data['error']=false;
        $page='Login';
        $data['title'] = ucfirst($page);
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
        
    }

    public function comprovar_user(){
        $data['error']=false;
        if (isset($_POST['username'])) {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $result = $this->db->getByRow("username",$username);
            if(!$result) $data['error']=true;
            else if ($result->username != $username || $result->pass != $password) $data['error']=true;
            else {
                if($username=="admin") $this->session->set('user', 'admin');
                else $this->session->set('user', 'true');
                return header("Location: /home");
            }
        }
        $page='Login';
        $data['title'] = ucfirst($page);
        return view('templates/header', $data)
        . view('pages/login', $data)
        . view('templates/footer');
    }
}
?>
