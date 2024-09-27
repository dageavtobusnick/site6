<?php
	include './scripts/db.php';
	$query = "SELECT users.id,roles.name as role,users.login FROM users
				LEFT JOIN roles ON users.role_id=roles.id
				WHERE users.id='".$_SESSION['user_id']."'";
	$result=$link->query($query);
	$user= $result->fetch_assoc();
?>

<header>
<?php
	if(auth_check()){
?>
<div>
<p>Пользователь: <?php echo $user['login'];?></p>
<p>Роль: <?php echo $user['role'];?></p>
<a href="/<?php echo ROOT_PATH;?>/personalArea">Личный кабинет</a>
<a href="/<?php echo ROOT_PATH;?>/logout">Выйти</a>
<div>
<?php
}else{
?>
<div>
<a href="/<?php echo ROOT_PATH;?>/login">Войти</a>
<a href="/<?php echo ROOT_PATH;?>/register">Зарегистрироваться</a>
</div>
<?php
}
?>
<?php
	if(admin_check()){
?>
<br/>
<div>
<a href="/<?php echo ROOT_PATH;?>/admin">админ-панель</a>
</div>
<br/>
<?php
}
?>
<div class="pages">
<a href="/<?php echo ROOT_PATH;?>">Главная страница</a>
<?php
	if(auth_check()){
?>
<a href="/<?php echo ROOT_PATH;?>/1">страница 1</a>
<a href="/<?php echo ROOT_PATH;?>/2">страница 2</a>
<a href="/<?php echo ROOT_PATH;?>/3">страница 3</a>
<?php
}
?>
</div>
<style>
header{
	float:left;
}

.pages a{
	display:block;
}
</style>
</header>
</br>