<?php
	  session_start([
			"use_only_cookies" => 1,
			//x Este valor es solo modificable en ".htaccess, httpd.conf,user.ini
			// No tine sentido en tiempo de ejecución decirle a PHP que autinicie sesion
			// a la vez que inicias session.
			"auto_start", // <=======
			"read_and_close" => false // La sesion se cierre automaticamente.
																// Si se coloca a "true" no funciona la variable Global 
																// $_SESSION['ok'],
			/* Valores originales, pero no funciona en PHP Ver 7 
			"use_only_cookies" => 1,
			"auto_start" => 1,
			"read_and_close" => true
			*/
		]); 
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Sisteme Control SGIs</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<h1>Bienvenido al sistema</h1>
	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>