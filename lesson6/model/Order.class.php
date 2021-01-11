<?php

class Order extends Model {
    protected static $table = 'orders';

    protected static function setProperties()
    {
        self::$properties['phone'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['address'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['email'] = [
            'type' => 'float'
        ];
    }

    public static function getOrders($id_user){
        return  db::getInstance()->Select(
            'SELECT id_order, amount, datetime_create, id_order_status FROM `order` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }
}