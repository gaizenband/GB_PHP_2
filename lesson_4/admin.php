<?php
include "config.php";

if($_GET['action'] == 'change'){
    $salt = "lxfjn1";
    $imgName = $_FILES['image']['name'].$salt;
    $path = "./img/$imgName";
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $id = $_POST['id'];

    if($_FILES['image']['name'] != ''){
//        $sql = "update shop set img = '$imgName', product_name = '$name',short_desc = '$desc',price = '$price' where id = $id";
        $sql = $connection->exec("update shop set img = '$imgName', product_name = '$name',short_desc = '$desc',price = '$price' where id = $id");
        if($sql && move_uploaded_file($_FILES['image']['tmp_name'],$path)){
            header("Location: index.html");
        } else {
            echo mysqli_error($GLOBALS['connection']);
        }
    } else {
//        $sql = "update shop set product_name = '$name',short_desc = '$desc',price = '$price' where id = $id";
        $sql = $connection->exec("update shop set product_name = '$name',short_desc = '$desc',price = '$price' where id = $id");
        if($sql){
            header("Location: index.html");
        } else {
            echo mysqli_error($GLOBALS['connection']);
        }
    }
    
} elseif($_GET['action'] == 'new'){
    $salt = "lxfjn1";
    $imgName = $_FILES['image']['name'].$salt;
    $path = "./img/$imgName";
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];

//    $sql = "insert into shop(img,product_name,short_desc,price,long_desc,in_storage) values('$imgName','$name','$desc',$price,'$desc',100)";
    $sql = $connection->exec("insert into shop(img,product_name,short_desc,price,long_desc,in_storage) values('$imgName','$name','$desc',$price,'$desc',100)");
    if($sql && move_uploaded_file($_FILES['image']['tmp_name'],$path)){
        header("Location: index.html");
    } else {
        echo mysqli_error($GLOBALS['connection']);
    }
} elseif($_GET['delete'] == '1'){
    $id = $_GET['id'];
//    $sql = "delete from shop where id = $id";
    $sql = $connection->exec("delete from shop where id = $id");
//    $query = mysqli_query($GLOBALS['connection'],$sql);
    if($sql){
        echo "Done";
    } else {
        echo mysqli_error($GLOBALS['connection']);
    }
}
// $sql = "select * from orders where id_user = $user_id";
// $query = mysqli_query($GLOBALS['connection'],$sql);
// if($query){
//     $data = [];
//     while($assocData = mysqli_fetch_assoc($query)){
//         array_push($data,$assocData);
//     }
//     echo json_encode($data);
// }else{
//     echo (mysqli_error($GLOBALS['connection']));
// }