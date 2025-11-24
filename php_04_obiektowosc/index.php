<?php
require_once dirname(__FILE__).'/config.php';

// Ochrona całej aplikacji - poniższy skrypt sprawdza, czy użytkownik jest zalogowany
// jeśli nie, to nadzoruje proces logowania
include $conf->root_path.'/app/security/check.php';

// Jeśli doszliśmy tutaj, to użytkownik jest zalogowany
include $conf->root_path.'/app/calc.php';