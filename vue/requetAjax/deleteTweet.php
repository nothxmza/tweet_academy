<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');


if(isset($_POST['tweet_id']))
{
	$tweet_id = $_POST['tweet_id'];
	$requet ="SELECT * FROM hashtag_relation
	LEFT JOIN hashtag ON hashtag_relation.hashtag_id = hashtag.hashtag
	LEFT JOIN tweets ON hashtag_relation.tweet_id = tweets.id
    WHERE tweets.id = :id";
	$r = $db->prepare($requet);
	$r->execute([
		"id" =>  $_POST['tweet_id']
	]);
	$info = $r->fetchAll();

	if(!empty($info))
		$occurences =  $info[0]['occurences'];
	$requet = $db->prepare("DELETE FROM image WHERE id_tweet = :id_tweet");
	$requet->execute([
		"id_tweet" => $_POST['tweet_id']
	]);

	if(!empty($info))
	{
		$requet = $db->prepare("DELETE FROM hashtag_relation WHERE tweet_id = :tweet_id");
		$requet->execute([
			"tweet_id" => $_POST['tweet_id']
		]);
	}
	

	if(!empty($info))
	{
		if($occurences >= 0)
		{
			$requet = "UPDATE hashtag SET occurences =:occurences WHERE hashtag =:hashtag ";
			$insertInfo = $db->prepare($requet);
			$insertInfo->execute([
				"occurences" => $occurences - 1,
				"hashtag" => $info[0]['hashtag']
			]);
			$occurences -= 1;
		}
		
	}
	if(!empty($info))
	{
		if($occurences <=  0)
		{
			$requet = $db->prepare("DELETE FROM hashtag WHERE hashtag = :hashtag");
			$requet->execute([
				"hashtag" => $info[0]['hashtag']
			]);
		}
	}

	$requet = $db->prepare("DELETE FROM tweets WHERE parent = :parent");
	$requet->execute([
		"parent" => $tweet_id
	]);

	$requet = $db->prepare("DELETE FROM tweets WHERE id = :id");
	$requet->execute([
		"id" => $tweet_id
	]);

		echo json_encode($info);
}
