<?php
require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';

class CalcCtrl {

	private $msgs;
	private $form;
	private $result;

	public function __construct(){
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	public function getParams(){
		$this->form->amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
		$this->form->years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
		$this->form->rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;	
	}
	
	public function validate() {
		if (!(isset($this->form->amount) && isset($this->form->years) && isset($this->form->rate))) {
			return false;
		}
		
		if ($this->form->amount == "") { $this->msgs->addError('Nie podano kwoty kredytu'); }
		if ($this->form->years == "") { $this->msgs->addError('Nie podano liczby lat'); }
		if ($this->form->rate == "") { $this->msgs->addError('Nie podano oprocentowania'); }

		if (! $this->msgs->isError()) {
			if (!is_numeric($this->form->amount) || floatval($this->form->amount) <= 0) { $this->msgs->addError('Kwota kredytu musi być liczbą większą od 0'); }
			if (!is_numeric($this->form->years) || intval($this->form->years) <= 0) { $this->msgs->addError('Liczba lat musi być liczbą całkowitą większą od 0'); }
			if (!is_numeric($this->form->rate) || floatval($this->form->rate) < 0) { $this->msgs->addError('Oprocentowanie musi być liczbą nieujemną'); }
		}
		
		return ! $this->msgs->isError();
	}
	
	public function process(){
		$this->getparams();
		
		if ($this->validate()) {
			$this->form->amount = floatval($this->form->amount);
			$this->form->years = intval($this->form->years);
			$this->form->rate = floatval($this->form->rate);
			$this->msgs->addInfo('Parametry poprawne.');

			global $role;
			if ($role == 'user' && $this->form->rate < 4) {
				$this->msgs->addError('Tylko administrator może obliczać kredyty z oprocentowaniem poniżej 4%');
			}
			
			// Jeśli nie ma błędów, wykonaj obliczenia
			if (!$this->msgs->isError()) {
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
				$this->msgs->addInfo('Wykonano obliczenia.');
			}
		}
		
		$this->generateView();
	}
	
	public function generateView(){
		global $conf, $role;
		
		$smarty = new \Smarty\Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Kalkulator kredytowy');
		$smarty->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
		$smarty->assign('page_header','Obiekty w PHP');
		$smarty->assign('role',$role);
				
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->setTemplateDir(array(
			'one' => $conf->root_path.'/app/',
			'two' => $conf->root_path.'/templates/'
		));
		$smarty->setCompileDir($conf->root_path.'/templates_c');

		$smarty->display($conf->root_path.'/app/CalcView.html');
	}
}