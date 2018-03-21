<?php
	require_once 'routines.php';

	try {
	   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
	   	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = 'SHOW TABLES';
	$tables = $pdo->query($sql);

	echo "<h2>Таблицы в БД</h2>";
?>
	<h3>Создать таблицу</h3>
	<form action="create_tab.php" method="GET">
		<input type="text" name="name" placeholder="Название"><br>
		<input type="text" name="cols" placeholder="Количество полей"><br>
		<input type="submit" name="submit" placeholder="Создать"><br>
	</form>
<?php
	foreach ($tables as $table) {
		echo "<h3>$table[0]</h3>";
		$sql1 = 'SHOW COLUMNS FROM '.$table[0];
		$columns = $pdo->query($sql1);
		echo '<table cellspacing="0" border="1" cellpadding="5" style="border-collapse: collapse;">
				<tr>
					<th>Поле</th>
					<th>Тип</th>
					<th>Пустое</th>
					<th>Ключ</th>
					<th>Значение по умолчанию</th>
					<th>Дополнительно</th>
				</tr>';
		foreach ($columns as $col) {
			echo "<tr>
					<td>".$col['Field']."</td>
					<td>".$col['Type']."</td>
					<td>".$col['Null']."</td>
					<td>".$col['Key']."</td>
					<td>".$col['Default']."</td>
					<td>".$col['Extra']."</td>
				</tr>";
		}
		echo '</table>';
	}
?>
