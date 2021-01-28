<?php

/**
 * Class Category класс для работы с категориями
 */
class Category extends Model {
//    protected static $table = 'categories';

    /**
     * @return bool|void
     * Установка параметров
     */
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

    /**
     * @param int $parentId
     * @return mixed
     * Получение определенных категорий товаров
     */
    public static function getCategories($parentId = 0)
    {
        return db::getInstance()->Select(
            'SELECT id_category, name, img FROM categories WHERE status=:status AND parent_id = :parent_id',
            ['status' => Status::Active, 'parent_id' => $parentId]);
    }

    /**
     * @return mixed
     * Получение базовых категорий
     */
    public static function getBaseCategories()
    {
        return db::getInstance()->Select(
            'SELECT id_category, name, img, status, parent_id FROM categories WHERE status=:status AND parent_id <> :parent_id',
            ['status' => Status::Active, 'parent_id' => 0]);
    }

    /**
     * @param $id
     * @param $name
     * Метод для изменения имени категории
     */
    public static function changeCategory($id,$name){
        db::getInstance()->Update(
            'categories',
            ['name'=>$name],
            ['id_category'=>$id]
        );
    }

    /**
     * @param $id
     * @param $image
     * Метод для изменения картинки категории
     */
    public static function newImage($id,$image){
        $path=dirname(__DIR__, 1)."/img/categories/".$image['name'];
        if(move_uploaded_file($image['tmp_name'],$path)){
            db::getInstance()->Update(
                'categories',
                ['img'=>mb_substr($image['name'],0,mb_strlen($image['name'])-4)],
                ['id_category'=>$id]
            );
        }
    }

    /**
     * @param $name
     * @param $file
     * @param $mainCategory
     * Метод для создания категории
     */
    public static function createCategory($name, $file, $mainCategory){
        $path=dirname(__DIR__, 1)."/img/categories/".$file['name'];
        if(move_uploaded_file($file['tmp_name'],$path)) {
            db::getInstance()->Insert('categories',
                ['name' => $name,
                    'status' => 1,
                    'img' => mb_substr($file['name'], 0, mb_strlen($file['name']) - 4),
                    'parent_id' => $mainCategory
                ]
            );
        }
    }

    /**
     * @param $id
     * @return mixed
     * Метод для полчения картинки категории
     */
    public static function getImage($id){
        return
            db::getInstance()->Select(
                'SELECT img FROM categories where id_category = :id_category',
                ['id_category' => $id]
            )[0]['img'];
    }

    /**
     * @param $id_category
     * @return mixed
     * Метод для удаления категории
     */
    public static function removeCategory($id_category){
        $img_name = self::getImage($id_category);
        $path=dirname(__DIR__, 1)."/img/categories/$img_name.jpg";
        unlink($path);

        return
            db::getInstance()->Delete(
                'categories',
                ['id_category'=>$id_category]
            );
    }
}