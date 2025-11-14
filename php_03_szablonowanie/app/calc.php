<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

require_once _ROOT_PATH.'/security/check.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów (kalkulator kredytowy)

$amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
$years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
$rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if (!(isset($amount) && isset($years) && isset($rate))) {
	$messages[] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ($amount === "" || $amount === null) {
	$messages[] = 'Nie podano kwoty kredytu';
}
if ($years === "" || $years === null) {
	$messages[] = 'Nie podano liczby lat';
}
if ($rate === "" || $rate === null) {
	$messages[] = 'Nie podano oprocentowania';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty($messages)) {
	// sprawdzenie, czy wartości są numeryczne
	if (!is_numeric($amount) || floatval($amount) <= 0) {
		$messages[] = 'Kwota kredytu musi być liczbą większą od 0';
	}
	if (!is_numeric($years) || intval($years) <= 0) {
		$messages[] = 'Liczba lat musi być liczbą całkowitą większą od 0';
	}
	if (!is_numeric($rate) || floatval($rate) < 0) {
		$messages[] = 'Oprocentowanie musi być liczbą nieujemną';
	}
}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty($messages)) { // gdy brak błędów
	// konwersja parametrów
	$P = floatval($amount);
	$n_years = intval($years);
	$annual_rate = floatval($rate);

	$n = $n_years * 12; // liczba rat
	$r = $annual_rate / 12 / 100; // miesięczna stopa

	if ($r == 0.0) {
		// brak odsetek
		$monthly = $P / $n;
	} else {
		$factor = pow(1 + $r, $n);
		$monthly = $P * $r * $factor / ($factor - 1);
	}

	$result = $monthly;
}

include 'calc_view.php';
