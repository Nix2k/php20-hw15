<?php
	require_once './routines.php';
	if ((isset($_GET['name']))&&(isset($_GET['cols']))&&(isset($_GET['submit']))){
		$name = clearInput($_GET['name']);
		$cols = clearInput($_GET['cols']);

		$types = '<option>INT</option><option>VARCHAR</option><option>DATE</option>';

		echo "<h2>Структура таблицы $name</h2>";
		echo '<form action="create_tab.php" method="POST">';
		echo '<table cellspacing="0" border="1" cellpadding="5" style="border-collapse: collapse;">
				<tr>
					<th>Поле</th>
					<th>Тип</th>
					<th>Размер</th>
					<th>Пустое</th>
					<th>Ключ</th>
					<th>Значение по умолчанию</th>
				</tr>';
		echo '<input type="hidden" name="name" value="'.$name.'">';
		echo '<input type="hidden" name="cols" value="'.$cols.'">';
		for ($i = 0; $i<$cols; $i++) {
			echo '<tr>';
			echo '<td><input type="text" name="fname'.$i.'" placeholder="Название поля"></td>';
			echo '<td><select name="ftype'.$i.'" placeholder="Tип поля">'.$types.'</select></td>';
			echo '<td><input type="text" name="fsize'.$i.'" placeholder="Длина поля"></td>';
			echo '<td><input type="checkbox" name="fnull'.$i.'" value="y">';
			echo '<td><input type="checkbox" name="fkey'.$i.'" value="y">';
			echo '<td><input type="text" name="fvalue'.$i.'" placeholder="Значение по умолчанию"></td>';
			echo '</tr>';
		}
		echo '</table><br><input type="submit" name="create" value="Создать">';
		echo '</form>';
	}
	if ((isset($_POST['name']))&&(isset($_POST['cols']))&&(isset($_POST['create']))){
		foreach ($_POST as $key => $value) {
			$_POST[$key] = clearInput($value);
		}

		$tabKey = '';
		$sql = 'CREATE TABLE `'.$dbName.'`.`'.$_POST['name'].'` (';
		for ($i=0; $i<$_POST['cols']; $i++) {
			if ($_POST['ftype'.$i]=='VARCHAR') {
				$size = '('.$_POST['fsize'.$i].')';
			}
			else {
				$size = '';
			}
			if (isset($_POST['fnull'.$i])) {
				$null = ' NULL ';
			}
			else {
				$null = ' NOT NULL ';
			}
			if ((isset($_POST['fvalue'.$i]))&&($_POST['fvalue'.$i]!='')) {
				$fValue = " DEFAULT '".$_POST['fvalue'.$i]."' ";
			}
			else {
				$fValue = '';
			}
			if (isset($_POST['fkey'.$i])) {
				$tabKey = " PRIMARY KEY (`".$_POST['fname'.$i]."`) ";
			}
			$sql = $sql.' `'.$_POST['fname'.$i].'` '.$_POST['ftype'.$i].$size.$null.$fValue.',';
		}
		if ($key=='') {
			$sql = substr($sql, 0, -1);
		}
		$sql = $sql.$tabKey.') ENGINE = InnoDB CHARSET=utf8';

		try {
		   	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		} catch (PDOException $e) {
		   	echo 'Подключение не удалось: ' . $e->getMessage();
		}
		$pdo->exec($sql);
		header('location: index.php');
	}
?>
