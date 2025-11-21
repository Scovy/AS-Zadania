<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/security/check.php';

require_once dirname(__FILE__).'/CalcCtrl.class.php';

$ctrl = new CalcCtrl();
$ctrl->process();
