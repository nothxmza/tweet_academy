<?php

require_once("DataBase.php");

class UserDb {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function infoUser(){
		$requet = "SELECT * from user
		Where id =:id";
		$user = $this->db->prepare($requet);
		$user->execute([
			'id' => $_SESSION['idUser']
		]);
		$info = $user->fetchAll();
		return $info;
	}


	public function searchUser($tab){
		$requet = "SELECT username from user
		WHERE username LIKE :username";
		$r = $this->db->prepare($requet);
		$r->execute([
			"username" => $tab . "%"
		]);
		var_dump($r->fetch());
	}
}