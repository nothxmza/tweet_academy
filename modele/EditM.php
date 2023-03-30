<?php

require_once("DataBase.php");

class EditM {
	public DataBase $base;
	public ?\PDO $db;
	public $id = 0;

	public function __construct(){
		$this->base = new DataBase();
		$this->db = $this->base->CoDb();
	}

	public function updateUserProfile($userId, $bio, $banner, $avatar) {
			$stmt = $this->db->prepare("UPDATE user SET bio = ?, banner = ?, avatar = ? WHERE id = ?");
			$stmt->bindValue(1, $bio, PDO::PARAM_STR);
			$stmt->bindValue(2, $banner, PDO::PARAM_STR);
			$stmt->bindValue(3, $avatar, PDO::PARAM_STR);
			$stmt->bindValue(4, $userId, PDO::PARAM_INT);
			$stmt->execute();
		}
		public function user($id){
			$requet = "SELECT * from user
			WHERE id = :id";
			
			$user = $this->db->prepare($requet);
			$user->execute([
				"id" => $id
			]);
			$info = $user->fetchAll();
			return $info;
		}
}