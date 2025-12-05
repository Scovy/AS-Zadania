<?php
namespace app\controllers;

class LoginCtrl {
    private $form;

    public function __construct() {
        $this->form = [];
    }

    private function getParams() {
        $this->form['login'] = getFromRequest('login');
        $this->form['pass'] = getFromRequest('pass');
    }

    private function validate() {
        if (!(isset($this->form['login']) && isset($this->form['pass']))) {
            return false;
        }

        if ($this->form['login'] == "") {
            getMessages()->addError('Nie podano loginu');
        }
        if ($this->form['pass'] == "") {
            getMessages()->addError('Nie podano hasła');
        }

        if (getMessages()->isError()) return false;

        if ($this->form['login'] == "admin" && $this->form['pass'] == "admin") {
            $_SESSION['role'] = 'admin';
            return true;
        }
        if ($this->form['login'] == "user" && $this->form['pass'] == "user") {
            $_SESSION['role'] = 'user';
            return true;
        }

        getMessages()->addError('Niepoprawny login lub hasło');
        return false;
    }

    public function doLogin() {
        $this->getParams();

        if ($this->validate()) {
            header("Location: " . getConf()->app_url);
        } else {
            $this->generateView();
        }
    }

    public function generateView() {
        getSmarty()->assign('page_title', 'Logowanie');
        getSmarty()->assign('page_header', 'Logowanie do systemu');
        getSmarty()->assign('page_description', 'Aplikacja do logowania');

        getSmarty()->assign('form', $this->form);
        getSmarty()->display('login.html');
    }
}
