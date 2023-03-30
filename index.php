<?php
////faut compter un rt comme un tweet lorsque lon clique sur rt sa lajioute a la page de persnne qui a appuyer
///clique sur suivre apparait dans abonnement et dans abonne poour lautre 
session_start();

require("controleur/Connection.php");
require("controleur/Inscription.php");
require("controleur/Accueil.php");
require("controleur/Reponse.php");
require("controleur/Profile.php");
require("controleur/Hashtag.php");
require("controleur/Edit.php");
require("controleur/Preferences.php");

require("modele/UserData.php");
require("modele/ConnectionM.php");
require("modele/InscriptionM.php");
require("modele/AccueilM.php");
require("modele/ReponseM.php");
require("modele/ProfileM.php");
require("modele/HashtagM.php");
require("modele/EditM.php");

require("modele/PreferencesM.php");


$connection = new Connection();
$inscription = new Inscription();
$accueil = new Accueil();
$reponse = new Reponse();
$profile = new Profile();
$hashtag = new Hashtag();
$edit = new Edit();
$preferences = new Preferences();

	if(isset($_GET["action"]))
	{
		if($_GET["action"] == "inscription" ){
			$inscription->render($_POST);
		}
		else if($_GET["action"] == "accueil"){
			$accueil->render($_POST);
		}
		else if($_GET["action"]== "reponse"){
			$reponse->render($_GET);
		}
		else if($_GET["action"] == "profile"){
			$profile->render($_GET);
		} 
		else if($_GET["action"] == "preferences"){
			$preferences->render($_POST);
		}
		else if($_GET["action"] == "hashtag"){
			$hashtag->render($_GET);
		}
		else if($_GET["action"] == "edit"){
			$edit->render();
		}
	}else{
		$connection->render($_POST);
	}