<?php
require './scripts/config.php';
require './scripts/auth_features.php';
include './scripts/db.php';
$routes = [
    '/' => 'hello',
    '/login' => 'login',
	'/logout' => 'logout',
	'/register' => 'register',  	
	'/:num' => 'pages',
	'/profile/:num' => 'profile',
	'/personalArea' => 'personal_area',
	'/personalArea/:num' => 'personal_area_indexed',
	'/changePassword/:num' => 'change_password_indexed',
	'/deleteAccount/:num' => 'delete_account_indexed',
	'/changePassword' => 'change_password',
	'/deleteAccount' => 'delete_account',
	'/admin' => 'admin',
	'/adminise/:num' => 'adminise',
	'/ban/:num' => 'ban',
	'/users' => 'users'
];

session_start();
include './components/header.php';
function getRequestPath() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$path = str_replace(':num', '[0-9]+', $path);
    return '/' . ltrim(str_replace(ROOT_PATH, '', $path), '/');
}

function getMethod(array $routes, $path) {
    foreach ($routes as $route => $method) {
		$route=str_replace(':num', '([0-9]+)', $route);
        if (preg_match('#^'.$route.'$#',$path)) {
            return $method;
        }
    }
    return 'notFound';
}

function login($path) {
    include './pages/login.php';
}

function logout($path) {
	if(!auth_check()){
		return unauthorized();
	}
    include './pages/logout.php';
}

function profile($path) {
	if(!auth_check()){
		return unauthorized();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
    include './pages/profile.php';
}

function personal_area_indexed($path) {
	if(!admin_check()){
		return forbidden();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
	$is_admined=true;
    include './pages/personalArea.php';
}

function delete_account_indexed($path) {
	if(!admin_check()){
		return forbidden();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
	$is_admined=true;
    include './pages/deleteAccount.php';
}

function adminise($path) {
	if(!admin_check()){
		return forbidden();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
	$is_admined=true;
    include './pages/adminise.php';
}

function ban($path) {
	if(!admin_check()){
		return forbidden();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
	$is_admined=true;
    include './pages/ban.php';
}

function change_password_indexed($path) {
	if(!admin_check()){
		return forbidden();
	}
	preg_match_all("/\d+/", $path, $matches);
	$id=$matches[0][0];
	$is_admined=true;
    include './pages/changePassword.php';
}

function admin($path){
	if(!admin_check()){
		return forbidden();
	}
	include './pages/admin.php';
}

function personal_area($path) {
	if(!auth_check()){
		return unauthorized();
	}
	$is_admined=false;
    include './pages/personalArea.php';
}

function delete_account($path) {
	if(!auth_check()){
		return unauthorized();
	}
	$is_admined=false;
    include './pages/deleteAccount.php';
}

function change_password($path) {
	if(!auth_check()){
		return unauthorized();
	}
	$is_admined=false;
    include './pages/changePassword.php';
}


function register($path) {
    include './pages/register.php';
}

function users($path){
	include "./pages/users.php";
}

function pages($path) {
	if(!auth_check()){
		return unauthorized();
	}
    include './pages/'.$path.'.php';
}

function hello($path) {
    include './pages/start_page.php';
}

function notFound() {
    header("HTTP/1.0 404 Not Found");
    return 'Нет такой страницы';
}

function unauthorized() {
    header("HTTP/1.0 401 Unauthorized");
    return 'Необходимо авторизоваться';
}

function forbidden() {
    header("HTTP/1.0 403 Unauthorized");
    return 'Необходимо авторизоваться, как администратор';
}

$path = getRequestPath();
$method = getMethod($routes, $path);
echo $method($path);
?>