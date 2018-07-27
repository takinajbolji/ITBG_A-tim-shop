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
	
	$inactive = 900;
	
	if(isset($_SESSION['loginTime'])) {
		$session_life = time() - $_SESSION['loginTime'];
		
		if($session_life > $inactive) {
			session_destroy();
			header("Location: login.php");
		}
	}
	
	$_SESSION['loginTime']= time();
	//brojanje artikala u korpi
	$brojac = 0;
	if(isset($_SESSION['korpa'])) {
		$brojac = count(isset($_SESSION['korpa'])?$_SESSION['korpa']:array());
	}
		
	if($ulogovan) {
		$artikli=isset($artikli)?$artikli:array();
		$korpa=isset($_SESSION['korpa'])?$_SESSION['korpa']:array();
?>
<html lang="sr">
	<?php require_once 'head.php';?>
	<body class="bg-light">
		<?php require_once 'nav.php';?>
		
		<div class="container bg-faded text-center">
			<h3 class="display-4">Prikaz artikala</h3>
			<table class="table table-striped table-bordered text-center thead-light table-sm">
				<tr>
					<th>id</th>
					<th>Naziv</th>
					<th>Cena</th>
					<th>Kupi</th>
				</tr>
				<?php 
					foreach ($artikli as $pom) {			
				?>
				<tr>
					<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['idart']?></td>
					<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['naziv']?></td>
					<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['cena']?></td>
					<th class="bg-secondary text-white font-weight-normal align-middle w-25"><a class="boja btn btn-info btn-sm btn-block" href="routes.php?page=korpa&idart=<?php echo $pom['idart']?>">Ubaci u korpu</a></th>
				</tr>
				<?php }?>
			</table>
			<span><code>
				<?php 
					if(isset($msg)){
						echo $msg;
					}
				?>
			</code></span>
		</div>
	</body>
</html>	
<?php 
	} else {
		header('Location:login.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>
