<?php
include_once "Connection.php";
include_once "config.php";

class GetImages extends Connection
{
    public function __construct() {
        return parent::getInstance();
    }
}

$img = new GetImages();
$img_array = $img->connect($connection);
