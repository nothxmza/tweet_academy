<?php

class Profile {
	public ProfileM $userDb;

	public function __construct(){
		$this->userDb = new ProfileM();
	}

	public function render(){
		if(isset($_SESSION["idUser"])){
			if(isset($_GET["username"]) )
				$infoUser = $this->userDb->infoUser($_GET["username"]);
			else
				$infoUser = $this->userDb->infoUserId($_GET["id"]);
			$user = $this->userDb->user($_SESSION['idUser']);
			$inF = $this->userDb->inFOLLOW($_SESSION['idUser']);
			$tab = [];
			$x = 0;
			for($i = 0; $i < count($inF);$i++){
				if($inF[$i]['username']){
					$tab[$x++]= $inF[$i]['username'];
				}
			}
			$id_user = $infoUser["id"];
			$countFollow = $this->userDb->countFollow($id_user);
			$countFollowing = $this->userDb->countFollowing($id_user);
			$infoFollow = $this->userDb->infoFollow($id_user);	
			$infoFollowing = $this->userDb->infoFollowing($id_user);			
			$i = $this->userDb->tweetExist($id_user);
			$hashtag = $this->userDb->renderHashtag();
			$userCo = $this->userDb->infoUserId($_SESSION['idUser']);
			$preferences = $this->userDb->getPreferences();
			$dark_mode = $preferences['darkmode'] ?? null;
			$lang = $preferences['lang'] ?? 'en';
			if($i != 0)
			{
				$infoTweet = $this->userDb->renderTweet($id_user);
			}
			require('vue/Profile.php');
		}else{
			header("location:index.php");
		}
	}
}