<?php
require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';

class LoginCtrl {
    private $msgs;
    private $form;
    private $smarty;

    public function __construct() {
        global $conf;
        $this->msgs = new Messages();
        $this->form = [];
        $this->smarty = new \Smarty\Smarty();
        $this->smarty->assign('conf', $conf);
        $this->smarty->setTemplateDir(array(
            'one' => $conf->root_path . '/app/security',
            'two' => $conf->root_path . '/templates/'
        ));
        $this->smarty->setCompileDir($conf->root_path . '/templates_c');
    }

    private function getParams() {
        $this->form['login'] = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
        $this->form['pass'] = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : null;
    }

    private function validate() {
        if (!(isset($this->form['login']) && isset($this->form['pass']))) {
            return false;
        }

        if ($this->form['login'] == "") {
            $this->msgs->addError('Nie podano loginu');
        }
        if ($this->form['pass'] == "") {
            $this->msgs->addError('Nie podano hasła');
        }

        if ($this->msgs->isError()) return false;

        if ($this->form['login'] == "admin" && $this->form['pass'] == "admin") {
            $_SESSION['role'] = 'admin';
            return true;
        }
        if ($this->form['login'] == "user" && $this->form['pass'] == "user") {
            $_SESSION['role'] = 'user';
            return true;
        }

        $this->msgs->addError('Niepoprawny login lub hasło');
        return false;
    }

    public function doLogin() {
        global $conf;
        $this->getParams();

        if ($this->validate()) {
            header("Location: " . $conf->app_url);
        } else {
            $this->generateView();
        }
    }

    public function generateView() {
        global $conf;
        $this->smarty->assign('page_title', 'Logowanie');
        $this->smarty->assign('page_header', 'Logowanie do systemu');
        $this->smarty->assign('page_description', 'Aplikacja do logowania');

        $this->smarty->assign('form', $this->form);
        $this->smarty->assign('messages', $this->msgs->getErrors());
        $this->smarty->display($conf->root_path . '/app/security/login.html');
    }
}
