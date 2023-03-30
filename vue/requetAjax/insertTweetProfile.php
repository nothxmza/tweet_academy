<?php
$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');

echo "ok";
echo $_POST['message'];
echo $_POST['id_user'];
if(!empty($_POST['message']) && !empty($_POST['id_user'])){
	$requet = "INSERT INTO tweets(id_user,message) VALUE(:id_user,:message)";
	$r =$db->prepare($requet);
	$r->execute([
		"id_user" => $_POST['id_user'],
		"message" => $_POST['message']
	]);
	$requet = "SELECT * from tweets
	WHERE id_user =:id_user";
	$r =$db->prepare($requet);
	$r->execute([
		"id_user" => $_POST['id_user']
	]);

	$info = $r->fetchAll();
	$count = count($info);
	$idTweet = $info[$count - 1]['id'];
	if(!empty($_POST['url'])){
		$requet = "INSERT INTO image(id_tweet, url) VALUE(:id_tweet, :url)";
		$r =$db->prepare($requet);
		$r->execute([
			"id_tweet" => $idTweet,
			"url" => $_POST['url']
		]);
	}
	
	$flag = 0;
	$word = null;
	$size = strlen($_POST['message']);
	for($i = 0; $i < $size; $i++){
		if($_POST['message'][$i] == '#')
			$flag = 1;
	}
	if($flag == 1){
		$pos = strpos($_POST['message'], "#");
		$size = strlen($_POST['message']);
		$x = 0;
		for($i = $pos; $i < $size;$i++)
		{
			if( $_POST['message'][$i] == ' ')
				break;
			else
				$word .= $_POST['message'][$i];
		}
		$requet = "SELECT * from hashtag
		WHERE hashtag=:hashtag";
		$r = $db->prepare($requet);
		$r->execute([
			"hashtag" => $word
		]);
		$hashtag = $r->fetch();
		if(!empty($hashtag))
		{
			$requet = "UPDATE hashtag SET occurences =:occurences where hashtag =:hashtag";
			$insertInfo = $db->prepare($requet);
			$insertInfo->execute([
				"occurences" => $hashtag["occurences"] + 1,
				"hashtag" => $word
			]);

			$requet = "INSERT INTO hashtag_relation(tweet_id,hashtag_id) VALUE(:tweet_id,:hashtag_id)";
			$r = $db->prepare($requet);
			$r->execute([
				"tweet_id" => $idTweet,
				"hashtag_id" => $hashtag['hashtag']
			]);
		}
		else{
			$requet = "INSERT INTO hashtag(hashtag) VALUE(:hasthag)";
			$r = $db->prepare($requet);
			$r->execute([
				"hasthag" => $word
			]);

			$requet = "SELECT * from hashtag
			WHERE hashtag=:hashtag";
			$r = $db->prepare($requet);
			$r->execute([
				"hashtag" => $word
			]);
			$hashtag = $r->fetch();

			$requet = "INSERT INTO hashtag_relation(tweet_id,hashtag_id) VALUE(:tweet_id,:hashtag_id)";
			$r = $db->prepare($requet);
			$r->execute([
				"tweet_id" => $idTweet,
				"hashtag_id" => $hashtag['hashtag']
			]);
		}
		
	}echo json_encode($hashtag);
}