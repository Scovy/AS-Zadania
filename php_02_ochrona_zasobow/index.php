<?php
require_once dirname(__FILE__).'/config.php';

// require login check
require_once _ROOT_PATH.'/security/check.php';

// forward to calculator view
include _ROOT_PATH.'/app/calc_view.php';
?>