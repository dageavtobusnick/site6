<?php include './components/form_design.php'; ?>
<?php
	include './scripts/db.php';
	$message="";
	$user=null;
	if(!empty($_POST['password']) and !empty($_POST['login']) 
		and !empty($_POST['email'])
	    and !empty($_POST['confirm'])){
		$password=$_POST['password'];
		$confirm=$_POST['confirm'];
		$login=$_POST['login'];
		$birth_date=$_POST['birth_date'];
		$email=$_POST['email'];
		$country=$_POST['country'];
		$name=$_POST['name'];
		$lastname=$_POST['lastname'];
		$fathername=$_POST['fathername'];
		$phone_number=$_POST['phone_number'];
		$login_message="";
		$password_message="";
		$email_message="";
		$date_message="";
		$phone_message="";
		if(login_check($login, $link, $login_message)&&
			password_check($password, $confirm, $password_message)&&
			email_check($email, $link, $email_message)&&
			phone_check($phone_number,$phone_message)&&
			date_check($birth_date, $date_message)){
			$password=password_hash($password, PASSWORD_DEFAULT);
			$date=date('Y-m-d');
			$query = "INSERT INTO users SET login='$login', password='$password',
					birth_date='$birth_date', email='$email',registration_date='$date',
					name='$name', lastname='$lastname',fathername='$fathername',
					country='$country',phone_number='$phone_number',role_id=1";
			$link->query($query);
			$_SESSION['auth']=true;
			$_SESSION['user']=$login;
			$id=$link->insert_id;
			$_SESSION['user_id']=$id;
			header('Location: /'.ROOT_PATH);
		}
    }
	else{
		$message= "Введены не все данные";
	}
?>

<form class="form" action="" id="reg_form" method="POST">
<?php message($message);?>
<?php message($login_message);?>
<label for="login">Логин</label>
<input class="input"  name="login" id="login" value="<?php input("login"); ?>" required>
<?php message($password_message);?>
<label for="password">Пароль</label>
<div>
<input class="input" name="password" id="password" type="password" value="<?php input("password"); ?>" required>
<a href="#" data-for="#password" class="password-control"></a>
</div>
<label for="confirm">Повторение пароля</label>
<div>
<input class="input" name="confirm" id="confirm" type="password" value="<?php input("confirm"); ?>" required>
<a href="#" data-for="#confirm" class="password-control"></a>
</div>
<?php message($email_message);?>
<label for="email">email</label><br/>
<input class="input" name="email" id="email" type="email" value="<?php input("email"); ?>" required>
<?php message($date_message);?>
<label for="birth_date">Дата рождения</label><br/>
<input class="input" name="birth_date" id="birth_date" type="date" value="<?php input("birth_date"); ?>">
<label for="name">Имя</label>
<input class="input"  name="name" id="name" value="<?php input("name"); ?>" >
<label for="lastname">Фамилия</label>
<input class="input"  name="lastname" id="lastname" value="<?php input("lastname"); ?>">
<label for="fathername">Отчество</label>
<input class="input"  name="fathername" id="fathername" value="<?php input("fathername"); ?>">
<?php message($phone_message);?>
<label for="phone">Телефон</label>
<input class="input"  name="phone_number" id="phone" type="tel" value="<?php input("phone_number"); ?>">
<?php include './components/country_select.php'; ?>
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