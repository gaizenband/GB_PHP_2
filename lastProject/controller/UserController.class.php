<?php

class UserController extends Controller
{
    public $view = 'user';

    function personalPage(){
        if(isset($_COOKIE['id'])){
            return ['user'=>User::getUser($_COOKIE['id']),'orders'=>Order::getOrders($_COOKIE['id'])];
        }
        
        return "None";
    }

    function login(){
        if (isset($_POST['login'])){
            $user = User::checkUser($_POST['login'],$_POST['password']);
            if (!$user){
                $user = "Пользователь не найден";
            }else{
                $id = $user[0]['id_user'];
                setcookie('id',$id);
                $user_status = User::getUserRole($id)[0]['id_role'];
                if ($user_status == 1){
                    header("Location: index.php?path=admin/index");
                }else {
                    header("Location: index.php?path=user/personalPage");
                }

            }
            return $user;
        }
        return false;
    }

    function register(){
        if (isset($_POST['login'])){
            $user = User::checkUser($_POST['login']);
            if (!$user){
                User::createUser($_POST['login'],$_POST['password'],$_POST['username']);
                $user = User::checkUser($_POST['login'],$_POST['password']);
                $id = $user[0]['id_user'];
                setcookie('id',$id);
                header("Location: index.php?path=user/personalPage");
            }else{
                $user = "Пользователь с таким именем уже существует";
            }
            return $user;
        }
        return false;
    }

    function logout(){
        setcookie("id", "", time()-3600);
        header('Location: index.php');
    }

    public static function getUserStatus(){
        if (isset($_COOKIE['id'])){
            return User::getUserRole($_COOKIE['id'])[0]['id_role'];
        }
    }
}