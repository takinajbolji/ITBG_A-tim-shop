<?php
/*
 * ITBG A-tim
 * branko vujatovic
 * PHP akademija
 * 26.07.2018.godine
 * verzija 1.0.
 */
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
	<div class="navbar-brand">Administrator <?php echo $ulogovan['ime'];?></div>
	<nav class="navbar navbar-expand-sm">
		<ul class="navbar-nav">
			<li class="nav-item">
      			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=artikli">Prikaz artikala</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=insert">Unos artikala</a>
    		</li>
    		<li class="nav-item">
     			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=osobe">Prikaz korisnika</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=porudzbina">Pregled porudzbina</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=showisporuceno">Isporucene</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link text-warning font-weight-bold" href="routes.php?page=showotkazano">Otkazane</a>
    		</li>	
  		</ul>
	</nav>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto"></ul>
		<a class="korpa btn btn-outline-light" href="routes.php?page=showporudzbina"><img src="../css/images/pismo.png" alt="Pismo"><sup><span class="badge badge-pill badge-danger"> <?php echo $brojac; ?></span></sup></a>
		<a class="btn btn-outline-light" href="routes.php?page=logout">Log out</a>
	</div>
</nav>