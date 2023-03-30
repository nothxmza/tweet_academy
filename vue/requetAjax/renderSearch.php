<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');

if(isset($_POST['searchResult']))
{
	$requet = "SELECT username from user
	WHERE username LIKE :username";
	$r = $db->prepare($requet);
	$r->execute([
		"username" =>$_POST['searchResult'] . "%"
	]);
	$user = $r->fetchAll();
	if(stristr($_POST['searchResult'],"#")!= false)
	{
		$requet = "SELECT hashtag from hashtag
		WHERE hashtag LIKE :hashtag";
		$r = $db->prepare($requet);
		$r->execute([
			"hashtag" =>$_POST['searchResult'] . "%"
		]);
	}
	
	$hash = $r->fetchAll();
	$total = array_merge($user,$hash);
	echo json_encode($total);
}
