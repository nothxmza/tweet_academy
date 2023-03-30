<?php

$db = new PDO('mysql:host=127.0.0.1:8889;dbname=common-database;charset=utf8', 'root', 'root');

if(isset($_POST['bio']) || isset($_POST['banner']) || isset($_POST['avatar'])){
	$stmt = $db->prepare("UPDATE user SET bio = ?, banner = ?, avatar = ? WHERE id = ?");
	$stmt->bindValue(1, $_POST['bio'], PDO::PARAM_STR);
	$stmt->bindValue(2, $_POST['banner'], PDO::PARAM_STR);
	$stmt->bindValue(3, $_POST['avatar'], PDO::PARAM_STR);
	$stmt->bindValue(4, $_POST['id'], PDO::PARAM_INT);
	$stmt->execute();
}
	