<?php
	$msg =isset($msg)?$msg:"";
	$errors =isset($errors)?$errors:array();
?>

<form action="routes.php" method="get">	
	<div class="wrap container bg-faded text-center w-25">
		<h4 class="form-signin-heading">Unos novog artikla</h4><br>
		<input class="form-control" id="ex2" type="text" name="naziv" placeholder="Naziv" value="<?php echo $naziv;?>">
		<span><code><?php if(array_key_exists('naziv', $errors)) echo $errors['naziv']?></code></span>
		<br>
		<input class="form-control" id="ex2" type="text" name="cena" placeholder="Cena" value="<?php echo $cena;?>">
		<span><code><?php if(array_key_exists('cena', $errors)) echo $errors['cena']?></code></span>
		<br>	
		<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="snimi artikal">
	</div>
</form>