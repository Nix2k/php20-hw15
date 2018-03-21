<?php
	require_once 'routines.php';

	try {
	   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
	   	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = 'SHOW TABLES';
	$tables = $pdo->query($sql);

	foreach ($tables as $table) {
		echo "<h3>$table[0]</h3>";
	}
?>
