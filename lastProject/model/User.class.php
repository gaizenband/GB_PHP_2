<?php

/**
 * Class User - класс для управления пользователем
 */
class User extends Model
{
//    protected static $table = 'user';\
    /**
     * @return bool|void
     * Установка параметров
     */
    protected static function setProperties()
    {
        self::$properties['id_user'] = [
            'type' => 'int'
        ];

        self::$properties['user_name'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['user_login'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['user_password'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['user_last_action'] = [
            'type' => 'timestamp'
        ];
    }

    /**
     * @param $password
     * @return string
     * Создание пароля
     */
    private static function createPassword($password){
        return md5($password);
    }

    /**
     * @param $login
     * @param string $password
     * @return bool
     * Метод для проверки существования пользователя
     */
    public static function checkUser($login,$password = '0'){
        if($password != '0'){
            $user = db::getInstance()->Select(
                'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE user_login = :user_login AND user_password=:password',
                ['user_login' => $login, 'password' => self::createPassword($password)]
            );
        } else {
            $user = db::getInstance()->Select(
                'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE user_login = :user_login',
                ['user_login' => $login]
            );
        }

        if ($user){
            return $user;
        }

        return false;
    }

    /**
     * @param $id_user
     * @return mixed
     * Метод для получения пользователя по id
     */
    public static function getUser($id_user){
        return  db::getInstance()->Select(
            'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }

    /**
     * @param $login
     * @param $password
     * @param $username
     * Метод для создания пользователя
     */
    public static function createUser($login,$password,$username){
        db::getInstance()->Insert('user',
            [   'user_login'=>$login,
                'user_password'=>self::createPassword($password),
                'user_name'=>$username
            ]
        );

        db::getInstance()->Insert('user_role',
            [   'id_user'=>self::getUserId($login)[0]['id_user'],
                'id_role'=>2
            ]
        );
    }

    /**
     * @param $login
     * @return mixed
     * Метод для получения id ползователя по login
     */
    public static function getUserId($login){
        return  db::getInstance()->Select(
            "SELECT id_user from `user` where user_login = :user_login",
            ['user_login' => $login]
        );
    }

    /**
     * @param $id_user
     * @return mixed
     * Метод для получения роли пользователя
     */
    public static function getUserRole($id_user){
        return  db::getInstance()->Select(
            'SELECT id_role FROM `user_role` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }
}