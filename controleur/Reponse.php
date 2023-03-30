<?php

class Reponse {
	public ReponseM $userDb;

	public function __construct(){
		$this->userDb = new ReponseM();
	}
	public function render($id)
	{
		if(isset($_SESSION["idUser"]))
		{
			if(!empty($id['id_tweet']))
			{
				$infoUser = $this->userDb->infoUser($_SESSION['idUser']);
				$id_user = $infoUser["id"];
				$hashtag = $this->userDb->renderHashtag();
				$user = $this->userDb->user($_SESSION['idUser']);
				$inF = $this->userDb->inFOLLOW($_SESSION['idUser']);
				$tab = [];
				$x = 0;
				for($i = 0; $i < count($inF);$i++){
					if($inF[$i]['username']){
						$tab[$x++]= $inF[$i]['username'];
					}
				}
				$info = $this->userDb->renderOneTweet($id['id_tweet']);
				$message = $this->userDb->renderMessage($id['id_tweet']);
				$userInfo = $this->userDb->renderInfo($id['id_tweet']);
				///dans la vue un input text pour ecrire la reponse 
				////en ajax faut que je recupe la valeur du champs text pour lenvoyer a mon insert dans un fichier php
				///ensuit il faut que je laffiche avec une autre requet a voir si possible de le faire sur la meme page pu pas
				///sinon une autre page ajax et une autre php
				///a voir si possible de rajouter un boutton pour modifier et supprimer
			}
			if(isset($_POST['submit']))
			{
				$_SESSION['reponse'] = $_POST["reponse"];
			}
			require('vue/Reponse.php');
		}
		else{
			header("location:index.php");
		}
		
	}
}


