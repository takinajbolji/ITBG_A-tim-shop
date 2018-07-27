<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */

	if (!isset($_SESSION['ulogovan'])) {
		session_start();
	}
	
	$ulogovan=unserialize($_SESSION['ulogovan']);
	$brojac = 0;
	$inactive = 900;
	$idoso = $ulogovan['idoso'];
	
	if(isset($_SESSION['loginTime'])) {
		$session_life = time() - $_SESSION['loginTime'];
		
		if($session_life > $inactive) {
			$dao->deletePorudzbineByIdoso($idoso);
			session_destroy();
			header("Location: login.php");
		}
	}
	
	$_SESSION['loginTime']= time();
	
	if (isset($_SESSION['korpa'])) {
		$brojac = count(isset($_SESSION['korpa'])?$_SESSION['korpa']:array());
	}
	
	if ($ulogovan) {
		$dao=new DAO();
		
		$ime= isset($ulogovan['ime'])?$ulogovan['ime']:"";
		$prezime= isset($ulogovan['prezime'])?$ulogovan['prezime']:"";
		$adresa= isset($ulogovan['adresa'])?$ulogovan['adresa']:"";
		$mail= isset($ulogovan['mail'])?$ulogovan['mail']:"";
		$telefon= isset($ulogovan['telefon'])?$ulogovan['telefon']:"";
		
		$porudzbina=isset($porudzbina)?$porudzbina:array();
		$id_por=isset($id_por)?$id_por:"";
		$id_kup= isset($id_kup)?$id_kup:"";
		$id_art= isset($id_art)?$id_art:"";
		$naziv= isset($naziv)?$naziv:"";
		$cena= isset($cena)?$cena:"";
		$kolicina= isset($kolicina)?$kolicina:"";
		$ukupno= isset($ukupno)?$ukupno:"";
		$broj_fakture= isset($broj_fakture)?$broj_fakture:"";
		$vremeobrade=isset($vremeobrade)?$vremeobrade:"";
		
		$msg =isset($msg)?$msg:"";
		$errors =isset($errors)?$errors:array();
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
			<h3 class="display-4">Prikaz racuna</h3>
			<h3 class="display-6">Podaci o naruciocu</h3>
			<table class="table table-info table-striped thead-light table-sm w-50 text-center">
				<thead>
					<tr>
						<th>Broj fakture:</th>
						<td><b><?php echo $broj_fakture ?></b>/ <?php echo date("Y")?></td>
					</tr>
					<tr></tr>
					<tr>
						<th>Ime:</th>
        				<td><?php echo $ime ?></td>
					</tr>
					<tr>
						<th>Prezime:</th>
        				<td><?php echo $prezime ?></td>
					</tr>
					<tr>
						<th>Adressa:</th>
        				<td><?php echo $adresa ?></td>
					</tr>
					<tr>
						<th>E-mail:</th>
        				<td><?php echo $mail ?></td>
					</tr>
					<tr>
						<th>Telefon:</th>
        				<td><?php echo $telefon ?></td>
					</tr>
					
				</thead>
			</table>
			<table class="table table-striped table-bordered text-center thead-light table-sm">
				<tr>
					<th>id.por.</th>
					<th>id artikal</th>
					<th>naziv artikla</th>
					<th>cena</th>
					<th>kolicina</th>
					<th>Ukupna cena</th>
					<th>vreme obrade</th>
				</tr>
				<?php 
					foreach ($porudzbina as $pom) {
						if ($pom['id_kup']==$ulogovan['idoso']) {
				?>
				<tr>
					<td><?php echo $pom['id_por']?>    </td>
					<td><?php echo $pom['id_art']?>    </td>
					<td><?php echo $pom['naziv'] ?> </td>
					<td><?php echo $pom['cena'] ?> </td>	
					<td><?php echo $pom['kolicina'] ?> </td>	
					<td><?php echo $pom['ukupno'] ?> </td>
					<td><?php echo $pom['vremeobrade']?></td>
				<?php 
						}
					}
				?>
			</table>
			<?php 
				if(isset($msg)){
					echo $msg;
				}
			?>
			<div class="container bg-faded text-center row">
				<div class="col-lg-4">
					
					<a href="routes.php?page=artikliKupca&idoso" class="btn btn-info btn-lg text-white col-sm-9">Hvala na kupovini!</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php 
	} else {
		header('Location:login.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>