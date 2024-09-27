<?php
	include './scripts/db.php';
	$query = "SELECT * FROM users WHERE id='$id'";
	$result=$link->query($query);
	$user= $result->fetch_assoc();
	if(empty($user)){
		echo notFound();
	}else{	
		$login=$user['login'];
		$name=$user['name'];
		$lastname=(string)$user['lastname'];
		$fathername=(string)$user['fathername'];
		$birth_date=(string)$user['birth_date'];
		$firstDate = date("Y-m-d");
		$firstDateTimeObject = DateTime::createFromFormat('Y-m-d', $firstDate);
		$secondDateTimeObject = DateTime::createFromFormat('Y-m-d', $birth_date);
		$delta = $secondDateTimeObject->diff($firstDateTimeObject);
		$age=$delta->format('%y');
		$registration_date=$user['registration_date'];
		$country=$user['country'];
		echo "<p>Логин: $login </p>";
		echo "<p>Имя: $name </p>";
		echo "<p>Фамилия: $lastname </p>";
		echo "<p>Отчество: $fathername </p>";
		echo "<p>Дата рождения: $birth_date </p>";
		echo "<p>Возраст: $age года</p>";
		echo "<p>Дата регистрации: $registration_date </p>";
		echo "<p>Страна: $country </p>";
	}
?>