<?php
include "config.php";
$user_id = $_GET['userId'];

if(isset($_GET['id']) && !isset($_GET['delete'])){
    $productId = $_GET['id'];
    

//    $sql = "select * from cart where id_item = $productId and id_user = '$user_id'";
    $sql = $connection->query("select * from cart where id_item = $productId and id_user = '$user_id'")->fetchColumn();
//    $query = mysqli_query($GLOBALS['connection'],$sql);
    if(isset($_GET['count'])){
        $count = $_GET['count'];
        $updateSql = "update cart set count = $count where id_item = $productId and id_user = '$user_id'";
    }elseif($sql > 0){
        $updateSql = "update cart set count = count + 1 where id_item = $productId and id_user = '$user_id'";
    } else {
        $updateSql = "insert into cart(id_item, count, id_user) VALUES($productId, 1, $user_id)";
    }
    $changeQuery = $connection->exec("$updateSql");

    if(!$changeQuery) {
        echo 'Error';
    }
}

if(isset($_GET['id']) && isset($_GET['delete'])){
    $productId = $_GET['id'];
//    $sql = "delete from cart where id_item = $productId and id_user = '$user_id'";
    $sql = $connection->exec("delete from cart where id_item = $productId and id_user = '$user_id'");
//    $query = mysqli_query($GLOBALS['connection'],$sql);
    if(!$sql) {
        echo 'Error';
    }
}

//$getCartItems = "select * from cart where id_user = '$user_id'";
$sql = $connection->query("select * from cart where id_user = '$user_id'");
//$queryGetCart = mysqli_query($GLOBALS['connection'],$getCartItems);

if($sql){
    $data = [];
    while($assocData = $sql->fetch()){
        array_push($data,$assocData);
    }
    echo json_encode($data);
}