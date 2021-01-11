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
        $_GET['asAjax'] = true;

        $result = [
            'result' => 0
        ];

        $id_good = $_GET['id'];
        if($id_good > 0){
            $this->basket->setIdGood($id_good);
            $this->basket->setPrice(Good::getGoodPrice($id_good));
            $this->basket->setIdOrder();
            $this->basket->save();

            $result['result'] = 1;
        }

        return json_encode($result);
    }

    public function cart(){
        if (isset ($_POST['amount'])){
            $this->basket->newIdOrder();
            $this->order->setOrder($_POST['id_order'],$_COOKIE['id'],$_POST['amount']);

        }else{
            $this->basket->setIdOrder();
            return ['items'=>$this->basket->getGoods(),'id' => $this->basket->getIdOrder()];

        }
    }
}