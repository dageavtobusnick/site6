<?php	
	include './components/flash.php';
	include './scripts/db.php';
	if (auth_check()) {
		$id=$_SESSION['user_id'];
		$query = "SELECT * FROM users WHERE id='$id'";
		$result=$link->query($query);
		$user= $result->fetch_assoc();
		echo '<h3> Hello, '.$user['login'].'</h3>';
	}else
	{
		echo '<h3> Hello, world</h3>';
	}
?>
<p>картинка для любого пользователя</p>
<img src="https://img.freepik.com/free-photo/adorable-looking-kitten-with-yarn_23-2150886292.jpg"/>
<?php
if (auth_check()){
?>
<p>картинка для авторизованного пользователя</p>
<img src="https://img.freepik.com/free-photo/view-adorable-kitten-with-simple-background_23-2150758090.jpg"/>
<?php
}
?>