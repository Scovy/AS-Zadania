<?php
require_once dirname(__FILE__).'/config.php';

// Ochrona całej aplikacji - poniższy skrypt sprawdza, czy użytkownik jest zalogowany
// jeśli nie, to nadzoruje proces logowania
include _ROOT_PATH.'/app/security/check.php';

// Jeśli doszliśmy tutaj, to użytkownik jest zalogowany
include _ROOT_PATH.'/app/calc.php';