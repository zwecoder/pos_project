<?php
namespace app\controllers;

use app\core\Controller;
use app\models\AdminModel;
use app\models\QueryBuilder;

class CustomerController extends Controller
{
    private $query;
    private $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel;
        $this->query=new QueryBuilder;
      
    }
    public function index()
    {

        //echo "I am index of Home controller";
    //    $this->view('admin/index');
    }
    public function customerView()
    {
        $customers = $this->query->selectAll("customers");
        $this->view("admin/customer_view", [
            "customers" => $customers
        ]);
        
    }
    public function customerCreate()
    {
        $this->view('admin/customer_create');
    }
    public function customerAdd()
    {  ////////////////first sanitize /////////
        
        $filter=[
            'name'=>FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email'=>FILTER_SANITIZE_EMAIL,
            'phnumber'=> FILTER_SANITIZE_NUMBER_INT
        ];
        $input=filter_input_array(INPUT_POST,$filter);
        /////////hash password /////////
  

        $data=[
            'name'=>$input['name'],
            'email'=> $input['email'],
            'phnumber'=> $input['phnumber'],
            'is_ban'=>isset($_POST['is_ban'])==true?1:0,
            'created_at'=> created_at(),
            'updated_at'=> created_at(),
            'name_err'=> '',
            'email_err'=>'',
            'phnumber_err'=>''
         ];
        if(empty($data['name'])){
            $data['name_err']="username must be supplied";
        }
        if(empty($data["email"])){
            $data["email_err"]="email must be supplied";
        }else{
            if ($this->adminModel->getUserByEmail("customers", $data["email"])) {
                $data["email_err"] = "email is already in use";
            } 
        }
        if(empty($data['phnumber'])){
            $data['phnumber_err']="phone number must be suppied";
        }
       
       
        if(empty($data['name_err'])&& empty($data['email_err'])&& empty($data['phnumber_err']))
           {
                $insertData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phnumber' => $data['phnumber'],
                    'is_ban' => $data['is_ban'], // Ensure this is correctly set
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at']
                ];
                $this->query->insertData("customers", $insertData);
                flash('customer_create_success', "customer created success");
                redirect('customer_view');

        }else{
            $this->view("admin/customer_create", $data);
             flash('customer_create_fail', 'customer created fail');
        }
    }
    public function customerEdit($id)
    {
        //dd($id);
       if($datas=$this->query->selectById("customers",$id)){
        $data=[
            'id' => $id,
            'name' => $datas->name,
            'email' => $datas->email,
            'phnumber' => $datas->phnumber,
            'is_ban' => $datas->is_ban,
        ];
        $this->view("admin/customer_Edit", $data);
        }else{
            redirect('/admin/customer_view');
        } 
    }
    public function customerEdited($id)
    {
        //dd($id);
        $filter =[
            'name'=>FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email'=>FILTER_SANITIZE_EMAIL,
            'phnumber'=> FILTER_SANITIZE_NUMBER_INT
        ];
        $input = filter_input_array(INPUT_POST, $filter);

        $data = [
            'id'=>$id,
            'name' => $input['name'],
            'email' => $input['email'],
            'phnumber' => $input['phnumber'],
            'is_ban' => isset($_POST['is_ban']) == true ? 1 : 0,
            'updated_at' => created_at(),
            'name_err' => '',
            'email_err' => '',
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
             $existingEmail = $this->query->selectById("customers", $id);
            if ($existingEmail->email === $data['email']) {
                $data['email'] = $data['email'];
            } else if ($this->adminModel->getUserByEmail("customers", $data["email"])) {
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

        if (
            empty($data['name_err']) && empty($data['email_err']) && empty($data['phnumber_err'])
        ) {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phnumber' => $data['phnumber'],
                'is_ban' => $data['is_ban'], // Ensure this is correctly set
                'updated_at' => $data['updated_at']
            ];
            $this->query->updatebyId("customers", $id, $updateData);
            flash('customer_update_success',"Customer data update success");
            redirect('/admin/customer_view');
        } else {
           // //$dataObject = json_decode(json_encode($data));
          //  //type casting for array to object
          //  //$dataObject = (object) $data; //last
          //  //dd($data);
            $datas=$this->query->selectById("customers",$id);              
            $data['name']= $datas->name;
            $data['email'] = $datas->email;
            $data['phnumber'] = $datas->phnumber;
            $data['is_ban'] = $datas->is_ban;
            flash('customer_update_fail', "Customer data update fail");
            $this->view("admin/customer_edit", $data);
        }

    }
    public function customerDelete($id)
    {
        $data=$this->query->selectById("customers",$id);
        if(isset($data->id)){
            $result=$this->query->delete("customers",$id);
            if($result){
                flash('customer_Deleted_success', "Customers $data->name data Delete success");
                redirect('/admin/customer_view');
            }else{
                flash('customer_Deleted_fail', "Customers $data->name Deleted fail");
                redirect('/admin/customer_view');
            }
        }else{
            flash('customer_Deleted_fail', "Admin data Deleted fail");
            redirect('/admin/customer_view');
        }
    }
    
   
}