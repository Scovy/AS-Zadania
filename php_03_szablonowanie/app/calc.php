<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php';

use Smarty\Smarty;

// Ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie, gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// Pobranie parametrów
function getParams(&$amount, &$years, &$rate){
	$amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
	$years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
	$rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;	
}

// Walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$amount, &$years, &$rate, &$messages){
	// Sprawdzenie, czy parametry zostały przekazane
	if (!(isset($amount) && isset($years) && isset($rate))) {
		// Sytuacja wystąpi, gdy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		return false;
	}

	// Sprawdzenie, czy potrzebne wartości zostały przekazane
	if ($amount === "" || $amount === null) {
		$messages[] = 'Nie podano kwoty kredytu';
	}
	if ($years === "" || $years === null) {
		$messages[] = 'Nie podano liczby lat';
	}
	if ($rate === "" || $rate === null) {
		$messages[] = 'Nie podano oprocentowania';
	}

	// Nie ma sensu walidować dalej, gdy brak parametrów
	if (count($messages) != 0) return false;
	
	// Sprawdzenie, czy wartości są numeryczne i dodatnie
	if (!is_numeric($amount) || floatval($amount) <= 0) {
		$messages[] = 'Kwota kredytu musi być liczbą większą od 0';
	}
	if (!is_numeric($years) || intval($years) <= 0) {
		$messages[] = 'Liczba lat musi być liczbą całkowitą większą od 0';
	}
	if (!is_numeric($rate) || floatval($rate) < 0) {
		$messages[] = 'Oprocentowanie musi być liczbą nieujemną';
	}	

	if (count($messages) != 0) return false;
	else return true;
}

// Wykonanie obliczeń
function process(&$amount, &$years, &$rate, &$messages, &$result){
	global $role;
	
	// Konwersja parametrów
	$P = floatval($amount);
	$n_years = intval($years);
	$annual_rate = floatval($rate);

	// Ograniczenie dla roli 'user'
	if ($role == 'user' && $annual_rate < 4) {
		$messages[] = 'Tylko administrator może obliczać kredyty z oprocentowaniem poniżej 4%';
		return;
	}

	$n = $n_years * 12; // liczba rat
	$r = $annual_rate / 12 / 100; // miesięczna stopa

	if ($r == 0.0) {
		// Brak odsetek
		$monthly = $P / $n;
	} else {
		$factor = pow(1 + $r, $n);
		$monthly = $P * $r * $factor / ($factor - 1);
	}

	$result = $monthly;
}

// Definicja zmiennych kontrolera
$amount = null;
$years = null;
$rate = null;
$result = null;
$messages = array();
$form = array();

// Pobierz parametry i wykonaj zadanie, jeśli wszystko w porządku
getParams($amount, $years, $rate);
if (validate($amount, $years, $rate, $messages)) { // Gdy brak błędów
	process($amount, $years, $rate, $messages, $result);
}

$form['amount'] = $amount;
$form['years'] = $years;
$form['rate'] = $rate;

// 4. Przygotowanie danych dla szablonu

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Kalkulator kredytowy');
$smarty->assign('page_description','Szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');
$smarty->assign('role',$role);

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);


$smarty->setTemplateDir(array(
    'one' => _ROOT_PATH.'/app/',
    'two' => _ROOT_PATH.'/templates/'
));
$smarty->setCompileDir(_ROOT_PATH.'/templates_c');
$smarty->setConfigDir(_ROOT_PATH.'/configs');
$smarty->setCacheDir(_ROOT_PATH.'/cache');

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc.html');
