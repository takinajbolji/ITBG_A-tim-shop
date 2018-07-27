<?php

/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.06.2018.godine
 * verzija 1.0.
 */



if(!isset($_SESSION['ulogovan'])) {
    session_start();
}

$ulogovan=unserialize($_SESSION['ulogovan']);
$brojac = 0;
$inactive = 200;

if(isset($_SESSION['loginTime'])) {
    $session_life = time() - $_SESSION['loginTime'];
    
    if($session_life > $inactive) {
        session_destroy();
        header("Location: login.php");
    }
}

$_SESSION['loginTime']= time();


if ($ulogovan) {
$osiguranje=isset($osiguranje)?$osiguranje:array();
	$oblast= isset($_GET['oblast'])?$_GET['oblast']:"";
	$razlog= isset($_GET['razlog'])?$_GET['razlog']:"";
	$tip= isset($_GET['tip'])?$_GET['tip']:"";
	$ime= isset($_GET['ime'])?$_GET['ime']:"";
	$imail= isset($_GET['imail'])?$_GET['imail']:"";
	$telefon= isset($_GET['telefon'])?$_GET['telefon']:"";
	$adresa= isset($_GET['adresa'])?$_GET['adresa']:"";
	$mesto= isset($_GET['mesto'])?$_GET['mesto']:"";
	$brojpolise= isset($_GET['brojpolise'])?$_GET['brojpolise']:"";
	$opis= isset($_GET['opis'])?$_GET['opis']:"";
	
	$msg =isset($msg)?$msg:"";
	$errors =isset($errors)?$errors:array();

?>
<!DOCTYPE html>
<html lang="en">
	<?php 
	include '../delovi/header.php';
	?>
<body>
<br><a align="center"><h2>Oblast</h2></a>
			
<form align="center" action="routes.php" method="get" >
		<span>Oblas*:</span> <br><br>
        <select name="oblast">
            <option value="1"><span>Osiguranje zivota</span></option>
            <option value="2"><span>Osiguranje vozila</span></option>
            <option value="3"><span>Osiguranje imovine</span></option>
        </select><br><br>
        <span>Razlog*:</span> <br><br>
        <select name="razlog">
            <option value="1"><span>Trazim informaciju</span></option>
            <option value="2"><span>Ulazem prigovor</span></option>
            <option value="3"><span>Pohvala</span></option>
            <option value="4"><span>Sugestije</span></option>
        </select><br><br>
        <span>Tip*:</span> <br><br>
        <select name="tip">
            <option value="1"><span>Fizicko lice</span></option>
            <option value="2"><span>Pravno lice</span></option>
        </select><br><br><br><br>
     	
     	<input type="text" name="ime" placeholder="Ime i prezime" value="<?php echo $ime ?>"><br>
     	<span><code><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></code></span><br><br>
    	<input type="text" name="imail" placeholder="E-mail" value="<?php echo $imail ?>"><br>
    	<span><code><?php if(array_key_exists('imail', $errors)) echo $errors['imail']?></code></span><br><br>
    	<input type="text" name="telefon" placeholder="Telefon" value="<?php echo $telefon ?>"><br>
    	<span><code><?php if(array_key_exists('telefon', $errors)) echo $errors['telefon']?></code></span><br><br>
    	<input type="text" name="adresa" placeholder="Adresa (ulica i broj)" value="<?php echo $adresa ?>"><br>
    	<span><code><?php if(array_key_exists('adresa', $errors)) echo $errors['adresa']?></code></span><br><br>
    	<input type="text" name="mesto" placeholder="Mesto" value="<?php echo $mesto ?>"><br>
    	<span><code><?php if(array_key_exists('mesto', $errors)) echo $errors['mesto']?></code></span><br><br>
    	<input type="text" name="brojpolise" placeholder="Broj polise" value="<?php  echo $brojpolise?>"><br>
    	<span><code><?php if(array_key_exists('brojpolise', $errors)) echo $errors['brojpolise']?></code></span><br><br>
    	<textarea rows="5" cols="50" name="opis" value="<?php  echo $opis?>" placeholder="Opis"></textarea><br><br>
        
        <input type="submit" value="insert" name="page">
        
      </form>
			<?php 

			if(isset($msg)){
				echo $msg;
			}

			$poruka=isset($_GET['msg'])?$_GET['msg']:"";
			echo $poruka;
			
			
include '../delovi/footer.php';

}

?>


	
