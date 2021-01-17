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
            $query = "UPDATE shopdb.order SET status = $status where id_order = $id_order and id_user = $id_user";
        }else{
            $query = "INSERT INTO shopdb.order(id_user, amount, id_order, id_order_status) values($id_user,$amount.00,$id_order,$status)";
            $query2 = "UPDATE basket SET ordered = 1 where id_order = $id_order and id_user = $id_user";
            db::getInstance()->Query($query2);
        }
        db::getInstance()->Query($query);

    }
}