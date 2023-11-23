<?php 

$URL_ATUAL= "http://$_SERVER[HTTP_HOST]";

session_start();
session_destroy();

header("Location: $URL_ATUAL/agenda/login.php");

 ?>