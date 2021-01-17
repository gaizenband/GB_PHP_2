<?php

class Category extends Model {
    protected static $table = 'categories';

    protected static function setProperties()
    {
        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['parent_id'] = [
            'type' => 'int',
        ];
    }

    public static function getCategories($parentId = 0)
    {
        return db::getInstance()->Select(
            'SELECT id_category, name, img FROM categories WHERE status=:status AND parent_id = :parent_id',
            ['status' => Status::Active, 'parent_id' => $parentId]);
    }

    public static function getAllCategories(){
        return db::getInstance()->Select(
            'SELECT id_category, name, img, status, parent_id FROM categories where parent_id <> 0'
        );
    }

    public static function changeCategory($id,$name){
        return db::getInstance()->Query(
            'UPDATE categories SET `name` = :newName where id_category = :id_category',
            ['id_category'=>$id,'newName'=>$name]
        );
    }

    public static function newImage($id,$image){
        $path=dirname(__DIR__, 1)."/img/categories/".$image['name'];
        if(move_uploaded_file($image['tmp_name'],$path)){
            db::getInstance()->Query(
                'UPDATE categories SET `img` = :imgName where id_category = :id_category',
                ['id_category'=>$id,'imgName'=>mb_substr($image['name'],0,mb_strlen($image['name'])-4)]
            );
        }
    }
}