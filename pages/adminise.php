<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$query = "SELECT * FROM users WHERE id='$id'";
	$result=$link->query($query);
	$user= $result->fetch_assoc();
	if(((int)$user['role_id'])==1)
		$query = "UPDATE users SET role_id=2 WHERE id='$id'";
	else
		$query = "UPDATE users SET role_id=1 WHERE id='$id'";
	$link->query($query);
	header('Location: /'.ROOT_PATH.'/admin');
?>