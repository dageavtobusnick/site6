<?php include './components/form_design.php'; ?>
<?php 
	include './scripts/db.php';
	$id=!isset($id) ? $_SESSION['user_id']: $id;
	$query = "SELECT * FROM users WHERE id='$id'";
	$result=$link->query($query);
	$user= $result->fetch_assoc();
	$login_message="";
	$email_message="";
	$date_message="";
	$phone_message="";
	if(empty($user)){
		echo notFound();
	}else{
		if( !empty($_POST['login']) 
		and !empty($_POST['email'])){;
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
			if(login_check($login, $link, $login_message,false)&&
				email_check($email, $link, $email_message,false)&&
				phone_check($phone_number,$phone_message)&&
				date_check($birth_date, $date_message)){
				$query = "UPDATE users SET login='$login',
						birth_date='$birth_date', email='$email',phone_number='$phone_number',
						name='$name', lastname='$lastname',fathername='$fathername',
						country='$country' WHERE id='$id'";
				$link->query($query);
			}
		} 
 ?>
 <form class="form" action="" id="reg_form" method="POST">
<?php message($login_message);?>
<label for="login">Логин</label>
<input class="input"  name="login" id="login" value="<?php input("login",$user); ?>" required>
<?php message($email_message);?>
<label for="email">email</label><br/>
<input class="input" name="email" id="email" type="email" value="<?php input("email",$user); ?>" required>
<?php message($date_message);?>
<label for="birth_date">Дата рождения</label><br/>
<input class="input" name="birth_date" id="birth_date" type="date" value="<?php input("birth_date",$user); ?>">
<label for="name">Имя</label>
<input class="input"  name="name" id="name" value="<?php input("name",$user); ?>" required>
<label for="lastname">Фамилия</label>
<input class="input"  name="lastname" id="lastname" value="<?php input("lastname",$user); ?>">
<label for="fathername">Отчество</label>
<input class="input"  name="fathername" id="fathername" value="<?php input("fathername",$user); ?>">
<?php message($phone_message);?>
<label for="phone">Телефон</label>
<input class="input"  name="phone_number" id="phone" type="tel" value="<?php input("phone_number",$user); ?>">
<?php include './components/country_select.php'; ?>
<input type="submit" value="Изменить">
<?php
	if($is_admined){
	
	}else{
		echo '<a href="/'.ROOT_PATH.'/changePassword">Смена пароля</a>';
		echo '<a href="/'.ROOT_PATH.'/deleteAccount">    Удаление</a>';
	}
?>
</form>
<?php 	
	}
 ?>