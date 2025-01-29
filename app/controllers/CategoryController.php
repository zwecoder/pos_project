<?php namespace app\controllers;

use app\core\Controller;
use app\models\CategoryModel;
use app\models\QueryBuilder;

class CategoryController extends Controller{
    private $query;
    private $categoryModel;
    public function __construct(){
        $this->query = new QueryBuilder;
        $this->categoryModel=new CategoryModel;
    }
    public function catView(){
       $cats=$this->query->selectAll('categories');
       $this->view('admin/cat_view',[
       'cats'=>$cats 
        ]);

    }
    public function catCreate()
    {
        $this->view('admin/cat_create');
    }
    public function catAdd()
    {
        $filter = [
            'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        /////////hash password /////////


        $data = [
            'name' => $input['name'],
            'description' => $input['description'],
            'status' => isset($_POST['status']) == true ? 1 : 0,
            'created_at' => created_at(),
            'updated_at' => created_at(),
            'name_err' => '',
        ];
       
        if (empty($data['name'])) {
            $data['name_err'] = "Category name must be supplied";
        } else {
            if ($this->categoryModel->getCategoryByName("categories", $data["name"])) {
                $data["name_err"] = "Category name is already in use";
            }
        }

        if (
            empty($data['name_err'])) {
            $insertData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'status' => $data['status'], // Ensure this is correctly set
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];
             $this->query->insertData("categories", $insertData);
            //    echo $result;
            flash('cat_create_success', "Category create success");
            redirect('cat_view');
                
          
        } else {
            $this->view("admin/cat_create", $data);
        }
    }
    public function catEdit($id)
    {
        if ($datas = $this->query->selectById("categories", $id)) {
            $data = [
                'id' => $id,
                'name' => $datas->name,
                'description' => $datas->description,
                'status' => $datas->status,
            ];
            $this->view("admin/cat_edit", $data);
        } else {
            redirect('/admin/cat_view');
        }
    }
    public function catEdited($id)
    {
        $filter = [
            'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];
        $input = filter_input_array(INPUT_POST, $filter);

        $data = [
            'id' => $id,
            'name' => $input['name'],
            'description' => $input['description'],
            'status' => isset($_POST['status']) == true ? 1 : 0,
            'updated_at' => created_at(),
            'name_err' => '',
            'description_err' => '',
        ];
        // Validate name
        if (empty($data['name'])) {
            $data['name_err'] = "Category name must be supplied";
        // } else {
        //     if ($this->categoryModel->getCategoryByName("categories", $data["name"])) {
        //         $data["name_err"] = "Category name is already in use";
        //     }
        } else {
            $existingname = $this->query->selectById("categories", $id);
            if ($existingname->name === $data['name']) {
                $data['name'] = $data['name'];
            } else if ($this->categoryModel->getCategoryByName("categories", $data["name"])) {
                $data['name_err'] = "category name is already in use";
            } else {
                $data['name'] = $data['name'];
            }
        }
        // Validate phnumber
     
        if (empty($data['name_err'])) {
            $updateData = [
                'name' => $data['name'],
                'description'=>$data['description'],
                'status' => isset($_POST['status']) == true ? 1 : 0, // Ensure this is correctly set
                'updated_at' => $data['updated_at']
            ];
            $this->query->updatebyId("categories", $id, $updateData);
            flash('cat_update_success', "Category data update success");
            redirect('/admin/cat_view');
        } else {
            ///////////
            //$dataObject = json_decode(json_encode($data));
            //type casting for array to object
            //$dataObject = (object) $data; //last
            ///////////
            $datas = $this->query->selectById("categories", $id);
             $data['name'] = $datas->name;
            $data['description'] = $datas->description;
             $data['status'] = $datas->status;
             flash('cat_update_fail', "Category data update fail");
            $this->view("admin/cat_edit", $data);
        }
    }
    public function catDelete($id)
    {
        $data = $this->query->selectById("categories", $id);
        if (isset($data->id)) {
            $result = $this->query->delete("categories", $id);
            if ($result) {
                flash('cat_Deleted_success', "Category $data->name Delete success");
                redirect('/admin/cat_view');
            } else {
                flash('cat_Deleted_fail', "Category $data->name Deleted fail");
                redirect('/admin/cat_view');
            }
        } else {
            flash('cat_Deleted_fail', "Category data Deleted fail");
            redirect('/admin/cat_view');
        }
    }
   
}