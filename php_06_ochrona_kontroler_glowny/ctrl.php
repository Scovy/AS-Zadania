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
		include 'check.php';
		$ctrl = new CalcCtrl();
		$ctrl->generateView();
	break;
	case 'calcCompute' :
		include 'check.php';
		$ctrl = new CalcCtrl();
		$ctrl->process();
	break;
	case 'logout' :
		include 'check.php';
		$ctrl = new LoginCtrl();
		$ctrl->doLogout();
	break;
}