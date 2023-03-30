<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');


if(isset($_POST['id_user']) && isset($_POST['id_follow']))
{
	$requet = "INSERT INTO follow(id_follower,id_following) VALUE(:id_follower,:id_following)";
	$r = $db->prepare($requet);
	$r->execute([
		"id_follower" => $_POST['id_user'],
		"id_following" => $_POST['id_follow']
	]);

	$requet = "SELECT * from follow
	RIGHT JOIN user ON id_following = user.id
	WHERE user.id = :id";
	$r = $db->prepare($requet);
	$r->execute([
		"id" => $_POST['id_follow']
	]);

	echo json_encode($r->fetchAll());
}