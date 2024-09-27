<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$id=!isset($id) ? $_SESSION['user_id']: $id;
	$message="";
	if((!empty($_POST['password'])||$is_admined)
		and !empty($_POST['new'])
	    and !empty($_POST['confirm'])){
		$password=$_POST['password'];
		$new=$_POST['new'];
		$confirm=$_POST['confirm'];
		$password_message="";
		if((pasword_correct_check($password,$link,$id,$message)&&password_check($new, $confirm, $password_message))||$is_admined){
			$new=password_hash($new, PASSWORD_DEFAULT);
			$query = "UPDATE users SET password='$new' WHERE id='$id'";
			$link->query($query);
			header('Location: /'.ROOT_PATH.'/personalArea'.($is_admined ? '/'.$id: ''));
		}
    }
	else{
		$message= "Введены не все данные";
	}
?>

<form class="form" action="" id="reg_form" method="POST">
<h1>Смена пароля</h1>
<?php message($message);?>
<?php
	if(!$is_admined){
?>
<label for="password">Пароль</label>
<div>
<input class="input" name="password" id="password" type="password" value="<?php input("password"); ?>" required>
<a href="#" data-for="#password" class="password-control"></a>
</div>
<?php
	}
?>
<?php message($password_message);?>
<label for="new">Новый пароль</label>
<div>
<input class="input" name="new" id="new" type="password" value="<?php input("new"); ?>" required>
<a href="#" data-for="#new" class="password-control"></a>
</div>
<label for="confirm">Повторение нового пароля</label>
<div>
<input class="input" name="confirm" id="confirm" type="password" value="<?php input("confirm"); ?>" required>
<a href="#" data-for="#confirm" class="password-control"></a>
</div>
<input type="submit" value="Сменить">
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