<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$query = "SELECT * FROM banlist WHERE user_id='$id'";
	$result=$link->query($query);
	$user= $result->fetch_assoc();
	$date=date('Y-m-d');
	if(empty($user))
		$query = "INSERT INTO banlist SET user_id='$id',date='$date'";
	else
		$query = "DELETE FROM banlist WHERE user_id='$id'";
	$link->query($query);
	header('Location: /'.ROOT_PATH.'/admin');
?>