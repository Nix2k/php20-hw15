<?php
	require_once './routines.php';
	if ((isset($_GET['table']))&&(isset($_GET['field']))){
		$table = clearInput($_GET['table']);
		$field = clearInput($_GET['field']);
		
		$sql = "ALTER TABLE $table DROP COLUMN $field";

		try {
		   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
		   	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$pdo->exec($sql);
		header('location: index.php');
	}
?>
