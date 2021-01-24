<?php

class OrderGood extends Model {
    protected static $table = 'orders_goods';

    protected static function setProperties()
    {
        self::$properties['order_id'] = [
            'type' => 'int',
        ];

        self::$properties['good_id'] = [
            'type' => 'int',
        ];
    }

    public function setOrder($id_order,$id_user,$amount,$status = 1){
        if($status != 0){
            db::getInstance()->Update('shopdb.order',['status'=>$status],['id_order'=>$id_order,'id_user'=>$id_user]);
        }else{
            db::getInstance()->Insert('shopdb.order',
                ['id_user'=>$id_user, 'amount'=>$amount.".00", 'id_order'=>$id_order, 'id_order_status'=>1]
            );
            db::getInstance()->Update('basket',['ordered'=>1],['id_order'=>$id_order,'id_user'=>$id_user]);

        }
    }
}