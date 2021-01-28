<?php

/**
 * Class Order - класс для управления заказами
 */
class Order extends Model {
//    protected static $table = 'orders';

    /**
     * @return bool|void
     * Установка параметров
     */
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

    /**
     * @param int $id_user
     * @return mixed
     * Метод для получения заказов
     */
    public static function getOrders($id_user = 0){
        if ($id_user == 0){
            return  db::getInstance()->Select(
                'SELECT `order`.id_order, `order`.amount, `order`.datetime_create,`order`.id_order_status, `order_status`.`order_status_name`,`order`.id_user 
                        FROM `order` 
                        INNER JOIN order_status ON `order`.id_order_status=order_status.id_order_status
                        order by `order`.id_order desc'
            );
        } else {
            return  db::getInstance()->Select(
                'SELECT `order`.id_order, `order`.amount, `order`.datetime_create,`order`.id_order_status, `order_status`.`order_status_name` 
                        FROM `order` 
                        INNER JOIN order_status ON `order`.id_order_status=order_status.id_order_status
                        WHERE `order`.id_user = :id_user
                        order by `order`.id_order desc',
                ['id_user' => $id_user]
            );
        }
    }

    /**
     * @param $id
     * Метод для отмены заказа
     */
    public static function cancelOrder($id){
        db::getInstance()->Update(
            '`order`',
            ['id_order_status'=>5],
            ['id_user'=>$_COOKIE['id'],'id_order'=>$id]
        );
        header("Refresh:0");
    }

    /**
     * @return mixed
     * Метод для получения списка возможных статусов заказа
     */
    public static function getOrderStatusList(){
        $query = 'SELECT * FROM `order_status`';
        return db::getInstance()->Select($query);
    }

    /**
     * @param $order_id
     * @param $user_id
     * @param $status
     * Метод для изменения статуса заказа
     */
    public static function changeStatus($order_id,$user_id,$status){
        db::getInstance()->Update(
            '`order`',
            ['id_order_status'=>$status],
            ['id_user'=>$user_id,'id_order'=>$order_id]
        );
    }
}
