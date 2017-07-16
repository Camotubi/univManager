<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de Session</title>
	</head>
	<body>
		<form method ="post" action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"">
			<p>Usuario: <input type="text" name="username" required autofocus placeholder="Ingrese su usuario"></p>
			<p>Contraseña: <input type="password" name="contra" required  placeholder="Ingrese su contraseña"></p>
			<p><input type="submit" value="Iniciar Sesion"></p>
				</form>
<?php
	include '../resources/config.php';
	$db=$config['db']['univManager'];
	$username=$_POST["username"];
	$contra=$_POST["contra"];
	if($username != null)
	{

	}
?>
	</body>
</html>
