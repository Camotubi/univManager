<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

function addAsignaturaForm()
{
	$form='
		<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
	        <label>Código de asignatura</label>
	        <input type="text" name="cod_asig" class="form-control cod_plan" placeholder="ex. 45D5">
	 
	        <label>Créditos</label>
	        <input type="text" name="creditos" class="form-control" placeholder=" ex. 2">

	        <label>Nombre</label>
	        <input type="text" name="nombre" class="form-control" placeholder="Nombre">
	        <label>Duracion Bruta</label>
	        <input type="text" name="duracion_bruta" class="form-control" placeholder="ex. 4">
	            
	        
	        <input type="hidden" name="action" value="addMateria">
	        <input type="submit" value="Registrar">
		</form>';
	return($form);
}
if(isset($_POST["action"]))
{

	switch($_POST["action"])
	{
		case "addMateria":
		
			$nombre =$_POST["nombre"];
			$creditos = intval($_POST["creditos"]);
			$duracion_bruta=intval($_POST["duracion_bruta"]);
			$cod_asig=$_POST["cod_asig"];
			$db=$config["db"]["univManager"];

			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			if(!checkCodAsigExists($config, $cod_asig))
			{
				$stmt=$con->prepare('INSERT INTO Asignatura(cod_asig,nombre,creditos,duracion_bruta) VALUES(:cod_asig,:nombre,:creditos,:duracion_bruta);');
				$stmt->execute(['cod_asig'=>$cod_asig,'nombre'=>$nombre,'creditos'=>$creditos,'duracion_bruta'=>$duracion_bruta]);
				if($stmt->rowCount())
				{
					$message='Exito';
				}
				else
				{
					$message ='El registro de la asignatura fallo';
				}
			}
			else
			{
				$stmt=$con->prepare('SELECT * FROM Asignatura WHERE cod_asig =:cod_asig');
				$stmt->execute(['cod_asig'=>$cod_asig]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$message ='El codigo de asignatura '.$cod_asig.' ya existe, intente con otro o verifique si no se refiere a la misma asignatura. Nombre:'.$row["cod_asig"]. 'Creditos: '.$row["creditos"].' Duracion bruta: '.$row["duracion_bruta"];
			}
			break;
	}
}
function checkCodAsigExists($config,$cod_asig)
{
	$db=$config["db"]["univManager"];
	$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
	$stmt=$con->prepare('SELECT cod_asig FROM Asignatura WHERE cod_asig =:cod_asig');
	$stmt->execute(['cod_asig'=>$cod_asig]);
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$con=null;
		return (true);
	}
	$con=null;
	return(false);
}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php echo addAsignaturaForm();
		if(isset($message))
		{
			echo $message;
		}
		 ?>
		
	</body>

</html>
