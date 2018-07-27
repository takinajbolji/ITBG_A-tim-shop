<?php

/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */
			$id_art = isset($_GET['id_art'])?$_GET['id_art']:"";
			$kolicina=isset($_GET['kolicina'])?$_GET['kolicina']:"";
			$naziv=isset($_GET['naziv'])?$_GET['naziv']:"";
			$cena=isset($_GET['cena'])?$_GET['cena']:"";
			$ukupno=isset($_GET['ukupno'])?$_GET['ukupno']:"";
			$broj_fakture=isset($_GET['broj_fakture'])?$_GET['broj_fakture']:"";
			$id_kup = isset($_GET['id_kup'])?$_GET['id_kup']:"";
			$porudz = isset($_GET['porudz'])?$_GET['porudz']:array();
?>
	

<div class="container bg-faded text-center">
	<h3 class="display-4">Prikaz porudzbina</h3>
	<?php 
						
		foreach ($korisnik as $pom) {
			$dao = new DAO();
			$idoso = $pom['idoso'];
			$porudz = $dao->selectAdminPorudzbinaByIdoso($idoso);
			
			if(!empty($porudz)){
						
	?>
	<div class="row">
	
		<div class="col-sm-5">
			<h3 class="display-6">Poruceni artikli za korisnika: </h3>
		</div>
		<div class="col-sm-3">
			<form action="routes.php" method="get">
				<input class="form-control w-50 text-center" id="ex2" type="text" name="idoso" disabled="disabled" value="<?php if (isset($pom['idoso'])) echo $pom['ime']." ".$pom['prezime']?>">
			</form>
		</div>
	</div>
	<?php ?>	
	<table class="table table-striped table-bordered text-center thead-light table-sm">
		<tr>
			<th>id artikal</th>
			<th>naziv artikla</th>
			<th>cena</th>
			<th>kolicina</th>
			<th>Ukupna cena</th>
			<th>Broj fakture</th>
			<th>vreme obrade</th>
			
			<th>Isporuceno</th>
			<th>Otkazano</th>
		</tr>
		<?php 
				foreach ($porudz as $por) {
					
				
						?>
		<form action="routes.php" method="get">	
			<div class="wrap container bg-faded text-center w-25">	
			<tr>
				<td><?php if (isset($por['id_art'])) echo $por['id_art']?></td>
				<td><?php if (isset($por['naziv'])) echo $por['naziv'] ?></td>
				<td><?php if (isset($por['cena'])) echo $por['cena'] ?></td>	
				<td><?php if (isset($por['kolicina'])) echo $por['kolicina'] ?></td>	
				<td><?php if (isset($por['ukupno'])) echo $por['ukupno'] ?></td>
				<td><?php if (isset($por['broj_fakture'])) echo $por['broj_fakture'] ?></td>
				<td><?php if (isset($por['vremeobrade'])) echo $por['vremeobrade']?></td>
				
			<th class="text-white font-weight-normal align-middle">
				<input type="hidden" name="id_kup" value="<?php if (isset($por['id_kup'])) echo $por['id_kup']?>">
				<input type="hidden" name="id_art" value="<?php if (isset($por['id_art'])) echo $por['id_art']?>">
				<input type="hidden" name="naziv" value="<?php if (isset($por['naziv'])) echo $por['naziv']?>">
				<input type="hidden" name="cena" value="<?php if (isset($por['cena'])) echo $por['cena']?>">
				<input type="hidden" name="kolicina" value="<?php if (isset($por['kolicina'])) echo $por['kolicina']?>">
				<input type="hidden" name="ukupno" value="<?php if (isset($por['ukupno'])) echo $por['ukupno']?>">
				<input type="hidden" name="broj_fakture" value="<?php if (isset($por['broj_fakture'])) echo $por['broj_fakture']?>">	
				<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="isporuceno">
			</th>
			<th class="text-white font-weight-normal align-middle">
				<input type="hidden" name="id_kup" value="<?php if (isset($por['id_kup'])) echo $por['id_kup']?>">
				<input type="hidden" name="id_art" value="<?php if (isset($por['id_art'])) echo $por['id_art']?>">
				<input type="hidden" name="naziv" value="<?php if (isset($por['naziv'])) echo $por['naziv']?>">
				<input type="hidden" name="cena" value="<?php if (isset($por['cena'])) echo $por['cena']?>">
				<input type="hidden" name="kolicina" value="<?php if (isset($por['kolicina'])) echo $por['kolicina']?>">
				<input type="hidden" name="ukupno" value="<?php if (isset($por['ukupno'])) echo $por['ukupno']?>">
				<input type="hidden" name="broj_fakture" value="<?php if (isset($por['broj_fakture'])) echo $por['broj_fakture']?>">	
				<input id="size" class="btn btn-info btn-lg btn-block" type="submit" name="page" value="otkazano">
				
			</th>

			</tr>
			</div>
		</form>
	
		<?php }	?>
		
	</table>
	<?php 
				
		}
	}
	?>
</div>