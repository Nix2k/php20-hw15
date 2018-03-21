<?php
	require_once './db.php';

	function clearInput($input) 
	{
		return htmlspecialchars(strip_tags($input));
	}

?>