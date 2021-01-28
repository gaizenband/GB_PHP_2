<?php
include "config.php";
header('Content-type: application/json');

if(isset($_GET['start'])){
    $queryString = "select * from shop LIMIT $_GET[start],$_GET[end]";
}else{
    $queryString = "select * from shop";
}
$sql = $connection->query($queryString);

$data = [];
while($assocData = $sql->fetch(PDO::FETCH_ASSOC)){
    array_push($data,$assocData);
}
echo json_encode($data);


