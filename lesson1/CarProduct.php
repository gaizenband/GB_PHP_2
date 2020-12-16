<?php
include_once "Product.php";

class CarProduct extends Product{
    private $speed;
    private $year;

    function __construct($count, $name, $description,$speed,$year,$price)
    {
        $this->speed = $speed;
        $this->year = $year;
        parent::__construct($count, $name, $description,$price);
    }

    public function show()
    {
        parent::show();
        echo "Max speed of {$this->getName()} is {$this->speed}. Year issued: {$this->year} <hr>";
    }
}