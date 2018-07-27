<?php

/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */

	$ime = isset($_POST['ime'])?$_POST['ime']:"";
	$prezime = isset($_POST['prezime'])?$_POST['prezime']:"";
	$username = isset($_POST['username'])?$_POST['username']:"";
	$password = isset($_POST['password'])?$_POST['password']:"";
	$adresa = isset($_POST['adresa'])?$_POST['adresa']:"";
	$mail = isset($_POST['mail'])?$_POST['mail']:"";
	$telefon = isset($_POST['telefon'])?$_POST['telefon']:"";
	$msg = isset($msg)?$msg:"";
	$errors = isset($errors)?$errors:array();
?>

<html lang="sr">
	<?php require_once 'head.php';?>
	<body class="">
		<div class="wrapper container bg-faded text-center">
			<form class="form-signin" action="routes.php" method="post">
				<h2 class="form-signin-heading">Registracija</h2><br>
				<input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php echo $ime?>">
				<span><code><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php echo $prezime?>">
				<span><code><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="username" placeholder="Username" value="<?php echo $username?>">
				<span><code><?php if(array_key_exists('username', $errors)) echo $errors['username']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="password" name="password" placeholder="Password" value="<?php echo $password?>">
				<span><code><?php if(array_key_exists('password', $errors)) echo $errors['password']?></code></span>
				<br>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"name="adresa" placeholder="Adresa"><?php echo $adresa?></textarea>
				<span><code><?php if(array_key_exists('adresa', $errors)) echo $errors['adresa']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="mail" placeholder="E-mail" value="<?php echo $mail?>">
				<span><code><?php if(array_key_exists('mail', $errors)) echo $errors['mail']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="telefon" placeholder="Telefon" value="<?php echo $telefon?>">
				<span><code><?php if(array_key_exists('telefon', $errors)) echo $errors['telefon']?></code></span>
				<br>
				<input id="size" class="btn btn-lg btn-primary btn-block" type="submit" name="page" value="registracija">
			</form>
			<span><code>	
			<?php 
				if(isset($msg)){
					echo $msg;			
				}		
				$poruka=isset($_GET["msg"])?$_GET["msg"]:"";
				echo $poruka;		
			?>
		</code></span>
		</div>
	</body>
</html>