<?php

require_once("DataBase.php");

class InscriptionM {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function verifMailUsername($tab){
		$requet = "SELECT mail,username from user
		WHERE mail = :mail AND username = :username";
		$info = $this->db->prepare($requet);
		$info->execute([
			'mail' => $tab['mail'],
			'username' => $tab['username']
		]);
		$recipes = $info->fetch();
		if(!empty($recipes['mail']))
			return 3;
		$requet = "SELECT mail from user
		WHERE mail = :mail";
		$info = $this->db->prepare($requet);
		$info->execute([
			'mail' => $tab['mail'],
		]);
		$recipes = $info->fetch();
		if(!empty($recipes['mail']))
			return 1;
		$requet = "SELECT username from user
		WHERE username = :username";
		$info = $this->db->prepare($requet);
		$info->execute([
			'username' => $tab['username']
		]);
		$recipes = $info->fetch();
		if(!empty($recipes['username']))
			return 2;
		return 0;
	}

	public function inscription($tab){

		$date = $tab['year'].'-'.$tab['day'].'-'.$tab['month'];
		$requet = "INSERT INTO user(mail,name,username,birthday,password) VALUE(:mail,:name,:username,:birthday,:password)";
		$insertInfo = $this->db->prepare($requet);
		$insertInfo->execute([
			'mail' => $tab['mail'],
			'name' =>  $tab['name'],
			'username' => $tab['username'],
			'birthday' => $date,
			'password' =>  hash('ripemd160',$tab['password'] . "vive le projet tweet_academy")
		]);
	}
}