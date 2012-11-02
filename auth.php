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
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<!-- HTML5 схема, для поддержки в IE6-8 элементов HTML -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	
	<body>
	
	<div class="container">
		<section id="typeahead">
			<div class="page-header">
				<h1>Авторизация <small>АС «Квартиросъемщик»</small></h1>
			</div>
			
			<?php
					if ($bad_login) echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button> Неверный логин и/или пароль</div>';
			?>
		    <form autocomplete="off" action="" method="post" class="form-horizontal">
		    	<div class="control-group">
		    		<label class="control-label" for="inputLogin">Логин</label>
		    		<div class="controls">
		    			<input type="text" name="login" id="inputLogin" placeholder="Введите логин">
		    		</div>
		    	</div>
		    	<div class="control-group">
		    		<label class="control-label" for="inputPassword">Пароль</label>
		    		<div class="controls">
		    			<input type="password" name="pass" id="inputPassword" placeholder="Введите пароль">
		    		</div>
		    	</div>
		    	<div class="control-group">
		    		<div class="controls">
			    		<button type="submit" class="btn" name="submit">Войти</button>
		    		</div>
		    	</div>
		    </form>
			</section>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-alert.js"></script>
	</body>
</html>
<?php
}
?>