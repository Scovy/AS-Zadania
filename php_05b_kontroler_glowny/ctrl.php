<?php
require_once 'init.php';

use app\controllers\CalcCtrl;
use app\controllers\LoginCtrl;
use app\controllers\ViewController;

switch ($action) {
	default : 
		$ctrl = new ViewController();
		$ctrl->generateView('Strona główna', 'Witaj w aplikacji', 'Prosta aplikacja z kontrolerem głównym', 'HomeView.html');
	break;
	case 'login':
		$ctrl = new LoginCtrl();
		$ctrl->doLogin();
	break;
	case 'calcShow' :
		if (empty($role)) {
			header("Location: ".getConf()->action_url."login");
		}
		$ctrl = new CalcCtrl();
		$ctrl->generateView();
	break;
	case 'calcCompute' :
		if (empty($role)) {
			header("Location: ".getConf()->action_url."login");
		}
		$ctrl = new CalcCtrl();
		$ctrl->process();
	break;
	case 'logout' :
		session_destroy();
		header("Location: ".getConf()->app_url);
	break;
}