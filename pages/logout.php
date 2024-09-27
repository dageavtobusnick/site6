<?php
	unset($_SESSION['auth']);
	unset($_SESSION['user']);
	$_SESSION['flash'] = "Вы успешно вышли";
    header('Location: /'.ROOT_PATH);
?>