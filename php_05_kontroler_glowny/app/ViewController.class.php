<?php
require_once $conf->root_path.'/lib/smarty/libs/Smarty.class.php';

class ViewController {
    private $smarty;

    public function __construct() {
        global $conf;
        $this->smarty = new \Smarty\Smarty();
        $this->smarty->assign('conf', $conf);
        $this->smarty->setTemplateDir(array(
            'one' => $conf->root_path . '/app/',
            'two' => $conf->root_path . '/templates/'
        ));
        $this->smarty->setCompileDir($conf->root_path . '/templates_c');
    }

    public function generateView($page_title, $page_header, $page_description, $view_name) {
        global $conf;
        $this->smarty->assign('page_title', $page_title);
        $this->smarty->assign('page_header', $page_header);
        $this->smarty->assign('page_description', $page_description);
        $this->smarty->display($conf->root_path . '/app/' . $view_name);
    }
}
?>