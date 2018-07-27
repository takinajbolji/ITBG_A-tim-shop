<?php

/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.4.
 */
			$id_art = isset($_GET['idart'])?$_GET['idart']:"";
			$kolicina=isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$ukupno=isset($_GET['ukupno'])?$_GET['ukupno']:"";
			$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
			$id_kup = isset($_GET['id_kup'])?$_GET['id_kup']:"";
			$porudz = isset($_GET['porudz'])?$_GET['porudz']:array();	
?>

<div class="container bg-faded text-center">
	<div class="col-sm-5">
		<h3 class="display-6">Otkazani artikli za korisnika: </h3>
	</div>
	<?php 
	$dao = new DAO();
	$korisnik=$dao->selectOsobe();
		foreach ($korisnik as $pom) {
			$dao = new DAO();
			$idoso = $pom['idoso'];
			$otkazano = $dao->selectOtkazanoByIdoso($idoso);
			
			if(!empty($otkazano)){
						
	?>
	<div class="row">
		<div class="col-sm-3">
			<form action="routes.php" method="get">
				<input class="form-control w-50 text-center" id="ex2" type="text" name="idoso" disabled="disabled" value="<?php if (isset($pom['idoso'])) echo $pom['ime']." ".$pom['prezime']?>">
			</form>
		</div>
	</div>
	<?php ?>	
	<table class="table table-striped table-bordered text-center thead-light table-sm">
		<tr>
			<th>id artikla</th>
			<th>naziv artikla</th>
			<th>cena</th>
			<th>kolicina</th>
			<th>Ukupna cena</th>
			<th>Broj fakture</th>
			<th>Vreme obrade</th>
			
		</tr>
		<?php 
				foreach ($otkazano as $por) {
		?>
		<tr>		
			<td><?php if (isset($por['id_art'])) echo $por['id_art']?>    </td>
			<td><?php if (isset($por['naziv'])) echo $por['naziv'] ?> </td>
			<td><?php if (isset($por['cena'])) echo $por['cena'] ?> </td>	
			<td><?php if (isset($por['kolicina'])) echo $por['kolicina'] ?> </td>	
			<td><?php if (isset($por['ukupno'])) echo $por['ukupno'] ?> </td>
			<td><?php if (isset($por['broj_fakture'])) echo $por['broj_fakture'] ?> </td>
			<td><?php if (isset($por['vremeobrade'])) echo $por['vremeobrade']?></td>
		</tr>
		<?php }	?>
		
	</table>
	<?php 
				
		}
	}
	?>
</div>