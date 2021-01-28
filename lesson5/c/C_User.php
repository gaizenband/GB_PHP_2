<?php
//
// Конттроллер страницы чтения.
//
include_once('m/M_User.php');

class C_User extends C_Base
{
	//
	// Конструктор.
	//
	
	public function action_auth(){
		$this->title .= '::Авторизация';
        $user = new M_User();
		$info = "Пользователь не авторизован";
        if($_POST){
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $info = $user->auth($login,$pass);
		    $this->content = $this->Template('v/v_personal.php', array('text' => $info));
		}
		else{
		   $this->content = $this->Template('v/v_auth.php', array('text' => $info));
		}
	}

	public function action_personal(){
        $this->title .= '::Личный кабинет';
        $userName = $_COOKIE['name'];
        $this->content = $this->Template('v/v_personal.php', array('text' => $userName));
    }

}
