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

    public static function cancelOrder($id){
        db::getInstance()->Update(
            '`order`',
            ['id_order_status'=>5],
            ['id_user'=>$_COOKIE['id'],'id_order'=>$id]
        );
        header("Refresh:0");
    }

    public static function getOrderStatusList(){
        $query = 'SELECT * FROM `order_status`';
        return db::getInstance()->Select($query);
    }

    public static function changeStatus($order_id,$user_id,$status){
//        $query = "UPDATE `order` set id_order_status = :status where id_user = :id_user and id_order = :id_order";
//        db::getInstance()->Query($query,['id_user' => $user_id, 'id_order' => $order_id, 'status'=>$status]);

        db::getInstance()->Update(
            '`order`',
            ['id_order_status'=>$status],
            ['id_user'=>$user_id,'id_order'=>$order_id]
        );
    }
}
