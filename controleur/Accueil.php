<?php

class Accueil {
	public AccueilM $userDb;

	public function __construct(){
		$this->userDb = new AccueilM();
	}

	public function render($tab){
		$info = null;
		$i = 0;
		if(isset($_SESSION['idUser']))
		{	
			$user = $this->userDb->user($_SESSION['idUser']);
			$inF = $this->userDb->inFOLLOW($_SESSION['idUser']);
			$tabe = [];
			$x = 0;
			for($i = 0; $i < count($inF);$i++){
				if($inF[$i]['username']){
					$tabe[$x++]= $inF[$i]['username'];
				}
			}
			$preferences = $this->userDb->getPreferences();
        	$dark_mode = $preferences['darkmode'] ?? null;
        	$lang = $preferences['lang'] ?? 'en';
			$infoUser = $this->userDb->infoUser($_SESSION['idUser']);
			if(isset($tab['submit']))
			{
				if(!empty($tab['imgTweet']) ||  !empty($tab['text']))
					$this->userDb->tweet($tab);
			}
			$i = $this->userDb->tweetExist();
			if($i != 0)
				$info = $this->userDb->renderTweet();
			$hashtag = $this->userDb->renderHashtag();
			require('vue/Accueil.php');
		}
		else{
			header("location:index.php");
		}
	}
}