<?php
include "config.php";

try {
    $count = $connection->query('select count(*) from shop')->fetchColumn();
    echo json_encode(['val'=>$count]);
}catch(Exception $e){
    echo $e;
}
