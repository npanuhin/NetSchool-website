<?php
require_once "../src/config.php";

if (isset($_SESSION["user_id"])) {
	redirect();
	exit();
}

?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="build/login.min.css">
		<title>NetSchool PTHS | Login</title>
	</head>
	<body>
		<div class="container">
			<div class="title">NetSchool PTHS</div>
			<form id="login_form">
				<input id="username" type="text" placeholder="Логин">
				<br>
				<input id="password" type="password" placeholder="Пароль">
				<br>
				<input type="submit" value="Войти">
			</form>
			<div class="message">
				<p>Загрузка<span>.</span><span>.</span><span>.</span></p>
			</div>
		</div>

		<script type="text/javascript" src="/src/event.js" defer></script>
		<script type="text/javascript" src="/src/ajax.js" defer></script>
		<script type="text/javascript" src="build/login.min.js" defer></script>
	</body>
</html>