{extends file='layout.tpl'}

{block name='title'}Logowanie{/block}

{block name='content'}
<h2>Logowanie</h2>
<form class="loginform" action="{$app_url}/security/login.php" method="post">
    <label for="id_user">Użytkownik: </label>
    <input id="id_user" type="text" name="user" /><br />
    <label for="id_pass">Hasło: </label>
    <input id="id_pass" type="password" name="pass" /><br />
    <input type="submit" value="Zaloguj" />
</form>

{if $error}
<p class="messages">Błędny login lub hasło</p>
{/if}

{/block}
