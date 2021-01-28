<?php
include "config.php";
header('Content-Type: application/json');

if($_GET['fetchUser'] == 1){
    $userCookie = $_GET['login'];

//    $sql = "select id,user_name,admin_status,first_name from users where user_name='$userCookie'";
    $sql = $connection->query("select id,user_name,admin_status,first_name from users where user_name='$userCookie'");
//    $query = mysqli_query($GLOBALS['connection'],$sql);

    if($sql){
        $data = [];
        $assocData = $sql->fetchAll();
        echo json_encode($assocData);
    }else{
        die("Error");
    }
} else {
    setcookie('login',$_GET['name'],1);
    echo $_COOKIE['login'];
}

if(isset($_POST['functionname'])){
    $name = $_POST['arguments'][0];
    $password = $_POST['arguments'][1];
    $register = $_POST['arguments'][2];
    $userName = $_POST['arguments'][3];
    $salt = '14rsdgxcvnbmth4';
    $password = md5($password).$salt;

    if($register == true){
        $sql = "select * from users where user_name = '$name'";
        $sql = $connection->query("select * from users where user_name = '$name'")->fetchColumn();
//        $query = mysqli_query($GLOBALS['connection'],$sql);
        if(mysqli_num_rows($sql) > 0){
            echo 'User with this name is already registered';
        } else {
            setcookie('login',$name);
            $userCookie = "login=$name";
//            $sql = "insert into users(user_name, password,admin_status, first_name, cookie) values('$name', '$password',0, '$userName','$userCookie')";
            $sql = $connection->exec("insert into users(user_name, password,admin_status, first_name, cookie) values('$name', '$password',0, '$userName','$userCookie')");
//            $query = mysqli_query($GLOBALS['connection'],$sql);
            if(!$sql){
                die("Error");
            }
        } 
    } else {
        $sql = "select * from users where user_name = '$name' and password = '$password'";
        $sql = $connection->query("select * from users where user_name = '$name' and password = '$password'")->fetchColumn();
//        $query = mysqli_query($GLOBALS['connection'],$sql);
        if($sql > 0){
            setcookie('login',$name);
        }
    }
    

    $json = json_encode(["message" => "success"]);
    echo $json;
}
