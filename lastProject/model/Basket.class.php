<?php

/**
 * Class Basket - класс для работы с корзиной
 */
class Basket extends Model
{
    /**
     * @var mixed id пользователя
     */
    protected $id_user;
    /**
     * @var id товара
     */
    protected $id_good;
    /**
     * @var int стоимость
     */
    protected $price = 0;
    /**
     * @var int количество товаров в корзине
     */
    protected $is_in_order = 1;
    /**
     * @var int id заказа
     */
    protected $id_order;
    /**
     * @var null
     */
//    protected static $instance = null;

    /**
     * Basket constructor.
     * @param array $values
     */
    function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->id_user = $_COOKIE['id'];
    }

    /**
     * @param $id_user - присвоение id пользователя объекту класса
     */
    function setUser($id_user){
        $this->id_user = $id_user;
    }

    /**
     * @return void
     * Обновление id заказа
     */
    function newIdOrder(){
        ++$this->id_order;
    }

    /**
     * @return int Получение id заказа
     */
    function getIdOrder(){
        return $this->id_order;
    }

    /**
     * @param int $id_good
     * @return void
     * id текущего товара
     */
    public function setIdGood($id_good)
    {
        $this->id_good = $id_good;
    }

    /**
     * @param mixed $price
     * @return void
     * Установка стоимости
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param int $is_in_order
     * @return void
     * Количество товара в заказе
     */
    public function setIsInOrder($is_in_order)
    {
        $this->is_in_order = $is_in_order;

    }

    /**
     * @param mixed self::$id_order
     * Установка id для заказа
     */
    public function setIdOrder()
    {
        $this->id_order = (int)$this->getLastOrderId()[0]['id'] + 1;
    }

    /**
     * @return mixed
     * Получение id последнего заказа
     */
    public function getLastOrderId(){
        return db::getInstance()->Select('SELECT MAX(id_order) as id FROM shopdb.order');
    }

    /**
     * @return mixed
     * Проверка наличия товара в корзине
     */
    private function isInBasket(){
        return db::getInstance()->Select('SELECT * FROM basket where id_order = :id_order and id_good = :id_good and id_user = :id_user',
            ['id_order'=>$this->id_order,'id_good'=>$this->id_good,'id_user'=>$this->id_user]);
    }

    /**
     * @return mixed
     * Получение товаров из корзины
     */
    public function getGoods(){
        return db::getInstance()->Select('SELECT basket.id_good, basket.is_in_order, basket.price,
        goods.name FROM basket INNER JOIN goods on basket.id_good = goods.id_good where basket.id_order = :id_order and basket.id_user = :id_user and ISNULL(basket.ordered)',
            ['id_order'=>$this->id_order,'id_user'=>$this->id_user]);
    }

    /**
     * @param $id_good
     * @param $id_user
     * @param $id_order
     * @return mixed
     * Получение количества товара из текущего заказа
     */
    private function getCount($id_good,$id_user,$id_order){
        return db::getInstance()->Select('SELECT is_in_order FROM basket 
                where id_user = :id_user and id_good = :id_good and id_order = :id_order',
            ['id_user'=>$id_user,'id_good'=>$id_good,'id_order'=>$id_order]);
    }

    /**
     * @return void
     * Метод добавления товара в корзину
     */
    public function save(){
        if($this->isInBasket()){
            db::getInstance()->Update(
                'basket',
                ['is_in_order'=>$this->getCount($this->id_good,$this->id_user,$this->id_order)[0]['is_in_order'] + 1],
                ['id_user'=>$this->id_user,'id_good'=>$this->id_good,'id_order'=>$this->id_order]
            );

        }else{
            db::getInstance()->Insert('basket',
                [   'id_user'=>$this->id_user,
                    'id_good'=>$this->id_good,
                    'price'=>$this->price,
                    'is_in_order'=>$this->is_in_order,
                    'id_order'=>$this->id_order]
            );
        }
    }

    /**
     * @param $id
     * @param $id_order
     * Удаление товара из корзины
     */
    public function deleteItem($id,$id_order){
        db::getInstance()->Delete(
            'basket',
            ['id_user'=>$_COOKIE['id'],'id_good'=>$id,'id_order'=>$id_order]
        );
    }

    /**
     * @param $id
     * @param $value
     * Изменение количества товара в корзине
     */
    public function changeValue($id,$value){
        db::getInstance()->Update(
            'basket',
            ['is_in_order'=>$value],
            ['id_good'=>$id,'id_user'=>$_COOKIE['id']]
        );
    }
}