<?php
namespace app\controllers;

class ViewController {
    public function generateView($page_title, $page_header, $page_description, $view_name) {
        getSmarty()->assign('page_title', $page_title);
        getSmarty()->assign('page_header', $page_header);
        getSmarty()->assign('page_description', $page_description);
        getSmarty()->display($view_name);
    }
}
?>