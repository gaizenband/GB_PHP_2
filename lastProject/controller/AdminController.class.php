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
                break;
            case 'goods':
                $finalArr['result'] = Good::getAllGoods();
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
    }
}