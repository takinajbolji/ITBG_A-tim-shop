<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */
	$osoba=isset($osoba)?$osoba:"";
	$msg =isset($msg)?$msg:"";
	$errors =isset($errors)?$errors:array();
?>

<form action="routes.php" method="get">	
	<div class="wrap container bg-faded text-center w-25">
		<h4 class="form-signin-heading">Izmena korisnika</h4><br>
		<input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php if (isset($osoba['ime'])) echo $osoba['ime']?>">
		<span><code><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php if (isset($osoba['prezime'])) echo $osoba['prezime']?>">
		<span><code><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="adresa" placeholder="Adresa" value="<?php if (isset($osoba['adresa'])) echo $osoba['adresa']?>">
		<span><code><?php if(array_key_exists('adresa', $errors)) echo $errors['adresa']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="mail" placeholder="E-mail" value="<?php if (isset($osoba['mail'])) echo $osoba['mail']?>">
		<span><code><?php if(array_key_exists('mail', $errors)) echo $errors['mail']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="telefon" placeholder="Telefon" value="<?php if (isset($osoba['telefon'])) echo $osoba['telefon']?>">
		<span><code><?php if(array_key_exists('telefon', $errors)) echo $errors['telefon']?></code></span>
		<br>
		<input type="hidden" name="idoso" value="<?php if (isset($osoba['idoso'])) echo $osoba['idoso']?>">	
		<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="promeni korisnika">
	</div>
</form>