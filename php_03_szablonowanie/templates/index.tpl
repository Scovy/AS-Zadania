{extends file='layout.tpl'}

{block name='title'}Strona główna{/block}

{block name='content'}
<h2>Panel aplikacji</h2>
<p>Witaj, {$user|escape}.</p>
<ul>
	<li><a href="{$app_url}/index.php">Strona główna</a></li>
	<li><a href="{$app_url}/app/calc_view.php">Kalkulator kredytowy</a></li>
	<li><a href="{$app_url}/security/logout.php">Wyloguj</a></li>
	<li><a href="{$app_url}/security/login_view.php">Logowanie</a></li>
</ul>
{/block}
