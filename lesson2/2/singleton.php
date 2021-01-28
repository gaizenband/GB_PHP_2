<?php

trait singleton {
    private function __construct(){}
    public static function getInstance(){
        if (self::$_instance === null){
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}

class Test
{
    protected static $_instance;

    use singleton;
}

class Next {
    function getGoods(){
        return Test::getInstance();
    }
}

$obj = new Next();
