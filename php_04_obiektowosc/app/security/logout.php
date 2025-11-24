<?php
require_once dirname(__FILE__).'/../../config.php';

// 1. zakończenie sesji
session_start();
session_destroy();

// 2. przekieruj lub "forward" na stronę główną
header("Location: ".$conf->app_url);