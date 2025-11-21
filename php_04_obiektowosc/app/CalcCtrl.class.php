<?php
require_once dirname(__FILE__).'/CalcForm.class.php';
require_once dirname(__FILE__).'/CalcResult.class.php';
require_once dirname(__FILE__).'/../lib/Messages.class.php';

class CalcCtrl {
    private $msgs;
    private $form;
    private $result;

    public function __construct() {
        $this->msgs = new Messages();
        $this->form = new CalcForm();
        $this->result = new CalcResult();
    }

    public function getParams() {
        $this->form->amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
        $this->form->years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
        $this->form->rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : null;
    }

    public function validate() {
        // If parameters are not present, it means the form was not submitted.
        // In that case, do not add an error to messages — just stop validation.
        if (!(isset($this->form->amount) && isset($this->form->years) && isset($this->form->rate))) {
            return false;
        }

        if ($this->form->amount === "" || $this->form->amount === null) {
            $this->msgs->addError('Nie podano kwoty kredytu');
        }
        if ($this->form->years === "" || $this->form->years === null) {
            $this->msgs->addError('Nie podano liczby lat');
        }
        if ($this->form->rate === "" || $this->form->rate === null) {
            $this->msgs->addError('Nie podano oprocentowania');
        }

        if (!$this->msgs->isError()) {
            if (!is_numeric($this->form->amount) || floatval($this->form->amount) <= 0) {
                $this->msgs->addError('Kwota kredytu musi być liczbą większą od 0');
            }
            if (!is_numeric($this->form->years) || intval($this->form->years) <= 0) {
                $this->msgs->addError('Liczba lat musi być liczbą całkowitą większą od 0');
            }
            if (!is_numeric($this->form->rate) || floatval($this->form->rate) < 0) {
                $this->msgs->addError('Oprocentowanie musi być liczbą nieujemną');
            }
        }

        return !$this->msgs->isError();
    }

    public function process() {
        $this->getParams();

        if ($this->validate()) {
            $P = floatval($this->form->amount);
            $n_years = intval($this->form->years);
            $annual_rate = floatval($this->form->rate);

            $n = $n_years * 12;
            $r = $annual_rate / 12 / 100;

            if ($r == 0.0) {
                $monthly = $P / $n;
            } else {
                $factor = pow(1 + $r, $n);
                $monthly = $P * $r * $factor / ($factor - 1);
            }

            $this->result->monthly = $monthly;
            $this->msgs->addInfo('Wykonano obliczenia.');
        }

        $this->generateView();
    }

    public function generateView() {
        global $smarty;

        if (!isset($smarty)) {
            if (file_exists(dirname(__FILE__).'/../vendor/autoload.php')) {
                require_once dirname(__FILE__).'/../vendor/autoload.php';
            }
            if (!isset($smarty)) {
                if (session_status() == PHP_SESSION_NONE) session_start();
                echo '<p>Brak silnika szablonów. Proszę zainstalować Smarty.</p>';
                return;
            }
        }

        if (session_status() == PHP_SESSION_NONE) session_start();
        $smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'gość');
        $smarty->assign('form', $this->form);
        $smarty->assign('res', $this->result);
        $smarty->assign('msgs', $this->msgs);

        $smarty->display('calc.tpl');
    }
}
