<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$message="";
	if(auth_check()){
		header('Location: /'.ROOT_PATH);
	}
	if(!empty($_POST['password']) and !empty($_POST['login'])){
		$login=$_POST['login'];
		$password=$_POST['password'];
		$query = "SELECT * FROM users WHERE login='$login'";
		$result=$link->query($query);
		$user= $result->fetch_assoc();
		if(!empty($user)){	
			$query = "SELECT * FROM banlist WHERE user_id=".$user['id'];
			$user_result=$link->query($query);
			$ban= $user_result->fetch_assoc();
			if(empty($ban)){
				if(password_verify($password, $user['password'])){
					session_start();
					$_SESSION['auth'] = true;
					$_SESSION['user'] = $user['login'];
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['flash'] = "Авторизация успешна";
					header('Location: /'.ROOT_PATH);
					die();
				}else{
					$message = "Неверные логин или пароль";
				}
			}else{
				$message = "Пользователь забанен";
			}
		}else{
			$message = "Неверные логин или пароль";
		}
	}else{
		$message = "Введите логин и пароль";
	}
?>


<form action="" class="form" method="POST">
<?php message($message);?>
<label for="login">Логин</label><br/>
<input name="login" class="input" id="login" value="<?php input("login"); ?>" required><br/>
<label for="password">Пароль</label><br/>
<div>
<p></p>
<input name="password" class="input" id="password" value="<?php input("password"); ?>" type="password" required>
<a href="#" data-for="#password" class="password-control"></a>
</div>
<input type="submit" value="Отправить">
</form>
<script>
$('.password-control').on('click', function(){
	console.log("a");
	if ($($(this).attr('data-for')).attr('type') == 'password'){
		$(this).addClass('view');
			console.log("a");
		$($(this).attr('data-for')).attr('type', 'text');
	} else {
		$(this).removeClass('view');
			console.log("a");
		$($(this).attr('data-for')).attr('type', 'password');
	}
	return false;
});
</script>