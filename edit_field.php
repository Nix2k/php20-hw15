<?php
	require_once './routines.php';

	if ((isset($_GET['fname']))&&(isset($_GET['edit']))){
		$table = clearInput($_GET['table']);
		$field = clearInput($_GET['field']);
		$fname = clearInput($_GET['fname']);
		if (isset($_GET['ftype'])) {
			$ftype = clearInput($_GET['ftype']);
			if ($_GET['ftype'.$i]=='VARCHAR') {
				$fsize = '('.clearInput($_GET['fsize'.$i]).')';
			}
			else {
				$fsize = '';
			}
		}
		else {
			$ftype = '';
		}

		$sql = "ALTER TABLE $table CHANGE $field $fname $ftype $fsize";

		try {
		   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
		   	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$pdo->exec($sql);
		header('location: index.php');
	}

	if ((isset($_GET['table']))&&(isset($_GET['field']))){
		$table = clearInput($_GET['table']);
		$field = clearInput($_GET['field']);
		
		try {
		   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
		   	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$sql = "SHOW COLUMNS FROM ".$table." WHERE Field='".$field."'";
		$columns = $pdo->query($sql);
		foreach ($columns as $col) {
			$type = explode('(',$col['Type']);
			$size = substr($type[1], 0, -1);
			switch ($type[0]) {
				case 'int':
					$types = '<option selected>INT</option><option>VARCHAR</option><option>DATE</option>';
					break;
				case 'varchar':
					$types = '<option>INT</option><option selected>VARCHAR</option><option>DATE</option>';
					break;
				case 'date':
					$types = '<option>INT</option><option>VARCHAR</option><option selected>DATE</option>';
					break;
				default:
					$types = '<option>INT</option><option>VARCHAR</option><option>DATE</option>';
					break;
			}
			echo '<table cellspacing="0" border="1" cellpadding="5" style="border-collapse: collapse;">
					<tr>
						<th>Поле</th>
						<th>Тип</th>
						<th>Размер</th>
					</tr>
					<form action="edit_field.php" method="GET">
					<input type="hidden" name="table" value="'.$table.'">
					<input type="hidden" name="field" value="'.$field.'">
					<tr>
						<td><input type="text" name="fname" value="'.$col['Field'].'"></td>
						<td><select name="ftype">'.$types.'</select></td>
						<td><input type="text" name="fsize" value="'.$size.'"></td>
						<td><input type="submit" name="edit" value="Ok"></td>
					</tr>
					</form>
				</table>';
		}
	}
?>
