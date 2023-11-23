<?php

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

include_once("../config/Dbconfig.php");

$mysql_conn = new Dbconfig;

session_start();

$conn = $mysql_conn->connect();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM agenda.users where username='$username'";

$query = $conn->query($sql);

if (mysqli_num_rows($query) > 0) {

	foreach ($query as $valor) {

		if (password_verify($password, $valor['password'])) {
			$_SESSION['auth'] = $valor['id'];
			$_SESSION['userStatus'] = $valor['status'];
			$_SESSION['mensage'] = "";
			$_SESSION['newPassword'] = "";
			$_SESSION['confirmPassword'] = "";
			$_SESSION['name'] = "";
			$_SESSION['email'] = "";
			header("location: $URL_ATUAL/agenda/");
		} else {
			$_SESSION['mensage'] = "Usuário incorreto!";
			header("location: $URL_ATUAL/agenda/login.php");
		}
	}
} else {
	$_SESSION['mensage'] = "Não existe nenhum usuário";
	header("location: $URL_ATUAL/agenda/login.php");
}
