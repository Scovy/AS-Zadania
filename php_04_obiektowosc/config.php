<?php
// podstawowa konfiguracja aplikacji
define('_SERVER_NAME', 'localhost:80');
define('_SERVER_URL', 'http://'._SERVER_NAME);
if (!defined('_ROOT_PATH')) {
	define("_ROOT_PATH", dirname(__FILE__));
}

if (!defined('_APP_ROOT') || _APP_ROOT === '') {
	$appRoot = '/' . basename(__DIR__);
	if (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] !== '') {
		$docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
		$rootPath = str_replace('\\', '/', _ROOT_PATH);
		if (strpos($rootPath, $docRoot) === 0) {
			$sub = substr($rootPath, strlen($docRoot));
			if ($sub === '') $sub = '/';
			$appRoot = $sub;
		}
	}
	define('_APP_ROOT', $appRoot);
}

if (!defined('_APP_URL')) {
	define('_APP_URL', _SERVER_URL._APP_ROOT);
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/libs/Smarty.class.php')) {
	require_once __DIR__ . '/libs/Smarty.class.php';
} else {
	if (php_sapi_name() !== 'cli') {
		echo '<h2>Brak zainstalowanej biblioteki Smarty</h2>';
		echo '<p>Zainstaluj Smarty (najprościej przez Composer):</p>';
		echo '<pre>composer require smarty/smarty</pre>';
		echo '<p>Alternatywnie umieść bibliotekę w <code>php_03_szablonowanie/libs/</code>.</p>';
		exit();
	}
}

if (class_exists('Smarty') || class_exists('Smarty\\Smarty')) {
	if (class_exists('Smarty')) {
		$smarty = new Smarty();
	} else {
		$smarty = new \Smarty\Smarty();
	}

	$tplDir = __DIR__ . '/templates/';
	$compileDir = __DIR__ . '/templates_c/';
	$cacheDir = __DIR__ . '/cache/';
	$configDir = __DIR__ . '/configs/';

	foreach (array($tplDir, $compileDir, $cacheDir, $configDir) as $d) {
		if (!is_dir($d)) {
			mkdir($d, 0777, true);
		}
	}

	$smarty->setTemplateDir($tplDir);
	$smarty->setCompileDir($compileDir);
	$smarty->setCacheDir($cacheDir);
	$smarty->setConfigDir($configDir);

	$smarty->setCompileCheck(1);
	$smarty->setForceCompile(true);

	$smarty->assign('app_url', _APP_URL);
}

?>