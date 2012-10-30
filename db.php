<?php
$my = new mysqli("localhost", "root", "dadmin1", "jkh");
$k=$my->query("SET NAMES utf8");
date_default_timezone_set('Asia/Irkutsk');
setlocale(LC_ALL, 'ru_RU');
$old_error_handler = set_error_handler("myErrorHandler");

function myErrorHandler($errno, $errstr, $errfile, $errline) {
	if (!(error_reporting() && $errno)) {
		// Этот код ошибки не включен в error_reporting
		return;
	}
	
	if ($errno == E_NOTICE) return;
	
	echo "<div class=\"container\">";
	echo "<div class=\"alert alert-block alert-error\">";
	echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
	switch ($errno) {
		case E_ERROR:
			echo "<h4>ERROR <small>[$errno] $errstr</small></h4>";
			echo " Фатальная ошибка в строке $errline файла $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>";
			echo "Завершение работы&hellip;<br>";
			exit(1);
			break;

		case E_WARNING:
			echo "<h4>WARNING <small>[$errno] $errstr</small></h4>";
			echo " Предупреждение в строке <strong>$errline</strong> в файле <strong>$errfile</strong>";
			echo ", PHP " . PHP_VERSION . " (". PHP_OS .")";
			break;
			
		case E_NOTICE:
			echo "<h4>NOTICE <small>[$errno] $errstr</small></h4>";
			echo " Замечание в строке <strong>$errline</strong> в файле <strong>$errfile</strong>";
			echo ", PHP " . PHP_VERSION . " (". PHP_OS .")";
			break;
			
		default:
			echo "Неизвестная ошибка: [$errno] $errstr";
			break;
	}
	echo "</div></div>";

	// Не запускаем внутренний обработчик ошибок PHP
	return true;
}
?>