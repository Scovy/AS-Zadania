<?php require_once dirname(__FILE__).'/../config.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Logowanie</title>
</head>
<body>

<h2>Logowanie</h2>
<form action="<?php print(_APP_URL);?>/security/login.php" method="post">
	<label for="id_user">Użytkownik: </label>
	<input id="id_user" type="text" name="user" /><br />
	<label for="id_pass">Hasło: </label>
	<input id="id_pass" type="password" name="pass" /><br />
	<input type="submit" value="Zaloguj" />
</form>

<?php if (isset($_GET['error'])) { echo '<p style="color:red;">Błędny login lub hasło</p>'; } ?>

</body>
</html>