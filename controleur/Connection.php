<?php

class Connection {

	public ConnectionM $userDb;

	public function __construct(){
		$this->userDb = new ConnectionM();
	}

	public function render($tab){
		$errorMailPassword = 0;
		//////verifier si il a bien appuyer et si il est pas deja connecter
		if(!isset($_SESSION["idUser"]))
		{
			if(isset($tab['submit']))
			{
				if(isset($tab['password']) && isset($tab['mail']) && !empty($tab['password']) && !empty($tab['mail'])){
					if($this->userDb->verification($tab) == 0){
						header("location:index.php?action=accueil");
					}
					else{
						$errorMailPassword = 1;
					}
				}
				///mdp a verifier email ou name
				///age a verifier
				///et si compte pas desactiver///
			}
			require('vue/Connection.php');
		}else{
			header("location:index.php?action=accueil");
		}
	}
}