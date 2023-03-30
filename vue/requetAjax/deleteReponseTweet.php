<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');

if(isset($_POST["id_reponse"]))
{
	$requet = $db->prepare("DELETE FROM tweets WHERE id = :id");
	$requet->execute([
		"id" => $_POST['id_reponse']
	]);
}


