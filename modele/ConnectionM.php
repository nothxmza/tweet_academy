<?php

require_once("DataBase.php");

class ConnectionM {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function verification($tab){
		echo "dans verification";

		$requet = "SELECT * FROM user
		WHERE mail = :mail or username = :mail AND password = :password";
		$user = $this->db->prepare($requet);
		$user->execute([
			'mail' => $tab['mail'],
			'username' => $tab['mail'],
			'password' =>  hash('ripemd160',$tab['password'] . "vive le projet tweet_academy")
		]);
		$infos =$user->fetchAll();
		//var_dump($infos);
		if(!empty($infos))
		{
			foreach($infos as $info){
				$_SESSION['idUser'] = $info['id'];
			 }
			echo $_SESSION['idUser'];
			return 0;
		}
		else{
			return 1;
		}
	}
	
}