<?php

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

include_once("./src/config/Dbconfig.php");

$mysql_conn = new Dbconfig;

session_start();

$conn = $mysql_conn->connect();

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$status = $_POST['status'];

if ($name && $username && $password && $email && $status) {

	$sql = "SELECT * FROM agenda.users where username='$username'";

	$verifica_usuario = $conn->query($sql);

	if (mysqli_num_rows($verifica_usuario) > 0) {
		$_SESSION['mensage'] = "Já existe um usuário!";
		header("location: ./index.php?menu=criarUsuario");
	} else {

		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$query_criar = "INSERT INTO users(name,username,email, password,status) VALUES ('$name', '$username', '$email', '$hashed_password', '$status')";
		mysqli_query($conn, $query_criar);
		$_SESSION['mensage'] = "";
		header("location: ./");
	}
} else {
	$_SESSION['mensage'] = "Erro ao criar usuário!";
	header("location: ./index.php?menu=criarUsuario");
}
