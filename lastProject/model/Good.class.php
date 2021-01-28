<?php

/**
 * Class Good класс для управления товарами
 */
class Good extends Model {
//    protected static $table = 'goods';
    /**
     * @return bool|void
     * Установка параметров
     */
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

    /**
     * @param $categoryId
     * @return mixed
     * Получение товаров из категории
     */
    public static function getGoods($categoryId)
    {
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price FROM goods WHERE id_category = :category AND status=:status',
            ['status' => Status::Active, 'category' => $categoryId]);
    }

    /**
     * @return mixed
     * Получение информации о товаре
     */
    public function getGoodInfo(){
        return db::getInstance()->Select(
            'SELECT * FROM goods WHERE id_good = :id_good',
            ['id_good' => (int)$this->id_good]);
    }

    /**
     * @param $id_good
     * @return int|null
     * Получение стоимости товара
     */
    public static function getGoodPrice($id_good){
        $result = db::getInstance()->Select(
            'SELECT price FROM goods WHERE id_good = :id_good',
            ['id_good' => $id_good]);

        return (isset($result[0]) ? $result[0]['price'] : null);
    }

    /**
     * @return mixed
     * Получение последних 6 товаров для домашней страницы
     */
    public static function getNewGoods(){
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price FROM goods WHERE status=:status order by id_good desc LIMIT 6',
            ['status' => Status::Active]);
    }

    /**
     * @return mixed
     * Получение всех товаров
     */
    public static function getAllGoods(){
        return db::getInstance()->Select(
            'SELECT id_good, id_category, `name`, price, status FROM goods '
        );
    }

    /**
     * @param $id
     * @param $name
     * @return mixed
     * Метод для изменения имени товара
     */
    public static function changeName($id,$name){
        return db::getInstance()->Update(
            'goods',
            ['name'=>$name],
            ['id_good'=>$id]
        );
    }

    /**
     * @param $id
     * @param $image
     * @return bool
     * Метод для изменения картинки товара
     */
    public static function changeImage($id,$image){
        $path=dirname(__DIR__, 1)."/img/items/";
        rename($path.$id.".jpg",$path.$id."_old_".date("Y-m-d").".jpg");
        if(move_uploaded_file($image['tmp_name'],$path.$id.".jpg")){
            return true;
        }
    }

    /**
     * @param $id
     * @param $price
     * @return mixed
     * Метод для изменения цены товара
     */
    public static function changePrice($id,$price){
        return
        db::getInstance()->Update(
            'goods',
            ['price'=>$price],
            ['id_good'=>$id]
        );
    }

    /**
     * @param $name
     * @param $price
     * @param $mainCategory
     * @return mixed
     * Метод для получения id товара
     */
    public static function getGoodId($name,$price,$mainCategory){
        return db::getInstance()->Select(
            'SELECT id_good FROM goods where name = :name and price = :price and id_category = :id_category',
            ['name' => $name,'price'=>$price,'id_category'=>$mainCategory]
        );
    }

    /**
     * @param $name
     * @param $file
     * @param $price
     * @param $mainCategory
     * Метод для создания товара
     */
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

    /**
     * @param $id
     * @param $id_category
     * @return mixed
     * Метод для изменения категории товара
     */
    public static function changeCategory($id,$id_category){
        return
            db::getInstance()->Update(
                'goods',
                ['id_category'=>$id_category],
                ['id_good'=>$id]
            );
    }

    /**
     * @param $id_good
     * @return mixed
     * Метод для удаления товара с сайта
     */
    public static function removeGood($id_good){
        $path=dirname(__DIR__, 1)."/img/items/$id_good.jpg";
        unlink($path);

        return
            db::getInstance()->Delete(
                'goods',
                ['id_good'=>$id_good]
            );
    }
}
