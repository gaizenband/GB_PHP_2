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

    public static function getUser($id_user){
        return  db::getInstance()->Select(
            'SELECT id_user, user_name, user_login, user_last_action FROM `user` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }

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

    public static function getUserId($login){
        return  db::getInstance()->Select(
            "SELECT id_user from `user` where user_login = :user_login",
            ['user_login' => $login]
        );
    }

    public static function getUserRole($id_user){
        return  db::getInstance()->Select(
            'SELECT id_role FROM `user_role` WHERE id_user = :id_user',
            ['id_user' => $id_user]
        );
    }
}