<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator kredytowy</title>
</head>
<body>

<h2>Kalkulator kredytowy</h2>
<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_amount">Kwota kredytu (PLN): </label>
	<input id="id_amount" type="text" name="amount" value="<?php if(isset($amount)) print($amount); ?>" /><br />

	<label for="id_years">Lata: </label>
	<input id="id_years" type="text" name="years" value="<?php if(isset($years)) print($years); ?>" /><br />

	<label for="id_rate">Roczne oprocentowanie (%): </label>
	<input id="id_rate" type="text" name="rate" value="<?php if(isset($rate)) print($rate); ?>" /><br />

	<input type="submit" value="Oblicz miesięczną ratę" />
</form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Miesięczna rata: '.number_format($result,2,'.',',').' zł'; ?>
</div>
<?php } ?>

</body>
</html>