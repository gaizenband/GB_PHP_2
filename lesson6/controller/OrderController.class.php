<?php

class OrderController extends Controller
{
    public $view = 'orders';
    private $basket;

    public function __construct()
    {
        $this->basket = new Basket();
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
        $this->basket->setIdOrder();
        return $this->basket->getGoods();
    }
}