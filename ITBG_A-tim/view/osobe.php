<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */
?>

<div class="container bg-faded text-center">
	<h3 class="display-4">Prikaz korisnika</h3>
	<table class="table table-striped table-bordered text-center thead-light table-sm">
		<tr>
			<th>id</th>
			<th>Ime</th>
			<th>Prezime</th>
			<th>Username</th>
			<th>Adresa</th>
			<th>E-mail</th>
			<th>Telefon</th>
			<th>Izmeni</th>
		</tr>
		<?php 
			foreach ($osobe as $pom) {			
		?>
		<tr>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['idoso']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['ime']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['prezime']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['username']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['adresa']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['mail']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['telefon']?></td>
			<th class="bg-secondary text-white font-weight-normal align-middle"><a class="boja btn btn-info btn-sm btn-block" href="routes.php?page=showeditosoba&idoso=<?php echo $pom['idoso']?>">Izmeni podatak</a></th>
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