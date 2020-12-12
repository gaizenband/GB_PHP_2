<?php
include_once "CarProduct.php";
include_once "PcProduct.php";

$cars = [
    [
        "name"=>"BMW",
        "count"=>100,
        "description"=>"Bavarian Motor Works",
        "speed"=>300,
        "year"=>2020,
        "price"=>300
    ],
    [
        "name"=>"VW",
        "count"=>200,
        "description"=>"Volkswagen",
        "speed"=>250,
        "year"=>2019,
        "price"=>100
    ],
    [
        "name"=>"Audi",
        "count"=>73,
        "description"=>"Audi is a wholly owned by the Volkswagen Group",
        "speed"=>300,
        "year"=>2020,
        "price"=>290
    ],
];

$notebooks = [
    [
        "name"=>"Intel",
        "count"=>100,
        "description"=>"Intel pc with integrated VGA card",
        "processor"=>"Intel core i5",
        "memory"=>128,
        "price"=>100
    ],
    [
        "name"=>"Asus",
        "count"=>200,
        "description"=>"Asus gaming pc",
        "processor"=>"AMD",
        "memory"=>256,
        "price"=>200
    ],
    [
        "name"=>"MSI",
        "count"=>73,
        "description"=>"MSI gaming pc",
        "processor"=>"Intel core i7",
        "memory"=>512,
        "price"=>250
    ],
];

foreach ($cars as $value){
    $obj = new CarProduct(
        $value["count"],
        $value["name"],
        $value["description"],
        $value["speed"],
        $value["year"],
        $value["price"]
    );
    $obj->show();
}

foreach ($notebooks as $value){
    $obj = new PcProduct(
        $value["count"],
        $value["name"],
        $value["description"],
        $value["price"],
        $value["processor"],
        $value["memory"]
    );
    $obj->show();
}