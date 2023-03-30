<?php

require_once("DataBase.php");

class ReponseM {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function renderOneTweet($id){

		$requet ="SELECT * FROM tweets
		LEFT JOIN image ON tweets.id = image.id_tweet
		WHERE tweets.id =:id";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id" => $id
		]);
		$info = $r->fetchAll();
		if(isset($info))
			$_SESSION["id_parent"] = $id;
		return $info;
	}

	public function renderMessage($id)
	{
		$requet ="SELECT * FROM tweets
		WHERE parent = :parent";
		$r = $this->db->prepare($requet);
		$r->execute([
			"parent" => $id
		]);
		return $r->fetchAll();
	}
	public function infoUser($username){
		$requet = "SELECT * from user
		WHERE id = :id";
		$user = $this->db->prepare($requet);
		$user->execute([
			'id' => $username
		]);
		$info = $user->fetch();
		return $info;
	}
	public function renderHashtag(){
		$requet ="SELECT * FROM hashtag
		order by occurences DESC";
		$r = $this->db->prepare($requet);
		$r->execute();
		return $r->fetchAll();
	}
	public function user($id){
		$requet = "SELECT * FROM user 
		LEFT JOIN follow
		ON user.id = follow.id_following 
		WHERE (follow.id_follower != :id OR follow.id_follower IS NULL) AND user.id != :id";
		
		$user = $this->db->prepare($requet);
		$user->execute([
			"id" => $id
		]);
		$info = $user->fetchAll();
		return $info;
	}
	public function renderInfo($id) {
		$requet = "SELECT *
		FROM user
		INNER JOIN tweets ON user.id = tweets.id_user
		WHERE tweets.id = :id";

		$avatar = $this->db->prepare($requet);
		$avatar->execute([
			"id" => $id
		]);
		$info = $avatar->fetch();
		return $info;
	}
	public function inFOLLOW($id){
		$requet = "SELECT * FROM user 
		LEFT JOIN follow ON user.id = follow.id_following
		WHERE follow.id_follower = :id";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id" => $id
		]);
		return $r->fetchAll();
	}
}