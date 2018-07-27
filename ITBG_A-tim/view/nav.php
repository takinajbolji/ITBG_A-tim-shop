<nav class="navbar navbar-expand-lg navbar-dark bg-info">
	<div class="navbar-brand">Dobro dosli, <?php echo $ulogovan['ime'];?></div>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto"></ul>
		<a class="korpa btn btn-outline-light" href="routes.php?page=showkorpa"><img src="../css/images/korpica.png" alt="Korpica"><sup><span class="badge badge-pill badge-danger"> <?php echo $brojac; ?></span></sup></a>
		<a class="btn btn-outline-light" href="routes.php?page=logout">Log out</a>
	</div>
</nav>