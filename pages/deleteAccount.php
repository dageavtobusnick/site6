<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$id=!isset($id) ? $_SESSION['user_id']: $id;
	$message="";
	if((!empty($_POST['password'])||$is_admined)){
		$password=$_POST['password'];
		$password_message="";
		if(pasword_correct_check($password,$link,$id,$message)||$is_admined){
			$query = "DELETE FROM users WHERE id='$id'";
			$link->query($query);
			header('Location: /'.ROOT_PATH.'/'.($is_admined ? 'admin': 'logout'));
		}
    }
	else{
		$message= "Введены не все данные";
	}
?>

<form class="form" action="" id="reg_form" method="POST">
<h1>Удаление аккаунта</h1>
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
<input type="submit" value="Удалить">
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