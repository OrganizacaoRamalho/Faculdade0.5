<?php
$hostName = "localhost";
$dataBase = "faculdade";
$user = "root";
$password = "";
$port = 3307;

$mysqli = new mysqli($hostName, $user, $password, $dataBase, $port);

	if ($mysqli->connect_errno)
	{
	echo "Falha ao conectar:(" .$mysqli->connect_errno. ")" .$mysqli->connect_errno;
	}
?>