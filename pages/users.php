<?php
	include './scripts/db.php';
	$query = "SELECT * FROM users ";
	$result=$link->query($query);
	foreach($result as $row){
		if(is_null($row)||$row==''){
				continue;
		}
		echo '<div><a href="/'.ROOT_PATH.'/profile/'.$row['id'].'">'.$row['login'].'</a></div>';
	}
?>