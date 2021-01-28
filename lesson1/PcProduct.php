<?php


class PcProduct extends Product
{
    private $processor;
    private $memory;

    public function __construct($count, $name, $description, $price, $processor, $memory)
    {
        $this->processor = $processor;
        $this->memory = $memory;
        parent::__construct($count, $name, $description, $price);
    }

    public function show()
    {
        parent::show();
        echo "Processor: {$this->processor}. Memory: {$this->memory} <hr>";
    }
}