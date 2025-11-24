<?php
require_once dirname(__FILE__).'/../../config.php';
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

use Smarty\Smarty;

//pobranie parametrów
function getParamsLogin(&$form){
	$form['login'] = isset ($_REQUEST ['login']) ? $_REQUEST ['login'] : null;
	$form['pass'] = isset ($_REQUEST ['pass']) ? $_REQUEST ['pass'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validateLogin(&$form,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['login']) && isset($form['pass']))) {
		//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $form['login'] == "") {
		$messages [] = 'Nie podano loginu';
	}
	if ( $form['pass'] == "") {
		$messages [] = 'Nie podano hasła';
	}

	//nie ma sensu walidować dalej, gdy brak parametrów
	if (count ( $messages ) > 0) return false;

	// sprawdzenie, czy dane logowania są poprawne
	// - takie informacje najczęściej przechowuje się w bazie danych
	//   jednak na potrzeby przykładu sprawdzamy bezpośrednio
	if ($form['login'] == "admin" && $form['pass'] == "admin") {
		session_start();
		$_SESSION['role'] = 'admin';
		return true;
	}
	if ($form['login'] == "user" && $form['pass'] == "user") {
		session_start();
		$_SESSION['role'] = 'user';
		return true;
	}
	
	$messages [] = 'Niepoprawny login lub hasło';
	return false; 
}

//inicjacja potrzebnych zmiennych
$form = array();
$messages = array();

// pobierz parametry i podejmij akcję
getParamsLogin($form);

if (!validateLogin($form,$messages)) {
	$smarty = new Smarty();

	$smarty->assign('app_url',_APP_URL);
	$smarty->assign('root_path',_ROOT_PATH);

	$smarty->assign('page_title','Logowanie');
	$smarty->assign('page_description','Aplikacja do logowania');
	$smarty->assign('page_header','Logowanie do systemu');
	
	// Ustawienie katalogów dla Smarty (tutaj dostosowane do php_03_szablonowanie)
	$smarty->setTemplateDir(array(
	    'one' => _ROOT_PATH.'/app/security', // templates for controllers
	    'two' => _ROOT_PATH.'/templates/' // main templates
	));
	$smarty->setCompileDir(_ROOT_PATH.'/templates_c');
	$smarty->setConfigDir(_ROOT_PATH.'/configs');
	$smarty->setCacheDir(_ROOT_PATH.'/cache');

	$smarty->assign('form',$form);
	$smarty->assign('messages',$messages);
	$smarty->display('login.html');
} else { 
	//ok przekieruj lub "forward" na stronę główną
	
	//redirect - przeglądarka dostanie ten adres do "przejścia" na niego (wysłania kolejnego żądania)
	header("Location: "._APP_URL);
	
	//"forward"
	//include _ROOT_PATH.'/index.php';
}