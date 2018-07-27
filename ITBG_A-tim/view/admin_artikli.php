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
	<h3 class="display-4">Prikaz artikala</h3>
	<table class="table table-striped table-bordered text-center thead-light table-sm">
		<tr>
			<th>id</th>
			<th>Naziv</th>
			<th>Cena</th>
			<th>Izmeni</th>
		</tr>
		<?php 
			foreach ($artikli as $pom) {			
		?>
		<tr>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['idart']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['naziv']?></td>
			<td class="bg-secondary text-white font-weight-normal align-middle"><?php echo $pom['cena']?></td>
			<th class="bg-secondary text-white font-weight-normal align-middle w-25"><a class="boja btn btn-info btn-sm btn-block" href="routes.php?page=showeditartikal&idart=<?php echo $pom['idart']?>">Izmeni podatak</a></th>
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