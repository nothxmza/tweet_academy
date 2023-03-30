<?php

require_once("DataBase.php");

class ProfileM {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function getPreferences() {
        $requete = "SELECT * from preferences where id_user = :id_user";
        $user = $this->db->prepare($requete);
        $user->execute([
            'id_user' => $_SESSION['idUser']
        ]);
        $info = $user->fetch();
        //si la requete ne retourne rien, on insert les preferences par defaut
        if(empty($info)) {
            $this->insertPreferences("white", "fr");
            $info = $this->getPreferences();
        }
        return $info;
    }

    public function insertPreferences($dark_mode, $lang) {
        $requete = "INSERT INTO preferences (id_user, darkmode, lang) VALUES (:id_user, :dark_mode, :lang)";
        $user = $this->db->prepare($requete);
        $user->execute([
            'id_user' => $_SESSION['idUser'],
            'dark_mode' => $dark_mode,
            'lang' => $lang
        ]);
    }

    public function updatePreferences($dark_mode, $lang){
        $darkmode_value = $dark_mode ? "dark" : "white";
        $requete = "UPDATE preferences SET darkmode = :dark_mode, lang = :lang WHERE id_user = :id_user";
        $user = $this->db->prepare($requete);
        $user->execute([
            'dark_mode' => $darkmode_value,
            'lang' => $lang,
            'id_user' => $_SESSION['idUser']
        ]);
    }

	public function infoUser($username){
		$username = trim($username," ");
		$requet = "SELECT * from user
		WHERE username = :username";
		$user = $this->db->prepare($requet);
		$user->execute([
			'username' => $username
		]);
		$info = $user->fetch();
		return $info;
	}

	public function infoUserId($username){
		$username = trim($username," ");
		$requet = "SELECT * from user
		WHERE id = :id";
		$user = $this->db->prepare($requet);
		$user->execute([
			'id' => $username
		]);
		$info = $user->fetch();
		return $info;
	}

	public function tweetExist($id_user)
	{
		$requet ="SELECT * FROM tweets
		WHERE id_user =:id_user";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_user" => $id_user
		]);
		$info = $r->fetchAll();
		if(!empty($info))
			return 1;
		else
			return 0;
	}

	public function urlExist($id){
		$requet = "SELECT * from image
		where id_tweet =:id";
		$r = $this->db->prepare($requet);
		$r->execute();
		$info = $r->fetch();

		$requet ="SELECT * FROM tweets
		RIGHT JOIN image ON tweets.id = image.id_tweet
       	where id_user =:id_user";

		$r = $this->db->prepare($requet);
		$r->execute([
			"id_user" => $id_user
		]);
		$url = $r->fetchAll();

		if(!empty($info) && !empty($url))
			return 1;
		else if(!empty($info))
			return 2;
		else if(!empty($url))
			return 3;
		else
			return 0;
	}
	public function renderTweet($id_user){

		$requet ="SELECT * FROM tweets
		LEFT JOIN image ON tweets.id = image.id_tweet
		LEFT JOIN user ON tweets.id_user = user.id
       	where id_user =:id_user";

		$r = $this->db->prepare($requet);
		$r->execute([
			"id_user" => $id_user
		]);
		$info = $r->fetchAll();
		if(count($info) < 1)
		{
			$requet ="SELECT * FROM tweets
			WHERE id_user =:id_user";
			$r = $this->db->prepare($requet);
			$r->execute([
				"id_user" => $id_user
			]);
			$text = $r->fetchAll();
			return $text;
		}
		else{
			return $info;
		}
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
	public function renderHashtag(){
		$requet ="SELECT * FROM hashtag
		order by occurences DESC";
		$r = $this->db->prepare($requet);
		$r->execute();
		return $r->fetchAll();
	}

	public function countFollow($id){
		$requet = "SELECT count(*) FROM follow
		WHERE id_follower = :id_follower";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_follower" => $id
		]);
		return $r->fetch();
	}

	public function countFollowing($id){
		$requet = "SELECT count(*) FROM follow
		WHERE id_following = :id_following";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_following" => $id
		]);
		return $r->fetch();
	}

	public function infoFollow($id){
		$requet = "SELECT * FROM follow
		LEFT JOIN user ON follow.id_following = user.id
		WHERE id_follower = :id_follower";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_follower" => $id
		]);
		return $r->fetchAll();
	}

	public function infoFollowing($id){
		$requet = "SELECT * FROM user
		LEFT JOIN follow ON user.id = follow.id_follower
		WHERE id_following = :id_following";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_following" => $id
		]);
		return $r->fetchAll();
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