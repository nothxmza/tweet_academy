<?php

class DataBase{
	public $db = null;

	public function CoDb(){
		if($this->db == null)
			$this->db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');
		return $this->db;
	}
}