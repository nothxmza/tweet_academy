<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');


$requet ="SELECT * FROM tweets
		RIGHT JOIN image ON tweets.id = image.id_tweet
       	where id_user =:id_user";

		$r = $db->prepare($requet);
		$r->execute([
			"id_user" => $_POST['id_user']
		]);
echo json_encode($r->fetchAll());
