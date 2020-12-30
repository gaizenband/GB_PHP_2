<?php


class User extends Model
{
    protected static $table = 'user';

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

    private static function createPassword($password){
        return md5($password);
    }

    public static function checkUser($login,$password){
        $user = db::getInstance()->Select(
                'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE user_login = :user_login AND user_password=:password',
                ['user_login' => $login, 'password' => self::createPassword($password)]
            );

            if ($user){
                return $user;
            }

            return false;
    }

    public static function getUser($id_user){
        return  db::getInstance()->Select(
            'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }
}