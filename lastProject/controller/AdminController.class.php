<?php
/**
    Admin controller
 */
class AdminController extends Controller
{
    /**
     * @var string[] массив с блоками контроля сайта
     */
    protected $controls = [
        'orders' => 'Order',
        'categories' => 'Category',
        'goods' => 'Good'
    ];

    /**
     * AdminController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->title .= ' - Админка';
    }

    /**
     * @param $data
     * @return array
     * Функция для отрисовки базового шаблона
     */
    public function index($data)
    {
        return ['controls' => $this->controls];
    }

    /**
     * @param $data
     * @return array
     * Функция для полчения данных для отображения на соответствующей странице контроля сайта
     */
    public function control($data){
        $finalArr = ['name' => $data['id']];
        switch($data['id']){
            case 'orders':
                $finalArr['result'] = Order::getOrders();
                $finalArr['statusList'] = Order::getOrderStatusList();
                break;
            case 'categories':
                $finalArr['result'] = Category::getBaseCategories();
                $finalArr['parents'] = Category::getCategories(0);
                break;
            case 'goods':
                $finalArr['result'] = Good::getAllGoods();
                $finalArr['categories'] = Category::getBaseCategories();
                break;
        }

        return $finalArr;


    }

    /**
     * @return void
     * Функция для изменения существующей категории
     */
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

    /**
     * @return void
     * Функция для создания категории
     */
    public function createCategory(){
        $_GET['asAjax'] = true;
        Category::createCategory($_POST['Name'],$_FILES['Image'],$_POST['main']);
        header('Location: ?path=admin/control/categories/');
    }

    /**
     * @return void
     * Функция для создания товара
     */
    public function createGood(){
        $_GET['asAjax'] = true;
        Good::createGood($_POST['Name'],$_FILES['Image'],$_POST['Price'],$_POST['category']);
        header('Location: ?path=admin/control/goods/');
    }

    /**
     * @return void
     * Функция для изменения существующего товара
     */
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

        if(isset($_POST['category'])){
            Good::changeCategory($good_id,$_POST['category']);
        }

        header("Location:?path=admin/control/goods/");
    }

    /**
     * @return void
     * Функция для изменения статуса заказа
     */
    public function changeStatus(){
        $_GET['asAjax'] = true;
        $id_array = explode(',',$_GET['id']);
        $order_id = $id_array[0];
        $user_id = $id_array[1];
        $status = $id_array[2];
        Order::changeStatus($order_id,$user_id,$status);
    }

    /**
     * @return void
     * Функция для удаления товара
     */
    public function removeGood(){
        $_GET['asAjax'] = true;

        $id_good = $_GET['id'];
        Good::removeGood($id_good);
    }

    /**
     * @return void
     * Функция для удаления категории
     */
    public function removeCategory(){
        $_GET['asAjax'] = true;

        $id_good = $_GET['id'];
        Category::removeCategory($id_good);
    }
}