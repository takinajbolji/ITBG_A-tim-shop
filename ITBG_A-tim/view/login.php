<?php 
	
?>
<html lang="sr">
	<?php require_once 'head.php';?>
	<body class="">
		<div class="wrapper container bg-faded text-center">
    		<form class="form-signin" action="routes.php" method="post">       
      			<h2 class="form-signin-heading">Molim, ulogujte se</h2>
      			<input type="text" class="form-control" name="username" placeholder="Username"/><br>
      			<input type="password" class="form-control" name="password" placeholder="Password"/>      
      			<label class="checkbox">
        			<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Zapamti me
      			</label>
      			<button class="btn btn-lg btn-primary btn-block" type="submit" name="page" value="login">Login</button> <br>
      			<p class="message">Nemate nalog? <a href="routes.php?page=showregist">Kreirajte nalog</a></p>
    		</form>
			<span><code>	
			<?php 
				if(isset($msg)){
					echo $msg;			
				}		
				$poruka=isset($_GET["msg"])?$_GET["msg"]:"";
				echo $poruka;		
			?>
			</code></span>
		</div>	
	</body>
</html>