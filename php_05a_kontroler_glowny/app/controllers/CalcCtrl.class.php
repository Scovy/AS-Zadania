<?php
require_once 'CalcForm.class.php';
require_once 'CalcResult.class.php';

class CalcCtrl {

	private $form;
	private $result;

	public function __construct(){
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	public function getParams(){
		$this->form->amount = getFromRequest('amount');
		$this->form->years = getFromRequest('years');
		$this->form->rate = getFromRequest('rate');
	}
	
	public function validate() {
		if (!(isset($this->form->amount) && isset($this->form->years) && isset($this->form->rate))) {
			return false;
		}
		
		if ($this->form->amount == "") { getMessages()->addError('Nie podano kwoty kredytu'); }
		if ($this->form->years == "") { getMessages()->addError('Nie podano liczby lat'); }
		if ($this->form->rate == "") { getMessages()->addError('Nie podano oprocentowania'); }

		if (!getMessages()->isError()) {
			if (!is_numeric($this->form->amount) || floatval($this->form->amount) <= 0) { getMessages()->addError('Kwota kredytu musi być liczbą większą od 0'); }
			if (!is_numeric($this->form->years) || intval($this->form->years) <= 0) { getMessages()->addError('Liczba lat musi być liczbą całkowitą większą od 0'); }
			if (!is_numeric($this->form->rate) || floatval($this->form->rate) < 0) { getMessages()->addError('Oprocentowanie musi być liczbą nieujemną'); }
		}
		
		return !getMessages()->isError();
	}
	
	public function process(){
		$this->getparams();
		
		if ($this->validate()) {
			$this->form->amount = floatval($this->form->amount);
			$this->form->years = intval($this->form->years);
			$this->form->rate = floatval($this->form->rate);
			getMessages()->addInfo('Parametry poprawne.');

			global $role;
			if ($role == 'user' && $this->form->rate < 4) {
				getMessages()->addError('Tylko administrator może obliczać kredyty z oprocentowaniem poniżej 4%');
			}
			
			if (!getMessages()->isError()) {
				$P = $this->form->amount;
				$n_years = $this->form->years;
				$annual_rate = $this->form->rate;

				$n = $n_years * 12;
				$r = $annual_rate / 12 / 100;

				if ($r == 0.0) {
					$monthly = $P / $n;
				} else {
					$factor = pow(1 + $r, $n);
					$monthly = $P * $r * $factor / ($factor - 1);
				}
				$this->result->result = $monthly;
				getMessages()->addInfo('Wykonano obliczenia.');
			}
		}
		
		$this->generateView();
	}
	
	public function generateView(){
		global $role;
		
		getSmarty()->assign('page_title','Kalkulator kredytowy');
		getSmarty()->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
		getSmarty()->assign('page_header','Obiekty w PHP');
		getSmarty()->assign('role',$role);
				
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.html');
	}
}