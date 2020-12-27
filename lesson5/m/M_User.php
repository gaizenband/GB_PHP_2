<?
class M_User {
	function auth($login,$pass){
        setcookie("name",$login);
        return $login;
    }
}