<?php

class Hashtag {

	public HashtagM $userDb;

	public function __construct(){
		$this->userDb = new HashtagM();
	}

	public function render(){
		$info = null;
		$i = 0;
		if(isset($_SESSION['idUser']))
		{
			$hashtagAll = $this->userDb->renderAllHashtag($_GET['name']);
			$user = $this->userDb->user($_SESSION['idUser']);
			$inF = $this->userDb->inFOLLOW($_SESSION['idUser']);
			$tab = [];
			$x = 0;
			for($i = 0; $i < count($inF);$i++){
				if($inF[$i]['username']){
					$tab[$x++]= $inF[$i]['username'];
				}
			}
			$infoUser = $this->userDb->infoUser($_SESSION['idUser']);
			$hashtag = $this->userDb->renderHashtag();
			require('vue/Hashtag.php');
		}
		else{
			header("location:index.php?action=accueil");

		}
	}
	
}