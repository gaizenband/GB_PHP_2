<?php
class AdminController extends Controller
{
    
    protected $controls = [
        'orders' => 'Order',
        'categories' => 'Category',
        'goods' => 'Good'
    ];

    public $title = 'admin';
    
    public function index($data)
    {
        return ['controls' => $this->controls];
    }

    public function control($data){
        $finalArr = ['name' => $data['id']];
        switch($data['id']){
            case 'orders':
                $finalArr['result'] = Order::getOrders();
                $finalArr['statusList'] = Order::getOrderStatusList();
                break;
            case 'categories':
                $finalArr['result'] = Category::getAllCategories();
                $finalArr['parents'] = Category::getParents();
                break;
            case 'goods':
                $finalArr['result'] = Good::getAllGoods();
                $finalArr['categories'] = Category::getBaseCategories();
                break;
        }

        return $finalArr;


    }

    public function changeCategory(){
        $_GET['asAjax'] = true;
        $category_id = $_GET['id'];

        if(isset($_POST['Name'])){
            Category::changeCategory($category_id,$_POST['Name']);
        }
        if(isset($_FILES['Image'])){
            Category::newImage($category_id,$_FILES['Image']);
        }

        header('Location: ?path=admin/control/categories/');
    }

    public function createCategory(){
        $_GET['asAjax'] = true;
        Category::createCategory($_POST['Name'],$_FILES['Image'],$_POST['main']);
        header('Location: ?path=admin/control/categories/');
    }

    public function createGood(){
        $_GET['asAjax'] = true;
        Good::createGood($_POST['Name'],$_FILES['Image'],$_POST['Price'],$_POST['category']);
        header('Location: ?path=admin/control/goods/');
    }

    public function changeGood(){
        $_GET['asAjax'] = true;
        $good_id = $_GET['id'];

        if(isset($_POST['Name'])){
            Good::changeName($good_id,$_POST['Name']);
        }
        if($_FILES['Image']['size'] != 0){
            Good::changeImage($good_id,$_FILES['Image']);
        }
        if(isset($_POST['Price'])){
            Good::changePrice($good_id,$_POST['Price']);
        }
        header("Location:?path=admin/control/goods/");
    }

    public function changeStatus(){
        $_GET['asAjax'] = true;
        $id_array = explode(',',$_GET['id']);
        $order_id = $id_array[0];
        $user_id = $id_array[1];
        $status = $id_array[2];
        Order::changeStatus($order_id,$user_id,$status);
    }
}