<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';


			$cod_plan = 
			$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT cod_plan FROM Programa WHERE :cod_plan = cod_plan;');
			$stmt->execute(['cod_plan'=>$_POST["cod_plan"]]);
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$message = "El codigo de plan ya existe";
			}
			else
			{
				$stmt=$con->prepare('INSERT INTO Programa(cod_plan,nombre,fecha_apro,descripccion) VALUES(:cod_plan,:nombre,:fecha_apro,:descrip');
				$stmt->execute(['cod_plan'=])
			}
	{
		$con=null;
		return (true);
	}
	$con=null;
	return(false);

?>
<form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
	        <label>Codigo de Plan</label>
	        <input type="text" name="cod_plan" class="form-control cod_plan" placeholder="">
	        <label>Nombre</label>
	        <input type="text" name="nombre" class="form-control nombre_plan" placeholder="">
	        <label>Fecha de aprobacion</label>
	        <input type="Date" name="fecha_aprob" class="form-control fecha_aprob" placeholder="">
	        <label>Descripccion</label>
	        <input type="text" name="descripccion" class="form-control nombre_plan" placeholder="">
	        <input type="hidden" name="accion" value="crearPrograma">
	        <input type="submit" value="Crear Programa">
		</form>';