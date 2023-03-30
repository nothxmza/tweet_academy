<?php

class Inscription {
	public InscriptionM $userDb;

	public function __construct(){
		$this->userDb = new InscriptionM();
	}

	public function render($tab){
		$errorMail = 0;
		/////verifier si il a bien appuyer et si il est pas deja connecter
		if(!isset($_SESSION['idUser']))
		{
			if(isset($tab['submit'])){
				if(isset($tab['name']) && isset($tab['username']) && isset($tab['mail']) && isset($tab['month']) && isset($tab['day'])  && isset($tab['year']) && isset($tab['password']) && ( !empty($tab['name']) &&  !empty($tab['username']) &&  !empty($tab['mail']) && !empty($tab['month']) && !empty($tab['day'])  && !empty($tab['year'])  &&  !empty($tab['password'])))
				{
					if($this->userDb->verifMailUsername($tab) == 1){
						$errorMail = 1;
					}
					else if($this->userDb->verifMailUsername($tab) == 2)
					{
						$errorMail = 2;
					}
					else if($this->userDb->verifMailUsername($tab) == 3)
					{
						$errorMail = 3;
					}
					else if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $tab['password']) == 0){
						$errorMail = 4;
					}
					else{
						//$this->userDb->inscription($tab);
						//echo "inscript";
						$this->userDb->inscription($tab);
						header("location:index.php");
					}
				}
			}
			require('vue/Inscription.php');
		}
		else{
			header("location:index.php?action=accueil");
		}
	}
}