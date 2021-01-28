<?php


abstract class Goods
{
    private $name;
    private $price;
    private $count;

    function __construct($name,$price,$count){
        $this->name=$name;
        $this->price=$price;
        $this->count=$count;
    }

    function calcTotal(){
        echo $this->price * $this->count." рублей за $this->count";
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice(){
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }
}