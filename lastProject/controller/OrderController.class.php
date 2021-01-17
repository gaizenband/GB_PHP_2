<?php

class OrderController extends Controller
{
    public $view = 'orders';
    private $basket;
    private $order;

    public function __construct()
    {
        $this->basket = new Basket();
        $this->order = new OrderGood([]);
    }

    public function add(){
        $id_good = $_GET['id'];
        if(!isset($_GET['num'])) {
            $_GET['asAjax'] = true;

            $result = [
                'result' => 0
            ];


            if($id_good > 0){
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

    public function cart(){
        if (isset($_GET['id'])){
            $this->basket->deleteItem($_GET['id']);
        } elseif (isset ($_POST['amount'])){
            $this->basket->newIdOrder();
            $this->order->setOrder($_POST['id_order'],$_COOKIE['id'],$_POST['amount']);
            header("Location: index.php?path=user/personalPage");

        }else{
            $this->basket->setUser($_COOKIE['id']);
            $this->basket->setIdOrder();
            return ['items'=>$this->basket->getGoods(),'id' => $this->basket->getIdOrder()];

        }
    }

    public function cancelOrder(){
        $_GET['asAjax'] = true;
        Order::cancelOrder($_GET['id']);
    }
}