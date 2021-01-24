<?php

class Good extends Model {
    protected static $table = 'goods';

    protected static function setProperties()
    {
        self::$properties['id_good'] = [
            'type' => 'int'
        ];

        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['price'] = [
            'type' => 'float'
        ];

        self::$properties['description'] = [
            'type' => 'text'
        ];

        self::$properties['category'] = [
            'type' => 'int'
        ];
    }

    public static function getGoods($categoryId)
    {
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price FROM goods WHERE id_category = :category AND status=:status',
            ['status' => Status::Active, 'category' => $categoryId]);
    }

    public function getGoodInfo(){
        return db::getInstance()->Select(
            'SELECT * FROM goods WHERE id_good = :id_good',
            ['id_good' => (int)$this->id_good]);
    }

    public static function getGoodPrice($id_good){
        $result = db::getInstance()->Select(
            'SELECT price FROM goods WHERE id_good = :id_good',
            ['id_good' => $id_good]);

        return (isset($result[0]) ? $result[0]['price'] : null);
    }

    public static function getNewGoods(){
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price FROM goods WHERE status=:status order by id_good desc LIMIT 6',
            ['status' => Status::Active]);
    }

    public static function getAllGoods(){
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price, status FROM goods '
        );
    }

    public static function changeName($id,$name){
//        return db::getInstance()->Query(
//            'UPDATE goods SET `name` = :newName where id_good = :id_good',
//            ['id_good'=>$id,'newName'=>$name]
//        );

        return db::getInstance()->Update(
            'goods',
            ['name'=>$name],
            ['id_good'=>$id]
        );
    }

    public static function changeImage($id,$image){
        $path=dirname(__DIR__, 1)."/img/items/";
        rename($path.$id.".jpg",$path.$id."_old_".date("Y-m-d").".jpg");
        if(move_uploaded_file($image['tmp_name'],$path.$id.".jpg")){
            return true;
        }
    }

    public static function changePrice($id,$price){
        return
//            db::getInstance()->Query(
//            'UPDATE goods SET `price` = :newPrice where id_good = :id_good',
//            ['id_good'=>$id,'newPrice'=>$price]
//        );
        db::getInstance()->Update(
            'goods',
            ['price'=>$price],
            ['id_good'=>$id]
        );
    }

    public static function getGoodId($name,$price,$mainCategory){
        return db::getInstance()->Select(
            'SELECT id_good FROM goods where name = :name and price = :price and id_category = :id_category',
            ['name' => $name,'price'=>$price,'id_category'=>$mainCategory]
        );
    }

    public static function createGood($name, $file, $price, $mainCategory){
        $path=dirname(__DIR__, 1)."/img/items/";
            db::getInstance()->Insert('goods',
                ['name' => $name,
                    'price' => $price,
                    'id_category' => $mainCategory,
                    'status'=>1
                ]
            );
            $id_good = self::getGoodId($name, $price, $mainCategory)[0]['id_good'];
        move_uploaded_file($file['tmp_name'],$path.$id_good.".jpg");
    }
}
