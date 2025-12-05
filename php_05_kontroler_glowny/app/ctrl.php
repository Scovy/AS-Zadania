<?php
require_once dirname (__FILE__).'/../config.php';

session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($action) {
	default : 
		include_once $conf->root_path.'/app/ViewController.class.php';
		$ctrl = new ViewController();
		$ctrl->generateView('Strona główna', 'Witaj w aplikacji', 'Prosta aplikacja z kontrolerem głównym', 'HomeView.html');
	break;
	case 'login':
		include_once $conf->root_path.'/app/security/LoginCtrl.class.php';
		$ctrl = new LoginCtrl();
		$ctrl->doLogin();
	break;
	case 'calcShow' :
		if (empty($role)) {
			header("Location: ".$conf->action_url."login");
		}
		include_once $conf->root_path.'/app/CalcCtrl.class.php';
		$ctrl = new CalcCtrl();
		$ctrl->generateView();
	break;
	case 'calcCompute' :
		if (empty($role)) {
			header("Location: ".$conf->action_url."login");
		}
		include_once $conf->root_path.'/app/CalcCtrl.class.php';
		$ctrl = new CalcCtrl();
		$ctrl->process();
	break;
	case 'logout' :
		session_destroy();
		header("Location: ".$conf->app_url);
	break;
}