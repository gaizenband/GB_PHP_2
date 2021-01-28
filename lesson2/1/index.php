<?php
spl_autoload_register(function ($name){
    include_once "index.php";
});

$obj = new WeightedGoods("Картошка",300,5);
echo $obj->calcTotal();