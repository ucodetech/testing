<?php

session_start();
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'codeChat'

	),
	'remember' => array(
		'cookie_name' => 'codeChatAppMessenger',
		'cookie_expiry' => '604800'
	),
	'session' => array(
		'session_nameAd' => 'developerStack',
		'session_nameChat' => 'chatMessenderUser',
		'token_name' => 'token'
	)
);

//APP ROOT
define('APPROOT', dirname(dirname(__FILE__)));

//URL ROOT

define('URLROOT', 'http://localhost/messengerApp/');

//php mailer
require_once (APPROOT ."/PHPMailer/PHPMailer.php");
require_once (APPROOT ."/PHPMailer/Exception.php");
require_once (APPROOT ."/PHPMailer/SMTP.php");

//SITE NAME
define('SITENAME', 'Code Chat');
define('APPVERSION', '1.0.0');
define('ADMIN', 'CONTROL ROOM');
define('NAVNAME', 'Code Chat');
define('DASHBOARD', 'Code Messenger');


spl_autoload_register(function ($class) {
	require_once(APPROOT . '/classes/' . $class . '.php');
});


require_once(APPROOT . '/helpers/session_helper.php');
require_once(APPROOT . '/helpers/session.php');
