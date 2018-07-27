<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */

	if(!isset($_SESSION['ulogovan'])) {
		session_start();
	}
	
	$ulogovan=unserialize($_SESSION['ulogovan']);
	$brojac = 0;
	$inactive = 900;
	
	if(isset($_SESSION['loginTime'])) {
		$session_life = time() - $_SESSION['loginTime'];
		
		if($session_life > $inactive) {
			session_destroy();
			header("Location: login.php");
		}
	}
	
	$_SESSION['loginTime']= time();
	
	if(isset($_SESSION['korpa'])) {
		$brojac = count(isset($_SESSION['korpa'])?$_SESSION['korpa']:array());
	}
	
	if ($ulogovan) {
		$artikli=isset($artikli)?$artikli:array();
		$brojFakture=isset($brojFakture)?$brojFakture:array();
		$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
		$korpa=isset($_SESSION['korpa'])?$_SESSION['korpa']:array();
		$idart = isset($idart)?$idart:"";
		$kolicinapoidart = isset($kolicinapoidart)?$kolicinapoidart:array();
		$ime= isset($_GET['ime'])?$_GET['ime']:"";
		$prezime= isset($_GET['prezime'])?$_GET['prezime']:"";
		$adresa= isset($_GET['adresa'])?$_GET['adresa']:"";
		$mail= isset($_GET['mail'])?$_GET['mail']:"";
		$telefon= isset($_GET['telefon'])?$_GET['telefon']:"";
		$msg =isset($msg)?$msg:"";
		$errors =isset($errors)?$errors:array();
		$naziv= isset($_GET['naziv'])?$_GET['naziv']:array();
?>
<html lang="sr">
	<?php require_once 'head.php';?>
	<body class="bg-light">
		<nav class="navbar navbar-expand-lg navbar-dark bg-info">
			<div class="navbar-brand">Dobro dosli, <?php echo $ulogovan['ime'];?></div>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto"></ul>
				<a class="korpa btn btn-outline-light" href="routes.php?page=showkorpa"><img src="../css/images/korpica.png" alt="Korpica"><sup><span class="badge badge-pill badge-danger"> <?php echo $brojac; ?></span></sup></a>
				<a class="btn btn-outline-light" href="routes.php?page=logout">Log out</a>
			</div>
		</nav>
		<div class="container bg-faded text-center">
			<h3 class="display-4">Prikaz kupljenih artikala</h3>
			<table class="table table-striped table-bordered text-center thead-light table-sm">
				<tr>
					<th>id</th>
					<th>Naziv</th>
					<th>Cena</th>
					<th colspan="2">Kolicina</th>
					<th>Iznos</th>
					<th>Obrisi</th>
				</tr>
				<?php 				
					$suma=0;
					foreach ($korpa as $pom) {	
				?>
				<form action="routes.php" method="get">
					<tr>
						<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['idart']?></td>
						<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['naziv']?></td>
						<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['cena']?></td>
						<th class="bg-secondary font-weight-normal align-middle">
							<input class="btn btn-light col-sm-12" type="submit" name="kolicina" disabled="disabled" value="
							<?php 
								if(empty($kolicinapoidart)) {
									echo $kolicina = 1;
								} else {
									foreach ($kolicinapoidart as $p) {
										if($idart==$pom['idart']&& $idoso==$ulogovan['idoso']) {
											echo $kolicina=$p["SUM(kolicina)"];
										} else {
											$dao=new DAO();
											$kol=$dao->selectKolicinaByIdartAndIdoso($pom['idart'], $ulogovan['idoso']);
											foreach ($kol as $v) {
												echo $kolicina=$v["SUM(kolicina)"];
											}
										}
									}
								}
							?>" readonly="readonly">
						</th>
						<th class="size bg-secondary text-white font-weight-normal align-middle">
							<input type="hidden" name="idart" value="<?php echo $pom['idart']?>">
							<input class="btn btn-info" type="submit" name="page" value="+">
						</th>
						<th class="bg-secondary text-white font-weight-normal align-middle">
							<?php 
								if(!empty($uvecanacena)&&$idart==$pom['idart']) {
									echo $ukupno=$uvecanacena;
								} else {
									echo $ukupno=$pom['cena']*$kolicina;
								}
							?>
						</th>
						<th class="bg-secondary text-white font-weight-normal align-middle">
							<a class="" href="routes.php?page=remove&idart=<?php echo $pom['idart']?>"><img src="../css/images/cancel.png" alt="Cancel"></a>
						</th>						
					</tr>				
				</form>
				<?php 
					$suma = $suma + $ukupno;
				?>
				<?php }?>
				<tr>
					<th class="bg-secondary text-white text-right font-weight-normal align-middle" colspan="5">Ukupno: </th>
					<th class="text_ukupno bg-secondary text-white font-weight-bold align-middle" colspan="1"><?php echo $suma;?></th>
					<th class="text_ukupno bg-secondary text-white font-weight-bold align-middle" colspan="1">dinara
				</tr>
			</table>
			<span><code>
				<?php 
					if(isset($msg)){
						echo $msg;
					}
				?>
			</code></span>
			<div class="container bg-faded text-center row">
				<div class="col-lg-4">
					<a href="routes.php?page=nazad" class="btn btn-info btn-lg text-white col-sm-9">Nastavi sa kupovinom</a>
				</div>
				<div class="col-lg-4">
					<a href="routes.php?page=isprazni" class="btn btn-info btn-lg text-white col-sm-9">Isprazni korpu</a>
				</div>
				<div class="col-lg-4">
					<a href="routes.php?page=naruci" class="btn btn-info btn-lg text-white col-sm-9">Kupi</a>
				</div>
			</div>
		</div>
		<?php 
		
			if(isset($naruci)) {
				
				
		?>
		<form action="routes.php" method="get">	
			<div class="wrap container bg-faded text-center w-25">
				<h4 class="form-signin-heading">Proverite Vase podatke i potvrdite porudzbinu</h4><br>
				<input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php echo $ulogovan['ime']?>" readonly="readonly">
				<span><code><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php echo $ulogovan['prezime']?>" readonly="readonly">
				<span><code><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></code></span>
				<br>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"name="adresa" placeholder="Adresa"><?php if (isset($ulogovan['adresa'])) echo $adresa=$ulogovan['adresa'];?></textarea>
				<span><code><?php if(array_key_exists('adresa', $errors)) echo $errors['adresa']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="mail" placeholder="E-mail" value="<?php if (isset($ulogovan['mail'])) echo $mail=$ulogovan['mail'];?>">
				<span><code><?php if(array_key_exists('mail', $errors)) echo $errors['mail']?></code></span>
				<br>
				<input class="form-control" id="ex2" type="text" name="telefon" placeholder="Telefon" value="<?php if (isset($ulogovan['telefon'])) echo $telefon=$ulogovan['telefon'];?>">
				<span><code><?php if(array_key_exists('telefon', $errors)) echo $errors['telefon']?></code></span>
				<br>
				<input type="hidden" name="idkup" value="<?php echo $ulogovan['idoso']?>">
					
				<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="potvrdi/poruci">
			</div>
		
		<?php 		
			}
		?>
		</form>	
	</body>
</html>
<?php 
	} else {
		header('Location:login.php?msg="Molimo Vas da se prijavite da bi mogli pristupiti trazenoj strani!" ');
	}
?>
