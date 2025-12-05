<?php
require_once dirname(__FILE__).'/init.php';

switch ($action) {
	default : 
		include_once getConf()->root_path.'/app/controllers/ViewController.class.php';
		$ctrl = new ViewController();
		$ctrl->generateView('Strona główna', 'Witaj w aplikacji', 'Prosta aplikacja z kontrolerem głównym', 'HomeView.html');
	break;
	case 'login':
		include_once getConf()->root_path.'/app/controllers/LoginCtrl.class.php';
		$ctrl = new LoginCtrl();
		$ctrl->doLogin();
	break;
	case 'calcShow' :
		if (empty($role)) {
			header("Location: ".getConf()->action_url."login");
		}
		include_once getConf()->root_path.'/app/controllers/CalcCtrl.class.php';
		$ctrl = new CalcCtrl();
		$ctrl->generateView();
	break;
	case 'calcCompute' :
		if (empty($role)) {
			header("Location: ".getConf()->action_url."login");
		}
		include_once getConf()->root_path.'/app/controllers/CalcCtrl.class.php';
		$ctrl = new CalcCtrl();
		$ctrl->process();
	break;
	case 'logout' :
		session_destroy();
		header("Location: ".getConf()->app_url);
	break;
}