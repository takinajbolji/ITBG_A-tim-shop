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
		$brojac = count(isset($broj_redova) ? $broj_redova : "");
	}
	
	if($ulogovan) {
		$artikli=isset($artikli)?$artikli:array();
		$korpa=isset($_SESSION['korpa'])?$_SESSION['korpa']:array();
		$naziv = isset($_GET['naziv'])?$_GET['naziv']:"";
		$cena = isset($_GET['cena'])?$_GET['cena']:"";
		$idart = isset($_GET['idart'])?$_GET['idart']:"";
		$id_kup = isset($_GET['id_kup'])?$_GET['id_kup']:"";
		
		$msg = isset($msg)?$msg:"";
		$errors = isset($errors)?$errors:array();
?>
<html lang="sr">
	<?php require_once 'head.php';?>
	<body class="bg-light">
		<?php 
			require_once 'nav_admin.php';
			if (empty($artikli)){
				if (!isset($insert)){
					if (!isset($editart)){
						if (!isset($osobe)){
							if (!isset($osoba)){
								if (!isset($korisnik)){
									if (!isset($isporuceno)){
										if(!isset($otkazano)){
											
										}else {
											include 'otkazano.php';	
										}
									}else {
										include 'isporuceno.php';
									}									
								} else {
									include 'admin_porudzbine.php';
								}
							} else {
								include 'edit_osoba.php';
							}
						} else {
							include 'osobe.php';
						}
					} else {
						include 'edit_artikal.php';
					}
				} else {
					include 'unosartikla.php';
				}
			} else {
				include 'admin_artikli.php';
			}			
		?>	
	</body>
</html>
<?php 
	} else {
		header('Location:login.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>