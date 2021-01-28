<?php


class WeightedGoods extends Goods
{
    public function __construct($name, $price, $count)
    {
        parent::__construct($name, $price, $count);
    }

    public function calcTotal()
    {
        echo parent::calcTotal()."кг";
    }
}