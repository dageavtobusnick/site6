<?php
	function auth_check(){
		return isset($_SESSION['auth'])&&$_SESSION['auth'];
	}
	
	function pasword_correct_check($password,$link,$id,&$message){
		$query = "SELECT * FROM users WHERE id='$id'";
		$result=$link->query($query);
		$user= $result->fetch_assoc();
		if(!empty($user)&&password_verify($password, $user['password'])){
			return true;
		}
		$message="Пароль введен неверно";
		return false;
	}
	
	function admin_check(){
		include './scripts/db.php';
		if (auth_check()){
			$query = "SELECT roles.name as role FROM users
						LEFT JOIN roles ON users.role_id=roles.id
						WHERE users.id='".$_SESSION['user_id']."'";
			$result=$link->query($query);
			$user= $result->fetch_assoc();
			return $user['role']=="admin";
		}
		return false;
	}
	
	function input($name,$user=null){
		if(isset($_POST[$name])) 
			echo $_POST[$name];
		elseif(!is_null($user))
			echo $user[$name];
		else echo '';
	}
	function message($text){
		if(strlen($text)>0) 
			echo "<p>$text</p>";
	}

	function phone_check($phone_number,&$phone_message){
		$patt = '/^\s?(\+\s?\d+|\d+)([- ()]*\d){10}$/';
		if (!preg_match($patt, $phone_number)){
			$phone_message="Телефон введен неверно";
			return false;
		}
		return true;
	}
	
	function login_check($login, $link, &$login_message, $match_check=true){
		if (!preg_match("/^[a-zA-Z0-9]+$/", $login)){
			$login_message= "Логин должен содержать только латинские буквы и цифры";
			return false;
		}
		if(strlen($login)<4){
			$login_message= "Логин должен быть не короче 4 символов";
			return false;
		}
		if(strlen($login)>10){
			$login_message= "Логин должен быть не длиннее 10 символов";
			return false;
		}
		$query = "SELECT * FROM users WHERE login='$login'";
		$result=$link->query($query);
		$user= $result->fetch_assoc();
		if(!empty($user)&&$match_check){
			$login_message= "Логин занят";
			return false;
		}
		return true;
	}
	
	function password_check($password, $confirm, &$password_message){
		if($password!=$confirm){
			$password_message="Пароли не совпадают";
			return false;
		}
		if(strlen($password)<8){
			$password_message= "Пароль должен быть не короче 8 символов";
			return false;
		}
		if(strlen($password)>25){
			$password_message= "Пароль должен быть не длиннее 25 символов";
			return false;
		}
		if (!preg_match("/^[a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]]+$/", $password)){
			$password_message= "Пароль должен содержать только латинские буквы, символы и цифры";
			return false;
		}
		return true;
	}
	
	function validateDate($date, $format = 'Y-m-d') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	function email_check($email, $link, &$email_message, $match_check=true){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email_message= "Email указан неверно";
			return false;
		}
		$query = "SELECT * FROM users WHERE email='$email'";
		$result=$link->query($query);
		$user= $result->fetch_assoc();
		if(!empty($user)&&$match_check){
			$email_message= "Email занят";
			return false;
		}
		return true;
	}
	
	function date_check($date, &$date_message){
		if(!validateDate($date, 'Y-m-d')){
			$email_message= "Дата рождения указан неверно";
			return false;
		}
		return true;
	}
?>