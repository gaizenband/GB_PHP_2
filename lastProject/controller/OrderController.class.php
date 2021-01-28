<?php

/**
 * Class OrderController контроллер для заказов
 */
class OrderController extends Controller
{
    /**
     * @var string директория с шаблонами
     */
    public $view = 'orders';
    /**
     * @var Basket корзина сайта
     */
    private $basket;
    /**
     * @var OrderGood заказ
     */
    private $order;

    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->title .= ' - Корзина';
        $this->basket = new Basket();
        $this->order = new OrderGood([]);
    }

    /**
     * @return false|string
     * Метод для добавления товаров в корзину
     */
    public function add(){
        $id_good = $_GET['id'];
        if(!isset($_GET['num'])) {
                $_GET['asAjax'] = true;

                $result = [
                    'result' => 0
                ];


                if ($id_good > 0) {
                    $this->basket->setUser($_COOKIE['id']);
                    $this->basket->setIdGood($id_good);
                    $this->basket->setPrice(Good::getGoodPrice($id_good));
                    $this->basket->setIdOrder();
                    $this->basket->save();

                    $result['result'] = 1;
                }

                return json_encode($result);
        }else{
            $this->basket->changeValue($id_good,$_GET['num']);
        }

    }

    /**
     * @return array
     * Метод для работы с корзиной
     */
    public function cart(){
        if (isset($_GET['id'])){
            $id_array = explode(',',$_GET['id']);
            $this->basket->deleteItem($id_array[0],$id_array[1]);
        } elseif (isset ($_POST['amount'])){
            $this->basket->newIdOrder();
            $this->basket->setIdOrder();
            $this->order->setOrder($_POST['id_order'],$_COOKIE['id'],$_POST['amount'],0);
            header("Location: index.php?path=user/personalPage");


        }else{
            $this->basket->setUser($_COOKIE['id']);
            $this->basket->setIdOrder();
            return ['items'=>$this->basket->getGoods(),'id' => $this->basket->getIdOrder()];

        }
    }

    /**
     * @return void
     * Метод для отмены заказа
     */
    public function cancelOrder(){
        $_GET['asAjax'] = true;
        Order::cancelOrder($_GET['id']);
    }
}