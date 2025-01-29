<?php
namespace app\controllers;

use app\core\Controller;
use app\models\AdminModel;
use app\models\QueryBuilder;



class HomeController extends Controller
{   
    private $query;
    private $adminModel;
    public function __construct()
    {
       // echo "I am construnct";
       $this->query=new QueryBuilder;
        $this->adminModel = new AdminModel;
       
    }
    public function index()
    {
       
        $admins = $this->query->selectAll("admins");
        //echo "I am index of Home controller";
        $this->view("home", [
            "admins" => $admins
        ]);
    }
    public function login()
    {
        $this->view("/login");
    }
    public function loginCheck(){
        $filter = [
            'email' => FILTER_SANITIZE_EMAIL,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        $data=[
            'email'=>$input['email'],
            'password'=>$_POST['password'],
            'email_err'=>'',
            'password_err'=>'',
        ];
        if(empty($data['email'])){
            $data['email_err']="email must be supplied";
        }
        if(empty($data['password'])){
            $data['password_err']="password must be supplied";
        }
        
        if(empty($data['email_err'])&&empty($data['password_err'])){
            $rowUser=$this->adminModel->getUserByEmail("admins", $data["email"]);
            if($rowUser){
                $hashpass=$rowUser->password;
                if($rowUser->is_ban==1){
                    flash("banned_user","you account has been banned, Contact your admin");
                }else{
                    if (password_verify($data['password'], $hashpass)) {
                        setUserSession($rowUser);
                        flash("login_success", "Welcome back");
                        redirect('/admin');
                    } else {
                        $data['password_err'] = "password wrong";
                    }
                }
                
            }else{
                $data['email_err'] = "email wrong";
                $this->view("/login", $data);
            }
        }
        $this->view("/login",$data);
    }

}

    