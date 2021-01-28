<?php

const SERVER = "localhost";
const DB = "myphp";
const LOGIN = "root";
const PASS = "root";

$connection = mysqli_connect(SERVER,LOGIN,PASS,DB) or die("Ошибка при подключении в БД");

?>