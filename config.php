<?php
	/**/

	//caso esteja executando o aplicativo em localhost, altere essas configurações com as informações corretas
	if($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1') {
		define('PATH', 'http://127.0.0.1/devphp/uplexis/');
		define('DB_HOST', '127.0.0.1');
		define('DB_BASE', 'softz');
		define('DB_USER', 'paolo');
		define('DB_PASS', 'paolo123');
	}
	//caso esteja executando o aplicativo em um servidor, altere essas configurações com as informações corretas
	else {
		define('PATH', 'http://devphpsolucoes.com.br/uplexis/');
		define('DB_HOST', 'localhost');
		define('DB_BASE', 'devph704_empresa');
		define('DB_USER', 'devph704_bphp');
		define('DB_PASS', 'AnA@!11235');
	}
	
	define('CWD', getcwd());
	define('SISTEMA', 'sistema/');
	define('CONTROLLERS', 'controllers/');
	define('MODELS', 'models/');
	define('VIEWS', 'views/');
	define('MAIL', 'mailer/');
	define('LIB', PATH . 'web/lib/');
	define('JS', PATH . 'web/js/');
	define('CSS', PATH . 'web/css/');
	define('IMG', PATH . 'web/img/');
	define('XML', 'web/xml');
	define('TXT', 'web/txt/');
	define('HELPERS',				getcwd() . '/sistema/helpers/');

	define('CONTROLLER_DEFAULT', 'home');
	define('ACTION_DEFAULT', 'index');

	session_name('bphp_session');
	session_start();
