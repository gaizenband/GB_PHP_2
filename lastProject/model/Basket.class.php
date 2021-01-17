<?php

/**
 * Created by PhpStorm.
 * User: apryakhin
 * Date: 29.09.2016
 * Time: 13:13
 */
class Basket extends Model
{
    protected $id_user;
    protected $id_good;
    protected $price = 0;
    protected $is_in_order = 1;
    protected $id_order;
    protected static $instance = null;

    function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->id_user = $_COOKIE['id'];
    }

    function setUser($id_user){
        $this->id_user = $id_user;
    }

    function newIdOrder(){
        ++$this->id_order;
    }

    function getIdOrder(){
        return $this->id_order;
    }

    /**
     * @param mixed $id_good
     */
    public function setIdGood($id_good)
    {
        $this->id_good = $id_good;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param int $is_in_order
     */
    public function setIsInOrder($is_in_order)
    {
        $this->is_in_order = $is_in_order;

    }

    /**
     * @param mixed self::$id_order
     */
    public function setIdOrder()
    {
//        if (!$this->id_order || $this->id_order == $this->getLastOrderId()){
            $this->id_order = (int)$this->getLastOrderId()[0]['id'] + 1;
//        }
    }

    public function getLastOrderId(){
        return db::getInstance()->Select('SELECT MAX(id_order) as id FROM shopdb.order');
    }


    private function isInBasket(){
        return db::getInstance()->Select('SELECT * FROM basket where id_order = :id_order and id_good = :id_good and id_user = :id_user',
            ['id_order'=>$this->id_order,'id_good'=>$this->id_good,'id_user'=>$this->id_user]);
    }

    public function getGoods(){
        return db::getInstance()->Select('SELECT basket.id_good, basket.is_in_order, basket.price,
        goods.name FROM basket INNER JOIN goods on basket.id_good = goods.id_good where basket.id_order = :id_order and basket.id_user = :id_user and ISNULL(basket.ordered)',
            ['id_order'=>$this->id_order,'id_user'=>$this->id_user]);
    }

    public function save(){
        if($this->isInBasket()){
            $query = "UPDATE basket SET is_in_order = is_in_order + 1
            where id_user = $this->id_user and id_good = $this->id_good and id_order = $this->id_order";

        }else{
            $query = "INSERT INTO basket(id_user, id_good, price, is_in_order, id_order) VALUES
                  (
                    ".$this->id_user.",
                    ".$this->id_good.",
                    ".$this->price.",
                    ".$this->is_in_order.",
                    ".$this->id_order."
                  )";
        }

        db::getInstance()->Query($query);
    }

    public function deleteItem($id){
        $query = "DELETE FROM basket where id_user = :id_user and id_good = :id_good";
        db::getInstance()->Query($query,['id_user'=>$_COOKIE['id'],'id_good'=>$id]);
    }

    public function changeValue($id,$value){
        $query = "UPDATE basket SET is_in_order = :num where id_good = :id_good and id_user = :id_user";
        db::getInstance()->Query($query,['id_user'=>$_COOKIE['id'],'id_good'=>$id, 'num' => $value]);
    }
}