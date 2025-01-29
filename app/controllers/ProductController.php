<?php

namespace app\controllers;

use app\core\Controller;
use app\models\ProductModel;
use app\models\QueryBuilder;

class ProductController extends Controller
{
    private $query;
    private $productModel;
    public function __construct()
    {
        $this->query = new QueryBuilder;
        $this->productModel = new ProductModel;
    }
    public function productView()
    {
        $products = $this->query->selectAll('products');
        $this->view('admin/product_view', [
            'products' => $products
        ]);
    }
    public function productCreate()
    {
        $cats = $this->query->selectAll('categories');
        $this->view('admin/product_create',[
            'cats'=>$cats
        ]);
    }
    public function productAdd()
    {
        $filter = [
            'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'price' => FILTER_SANITIZE_NUMBER_INT,
            'quantity' => FILTER_SANITIZE_NUMBER_INT,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        /////////hash password /////////


        $data = [
            'cats'=>$this->query->selectAll('categories'),
            'cat_id'=>$_POST['cat_id'],
            'name' => $input['name'],
            'description' => $input['description'],
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'status' => isset($_POST['status']) == true ? 1 : 0,
            'created_at' => created_at(),
            'updated_at' => created_at(),
            'cat_id_err'=>'',
            'name_err' => '',
            'file_err'=>'',
            'price_err' => '',
            'quantity_err' => '',
        ];
        if($data['cat_id']==null){
            $data['cat_id_err']="Please select category";
        }
        if (empty($data['name'])) {
            $data['name_err'] = "product name must be supplied";
        } 
        
        if (empty($data['price'])) {
            $data['price_err'] = "Please insert price";
        }
        if (empty($data['quantity'])) {
            $data['quantity_err'] = "Please insert quantity";
        }
        // $path = dirname(dirname(__FILE__));
        $file=$_FILES['file'];
        $file_ext=pathinfo($file['name'],PATHINFO_EXTENSION);
        $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file_ext;
        

        $allowed_ext=['jpg', 'jpeg', 'png', 'pdf'];
        $allowed_mime= ['image/jpeg', 'image/png', 'application/pdf'];
        $max_file_size=2*1024*1024;

        if (empty($file['name'])) { //$_FILES['file']['name']
            $finalname = "Please insert file";
        } elseif (!in_array($file_ext, $allowed_ext)) {
            $data['file_err'] = "Invalid file type.";
        } elseif ($file['size'] > $max_file_size) {
            $data['file_err'] = "File size exceeds 2MB limit.";
        } else {
            $file_mime = mime_content_type($file['tmp_name']);
            if (!in_array($file_mime, $allowed_mime)) {
                $data['file_err'] = "Invalid file format.";
            }
        }
        
        //dd($data);
        if (empty($data['cat_id_err'])&&empty($data['name_err']) && empty($data['price_err']) &&
            empty($data['quantity_err']) && empty($data['file_err']) 
        ) {
            if (move_uploaded_file($file['tmp_name'], APPROOT . '/resources/uploads/' . $filename)) {
                chmod(APPROOT . '/resources/uploads/' . $filename, 0644);
            } else {
                $data['file_err'] = "Invalid file";
                $this->view("admin/product_create", $data);
            }

          
            $insertData = [
                'category_id' => $data['cat_id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'image'=>"$filename",
                'status' => $data['status'], // Ensure this is correctly set
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];
                $this->query->insertData("products", $insertData);
            
            
            flash('product_create_success', "Product create success");
            redirect('product_view');
        } else {
            $this->view("admin/product_create", $data);
        }
    }
    public function productEdit($id)
    {
        if ($datas = $this->query->selectById("products", $id)) {
            $data = [
                'cats'=>$this->query->selectAll('categories'),
                'id' => $datas->id,
                'category_id'=>$datas->category_id,
                'name' => $datas->name,
                'description' => $datas->description,
                'price' => $datas->price,
                'quantity' => $datas->quantity,
                'image' => $datas->image,
                'status' => $datas->status,
            ];
          
            $this->view("admin/product_edit", $data);
        } else {
            redirect('/admin/product_view');
        }
    }
    public function productEdited($id)
    {
        $filter = [
            'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'price' => FILTER_SANITIZE_NUMBER_INT,
            'quantity' => FILTER_SANITIZE_NUMBER_INT,
        ];
        $input = filter_input_array(INPUT_POST, $filter);
        $data = [
            'cats' => $this->query->selectAll('categories'),
            'cat_id' => $_POST['cat_id'],
            'name' => $input['name'],
            'description' => $input['description'],
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'status' => isset($_POST['status']) == true ? 1 : 0,
            'created_at' => created_at(),
            'updated_at' => created_at(),
            'cat_id_err' => '',
            'name_err' => '',
            'file_err' => '',
            'price_err' => '',
            'quantity_err' => '',
        ];
        if ($data['cat_id'] == null) {
            $data['cat_id_err'] = "Please select category";
        }
        if (empty($data['name'])) {
            $data['name_err'] = "product name must be supplied";
        }

        if (empty($data['price'])) {
            $data['price_err'] = "Please insert price";
        }
        if (empty($data['quantity'])) {
            $data['quantity_err'] = "Please insert quantity";
        }
        // $path = dirname(dirname(__FILE__));
        $file = $_FILES['file'];
        if (empty($file['name'])) {
            $finalname = $_POST['oldfile'];
        } else {

            $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file_ext;
            
            $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
            $allowed_mime = ['image/jpeg', 'image/png', 'application/pdf'];
            $max_file_size = 2 * 1024 * 1024;
            if (!in_array($file_ext, $allowed_ext)) {
                $data['file_err'] = "Invalid file type.";
            } elseif ($file['size'] > $max_file_size) {
                $data['file_err'] = "File size exceeds 2MB limit.";
            } else {
                $file_mime = mime_content_type($file['tmp_name']);
                if (!in_array($file_mime, $allowed_mime)) {
                    $data['file_err'] = "Invalid file format.";
                }
            }
            $finalname = $filename;    
        }
        // Validate phnumber

        if (empty($data['cat_id_err']) && empty($data['name_err']) && empty($data['file_err']) &&
            empty($data['price_err']) && empty($data['quantity_err']))
        {

            if ($file['size']>0){
                move_uploaded_file($file['tmp_name'], APPROOT . '/resources/uploads/' . $filename);
                chmod(APPROOT . '/resources/uploads/' . $filename, 0644);
                $deleteOldImg= APPROOT . '/resources/uploads/' .$_POST['oldfile'];
                if (file_exists($deleteOldImg)) {
                    unlink($deleteOldImg);
                }
            }

            $updateData = [
                'category_id' => $data['cat_id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'image' => $finalname,
                'status' => $data['status'], // Ensure this is correctly set
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ];
            // dd($updateData);
            $this->query->updatebyId("products", $id, $updateData);
            flash('product_update_success', "Product data update success");
            redirect('/admin/product_view');
        } else {
            ///////////
            //$dataObject = json_decode(json_encode($data));
            //type casting for array to object
            //$dataObject = (object) $data; //last
            ///////////
            $datas = $this->query->selectById("products", $id);
          
                $data['cats'] = $this->query->selectAll('categories');
                $data['id']=$datas->id;
                $data['category_id'] = $datas->category_id;
                $data['name'] = $datas->name;
                $data['description'] = $datas->description;
                $data['price'] = $datas->price;
                $data['quantity'] = $datas->quantity;
                $data['image'] = $datas->image;
                $data['status'] = $datas->status;
            // dd($data);
            flash('product_update_fail', "Product data update fail");
            $this->view("admin/product_edit", $data);
        }
    }
    public function productDelete($id)
    {
        $data = $this->query->selectById("products", $id);
        if (isset($data->id)) {
            $result = $this->query->delete("products", $id);
            if ($result) {
                $deleteImg = APPROOT . '/resources/uploads/' . $data->image;
                if(file_exists($deleteImg)){
                    unlink($deleteImg);
                }
                flash('product_Deleted_success', "Product $data->name Delete success");
                redirect('/admin/product_view');
            } else {
                flash('product_Deleted_fail', "Product $data->name Deleted fail");
                redirect('/admin/product_view');
            }
        } else {
            flash('product_Deleted_fail', "Product data Deleted fail");
            redirect('/admin/product_view');
        }
    }
}
