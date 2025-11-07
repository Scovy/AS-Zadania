<?php
require_once dirname(__FILE__).'/../config.php';
session_start();

// usun dane sesji
session_unset();
session_destroy();

// przekieruj do strony logowania
header('Location: ' . _APP_URL . '/security/login_view.php');
exit();
?>