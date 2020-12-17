<?php

class Connection
{
    protected static $_instance;
    const SQL = "select img from shop";

    private function __construct(){}

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public static function connect($connection){
        $query = mysqli_query($connection, self::SQL);
        if($query){
            $data = [];
            while($assocData = mysqli_fetch_assoc($query)){
                array_push($data,$assocData);
            }
            return $data;
        }else {
            echo mysqli_error($connection);
        }
    }
}