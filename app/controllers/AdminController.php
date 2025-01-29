<?php
namespace app\controllers;

use app\core\Controller;
use app\models\AdminModel;
use app\models\QueryBuilder;

class AdminController extends Controller
{
    private $query;
    private $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel;
       $this->query=new QueryBuilder;
      
    }
  

    public function adminView()
    {
        $admins = $this->query->selectAll("admins");
        $this->view("admin/admin_view", [
            "admins" => $admins
        ]);
        
    }
    public function adminCreate()
    {
        $this->view('admin/admin_create');
    }
    public function adminAdd()
    {  ////////////////first sanitize /////////
        $filter=[
            'name'=>FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email'=>FILTER_SANITIZE_EMAIL,
            'phnumber'=> FILTER_SANITIZE_NUMBER_INT
        ];
        $input=filter_input_array(INPUT_POST,$filter);
        /////////hash password /////////
        $password=$_POST['password'];
        $confirmpassword= $_POST['comfirm_password'];
  

        $data=[
            'name'=>$input['name'],
            'email'=> $input['email'],
            'password'=> '',
            'comfirm_password'=> $confirmpassword,
            'phnumber'=> $input['phnumber'],
            'is_ban'=>isset($_POST['is_ban'])==true?1:0,
            'created_at'=> created_at(),
            'updated_at'=> created_at(),
            'name_err'=> '',
            'email_err'=>'',
            'password_err'=> '',
            'comfirm_password_err'=>'',
            'phnumber_err'=>''
         ];
        if(empty($data['name'])){
            $data['name_err']="username must be supplied";
        }
        if(empty($data["email"])){
            $data["email_err"]="email must be supplied";
        }else{
            if ($this->adminModel->getUserByEmail("admins", $data["email"])) {
                $data["email_err"] = "email is already in use";
            } 
        }
        // Validate password
        if (empty($password)) {
            $data['password_err'] = "Password must be supplied";
        } elseif (strlen($password) < 6) {
            $data['password_err'] = "Password must be at least 6 characters";
        } else {
            // Hash the password only after validation
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
         // confirm password
        if(empty($data['comfirm_password'])){
            $data['comfirm_password_err']="comfirm password must be supplied";
        }elseif($password!=$confirmpassword){
            $data["comfirm_password_err"]="password do not match"; 
        }
        if(empty($data['phnumber'])){
            $data['phnumber_err']="phone number must be suppied";
        }
       
       
        if(empty($data['name_err'])&& empty($data['email_err'])&& 
           empty($data['password_err'])&& empty($data['comfirm_password_err'])&& empty($data['phnumber_err']))
           {
                $insertData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'phnumber' => $data['phnumber'],
                    'is_ban' => $data['is_ban'], // Ensure this is correctly set
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at']
                ];
                $this->query->insertData("admins", $insertData);
                flash('register_success', "Register success, please login");
                redirect('ad_view');

        }else{
            $this->view("admin/admin_create", $data);
        }
    }
    public function adminEdit($id)
    {
       if($datas=$this->query->selectById("admins",$id)){
        $data=[
            'id' => $id,
            'name' => $datas->name,
            'email' => $datas->email,
            'password' => '',
            'comfirm_password' => '',
            'phnumber' => $datas->phnumber,
            'is_ban' => $datas->is_ban,
        ];
        $this->view("admin/admin_Edit", $data);
        }else{
            redirect('/admin/ad_view');
        } 
    }
    public function adminEdited($id)
    {
        $filter =[
            'name'=>FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email'=>FILTER_SANITIZE_EMAIL,
            'phnumber'=> FILTER_SANITIZE_NUMBER_INT
        ];
        $input = filter_input_array(INPUT_POST, $filter);

        $password = $_POST['password'];
        $confirmpassword = $_POST['comfirm_password'];

        $data = [
            'id'=>$id,
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => '',
            'comfirm_password' => $confirmpassword,
            'phnumber' => $input['phnumber'],
            'is_ban' => isset($_POST['is_ban']) == true ? 1 : 0,
            'updated_at' => created_at(),
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'comfirm_password_err' => '',
            'phnumber_err' => ''
        ];
         // Validate name
        if (empty($data['name'])) {
            $data['name_err'] = "username must be supplied";
        }
         // Validate email
        if (empty($data["email"])) {
            $data["email_err"] = "email must be supplied";
        } else {
             $existingEmail = $this->query->selectById("admins", $id);
            if ($existingEmail->email === $data['email']) {
                $data['email'] = $data['email'];
            } else if ($this->adminModel->getUserByEmail("admins", $data["email"])) {
                $data['email_err'] = "email is already in use";
            }else{
                $data['email']= $data['email'];
            }
        }
        // Validate phnumber
        if (empty($data['phnumber'])) {
            $data['phnumber_err'] = "phone number must be suppied";
        }
        // Validate password
        if (empty($password)) {
            $data['password_err'] = "Password must be supplied";
        } elseif (strlen($password) < 6) {
            $data['password_err'] = "Password must be at least 6 characters";
        } else {
            // Hash the password only after validation
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        // confirm password
        if (empty($data['comfirm_password'])) {
            $data['comfirm_password_err'] = "comfirm password must be supplied";
        } elseif ($password != $confirmpassword) {
            $data["comfirm_password_err"] = "password do not match";
        }

        if (
            empty($data['name_err']) && empty($data['email_err']) &&
            empty($data['password_err']) && empty($data['comfirm_password_err']) && empty($data['phnumber_err'])
        ) {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phnumber' => $data['phnumber'],
                'is_ban' => $data['is_ban'], // Ensure this is correctly set
                'updated_at' => $data['updated_at']
            ];
            $this->query->updatebyId("admins", $id, $updateData);
            flash('admin_update_success',"Admin data update success");
            redirect('/admin/ad_view');
        } else {
            //$dataObject = json_decode(json_encode($data));
            //type casting for array to object
            //$dataObject = (object) $data; //last
            //dd($data);
            $datas=$this->query->selectById("admins",$id);              
            $data['name']= $datas->name;
            $data['email'] = $datas->email;
            $data['phnumber'] = $datas->phnumber;
            flash('admin_update_fail', "Admin data update fail");
            $this->view("admin/admin_edit", $data);
        }

    }
    public function adminDelete($id)
    {
        $data=$this->query->selectById("admins",$id);
        if(isset($data->id)){
            $result=$this->query->delete("admins",$id);
            if($result){
                flash('admin_Deleted_success', "Admin $data->name data Delete success");
                redirect('/admin/ad_view');
            }else{
                flash('admin_Deleted_fail', "Admin $data->name Deleted fail");
                redirect('/admin/ad_view');
            }
        }else{
            flash('admin_Deleted_fail', "Admin data Deleted fail");
            redirect('/admin/ad_view');
        }
    }
    public function adminLogout()
    {
        unsetUserSession();
        flash('admin_logout', "Logged Out successfully");
        redirect('/');
    }
   
}