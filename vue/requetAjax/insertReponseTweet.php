<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');



if(isset($_POST["reponse"]))
{
	$requet = "INSERT INTO tweets(id_user,message,parent) VALUE(:id_user,:message,:parent)";
		$insertInfo = $db->prepare($requet);
		$insertInfo->execute([
			'id_user' => $_POST['user_id'],
			'message' =>  $_POST["reponse"],
			'parent' => $_POST["tweet_id"]
		]);

	$requet = "SELECT * FROM tweets
	WHERE parent =:parent";
	$r = $db->prepare($requet);
	$r->execute([
		"parent" => $_POST['tweet_id']
	]);
	echo json_encode($r->fetchAll());
}