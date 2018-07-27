<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.06.2018.godine
 * verzija 1.0.
 */
	$artikal=isset($artikal)?$artikal:array();
	$msg =isset($msg)?$msg:"";
	$errors =isset($errors)?$errors:array();
?>

<form action="routes.php" method="get">	
	<div class="wrap container bg-faded text-center w-25">
		<h4 class="form-signin-heading">Izmena artikla</h4><br>
		<input class="form-control" id="ex2" type="text" name="naziv" placeholder="Naziv" value="<?php if (isset($artikal['naziv'])) echo $artikal['naziv']?>">
		<span><code><?php if(array_key_exists('naziv', $errors)) echo $errors['naziv']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="cena" placeholder="Cena" value="<?php if (isset($artikal['cena'])) echo $artikal['cena']?>">
		<span><code><?php if(array_key_exists('cena', $errors)) echo $errors['cena']?></code></span>
		<br>
		<input type="hidden" name="idart" value="<?php if (isset($artikal['idart'])) echo $artikal['idart']?>">	
		<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="promeni artikal">
	</div>
</form>