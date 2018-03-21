<?php
	require_once 'routines.php';

	if ((isset($GET['name']))&&(isset($GET['cols']))&&(isset($GET['submit']))){
		$name = clearInput($GET['name']);
		$cols = clearInput($GET['cols']);

		$types = '<option>INT</option><option>VARCHAR</option><option>DATE</option>';

		echo "<h2>Структура таблицы </h2>$name";
		echo '<form action="create_tab.php" method="GET">'
		echo '<input type="hidden" name="cols" value="'.$cols.'"><br>';
		for (i = 0; i<cols; i++) {
			echo '<input type="text" name="fname'.$i.'" placeholder="Название поля"> ';
			echo '<select name="ftype'.$i.'" placeholder="Tип поля">'.$types.'</select> ';
			echo '<input type="text" name="fsize'.$i.'" placeholder="Длина поля"> ';
		}
		echo '<input type="submit" name="submit" value="Создать">';
		echo '</form>';
	}
?>
