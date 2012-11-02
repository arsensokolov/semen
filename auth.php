<?php

/* Проверку логина и пароля, я вынес в отдельную функцию
 * это будет очень полезно, если в будущем мы решим хранить
 * данные пользователей например в базе данных.
 * Тогда придется изменить только эту функцию и ничего больше.
 */

function check_login($login, $pass) {
    return ($_POST['login'] == 'admin') && ($_POST['pass'] == 'qwerty');
}

// >>> точка входа <<<
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: auth.php");
    exit(); // после передачи редиректа всегда нужен exit или die
    // иначе выполнение скрипта продолжится.
}

// на случай если мы уже авторизированы
if (!isset($_SESSION['login'])) {

    $login = $_POST['login'];
    $pass = $_POST['pass'];

    if (count($_POST) <= 0)
        draw_form();
    else {
        if (check_login($login, $pass)) {
            $_SESSION['login'] = $login;
		    header("Location: index.php");
		}
        else
            draw_form(true);
            // параметр true передается чтобы показать, что был введен
            // неправильный пароль
    }
}

isset($_SESSION['login']) or die(); // здесь если функция вернула false то выполняется die()

header("Location: index.php");

//der("Location: index.php");
// вот и все. теперь чтобы понять авторизирован ли пользователь
// достаточно проверить, содержится ли в переменной $_SESSION['login']
// его ник. А точнее объявлена она или нет. Это можно сделать при помощи isset()*/


function draw_form($bad_login = false) {
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>Авторизация</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #f5f5f5;
			}
			
			.form-sigin {
				max-width: 300px;
				padding: 19px 29px 29px;
				margin: 0 auto 20px;
				background-color: #fff;
				border: 1px solid #e5e5e5;
				-webkit-border-radius: 5px;
				   -moz-border-radius: 5px;
				        border-radius: 5px;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				   -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				        box-shadow: 0 1px 2px rgba(0,0,0,.05);
			}
			
			.form-sigin .form-sigin-heading,
			.form-sigin .checkbox {
				margin-bottom: 10px;
			}
			
			.form-sigin input[type="text"],
			.form-sigin input[type="password"] {
				font-size: 16px;
				height: auto;
				margin-bottom: 15px;
				padding: 7px 9px;
			}
		</style>
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<!-- HTML5 схема, для поддержки в IE6-8 элементов HTML -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="container">
			<form class="form-sigin" autocomplete="off" method="post" >
				<h2 class="form-sigin-heading">Авторизация</h2>
				<?php
						if ($bad_login) echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button> Неверный логин и/или пароль</div>';
				?>
				<input type="text" name="login" class="input-block-level" placeholder="Введите логин">
				<input type="password" name="pass" class="input-block-level" placeholder="Введите пароль">
				<!--
<label class="checkbox">
					<input type="checkbox" name="remember" value="remember-me"> Запомнить меня
				</label>
-->
				<button type="submit" class="btn btn-large btn-primary" name="submit">Войти</button>
			</form>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-alert.js"></script>
	</body>
</html>
<?php
}
?>