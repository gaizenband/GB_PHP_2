<?php


class Product
{
    private $count;
    private $name;
    private $description;
    private $price;

    function __construct($count, $name, $description,$price){
        $this->count = $count;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function show(){
        echo "{$this->name} costs {$this->price}. In store: {$this->count}. Desc: {$this->description}. ";
    }

    public  function getName(){
        return $this->name;
    }

    public  function getPrice(){
        return $this->price;
    }
}