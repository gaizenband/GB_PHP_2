<?php

class UserController extends Controller
{
    public $view = 'user';

    function personalPage(){
        if(isset($_COOKIE['id'])){
            return User::getUser($_COOKIE['id']);
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
                header("Location: index.php?path=user/personalPage");
            }
            return $user;
        }
        return false;
    }

    function register(){
        if (isset($_POST['name'])){
            return;
        }
        return false;
    }

    function logout(){
        setcookie("id", "", time()-3600);
        header('Location: index.php');
    }
}