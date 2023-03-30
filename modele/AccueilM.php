<?php

require_once("DataBase.php");

class AccueilM {
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

	public function tweet($tab){

		$requet = "INSERT INTO tweets(id_user,message) VALUE(:id_user,:message)";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_user" => $_SESSION['idUser'],
			"message" => $tab['text']
		]);
		$requet = "SELECT * from tweets
		WHERE id_user =:id_user";
		$r = $this->db->prepare($requet);
		$r->execute([
			"id_user" => $_SESSION['idUser']
		]);

		$info = $r->fetchAll();
		$count = count($info);
		$idTweet = $info[$count - 1]['id'];
		if(!empty($tab["imgTweet"]))
		{
			$requet = "INSERT INTO image(id_tweet, url) VALUE(:id_tweet, :url)";
			$r = $this->db->prepare($requet);
			$r->execute([
				"id_tweet" => $idTweet,
				"url" => $tab["imgTweet"]
			]);
		}
		
		$flag = 0;
		$word = null;
		$size = strlen($tab['text']);
		for($i = 0; $i < $size;$i++)
		{
			if( $tab['text'][$i] == '#')
				$flag = 1;
		}
		if($flag == 1)
		{
			$pos = strpos($tab['text'], "#");
			$size = strlen($tab['text']);
			$x = 0;
			for($i = $pos; $i < $size;$i++)
			{
				if( $tab['text'][$i] == ' ')
					break;
				else
					$word .= $tab['text'][$i];
			}
			$requet = "SELECT * from hashtag
			WHERE hashtag=:hashtag";
			$r = $this->db->prepare($requet);
			$r->execute([
				"hashtag" => $word
			]);
			$hashtag = $r->fetch();
			if(!empty($hashtag))
			{
				$requet = "UPDATE hashtag SET occurences =:occurences where hashtag =:hashtag";
				$insertInfo = $this->db->prepare($requet);
				$insertInfo->execute([
					"occurences" => $hashtag["occurences"] + 1,
					"hashtag" => $word
				]);

				$requet = "INSERT INTO hashtag_relation(tweet_id,hashtag_id) VALUE(:tweet_id,:hashtag_id)";
				$r = $this->db->prepare($requet);
				$r->execute([
					"tweet_id" => $idTweet,
					"hashtag_id" => $hashtag['hashtag']
				]);
			}
			else{
				$requet = "INSERT INTO hashtag(hashtag) VALUE(:hasthag)";
				$r = $this->db->prepare($requet);
				$r->execute([
					"hasthag" => $word
				]);

				$requet = "SELECT * from hashtag
				WHERE hashtag=:hashtag";
				$r = $this->db->prepare($requet);
				$r->execute([
					"hashtag" => $word
				]);
				$hashtag = $r->fetch();

				$requet = "INSERT INTO hashtag_relation(tweet_id,hashtag_id) VALUE(:tweet_id,:hashtag_id)";
				$r = $this->db->prepare($requet);
				$r->execute([
					"tweet_id" => $idTweet,
					"hashtag_id" => $hashtag['hashtag']
				]);
			}
		}
	}
/////alors verifie que ca existe et ensuite en fonction modifier loccurence et ajotuer dans la table de relation
	public function tweetExist()
	{
		$requet ="SELECT * FROM tweets";

		$r = $this->db->prepare($requet);
		$r->execute();
		$info = $r->fetchAll();
		if(!empty($info))
			return 1;
		else
			return 0;
	}

	public function renderTweet(){

		$requet ="SELECT * FROM tweets
		LEFT JOIN image ON tweets.id = image.id_tweet
		LEFT JOIN user ON tweets.id_user = user.id
		order by tweets.id DESC";
		$r = $this->db->prepare($requet);
		$r->execute();
		$info = $r->fetchAll();
		if(count($info) < 1)
		{
			$requet ="SELECT * FROM tweets";
			$r = $this->db->prepare($requet);
			$r->execute();
			$text = $r->fetchAll();
			return $text;
		}
		else{
			return $info;
		}
	}

	public function infoUser($id){
		$requet = "SELECT * from user
		Where id =:id";
		$user = $this->db->prepare($requet);
		$user->execute([
			'id' => $id
		]);
		$info = $user->fetch();
		return $info;
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