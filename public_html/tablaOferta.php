<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Grupo.php';
require RESOURCES_PATH.'/Asignatura.php';
require RESOURCES_PATH.'/Clase.php';
require RESOURCES_PATH.'/Profesor.php';
require RESOURCES_PATH.'/security.php';
require LIBRARY_PATH.'/dompdf/autoload.inc.php';

$grupoSeleccionado=$_SESSION["grupoSeleccionado"];
$profesoresDisponibles=$_SESSION["profesoresDisponibles"];
		$profesorSeleccionado =$_SESSION["profesorSeleccionado"];
		$cantDiasClase=$_SESSION["cantDiasClase"];
		$salones=$_SESSION["salones"];
		$diasClase=$_SESSION["diasClase"];
		$horasClase=$_SESSION["horasClase"];
		$asignaturaSeleccionada=$_SESSION["asignaturaSeleccionada"];
		$grupoSeleccionado=$_SESSION["grupoSeleccionado"];
$estudiantesEnElGrupo=array();
$accion="normal";
if(isset($_POST["accion"]))
{
	$accion=$_POST["accion"];
}
switch($accion)
{
	case "generartable":
	$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) INNER JOIN Grupo AS g on (g.cod_grupo = e.cod_grupo) WHERE (g.cod_grupo= :cod_grupo)');
            $stmt->execute(['cod_grupo'=>$grupoSeleccionado->getCod_grupo()]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($estudiantesEnElGrupo))
                {
                    array_push($estudiantesEnElGrupo, new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));

                    $_SESSION["estudiantesEnElGrupo"]=$estudiantesEnElGrupo;
                }
                else
                {   
                    $estudiantesEnElGrupo = array( new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));
                    $_SESSION["estudiantesEnElGrupo"]=$estudiantesEnElGrupo;
                }
        }

	break;
	default:
		$body=formInfoAdicional($asignaturaSeleccionada);
	break;
}


function formInfoAdicional($Asignatura)
{
	$pagos=0;
	$form='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		<input type="hidden" name="accion" value="generartabla">';
	if ($Asignatura->getDuracion_bruta()<=20) {
		$pagos=1;
	}
	elseif ($Asignatura>20 && $Asignatura<=48)
	{
		$pago=2;
	}
	else
	{
		$pago=3;
	}
	for($i=1;$i<=$pago;$i++)
	{
		$form.='<lable>Fecha del Pago '.$i.'</lable><input type="text" name="fechaPago'.$i.'">';
	}
	$form.='<input type="text" name="matricula">
			<input type="text" name="Clases">
			<input type="text" name="RetiroInclucion">
			<input type="text" name="Retiro Fuera del Periodo">
			<input type="text" name="Retiro Total">
			<input type="submit" value="Confirmar"
	</form>';
	return($form);
}
function tablaOferta($estudiantes)
{
	$profesoresDisponibles=$_SESSION["profesoresDisponibles"];
		$profesorSeleccionado =$_SESSION["profesorSeleccionado"];
		$cantDiasClase=$_SESSION["cantDiasClase"];
		$salones=$_SESSION["salones"];
		$diasClase=$_SESSION["diasClase"];
		$horasClase=$_SESSION["horasClase"];
		$asignaturaSeleccionada=$_SESSION["asignaturaSeleccionada"];
		$grupoSeleccionado=$_SESSION["grupoSeleccionado"];
		$tabla ='<h1> Universidad Tecnologica de Panamá</h1>
		<h2>Facultad de Ingenieria de Sistemas Computacionales</h2>
		<h3>Estudiantes de '.$asignaturaSeleccionada->getNombre().'</h3>
		<table>
			<tr>
				<th>Nombre</th><th>Cedula</th><th>Correo</th><th>Telefono</th>
			</tr>';
		foreach($estudiantes as &$student)
		{
			$tabla.='<tr>
			<td>
				'.$student->getNombre().' '.$student->getApellido().'
			</td>
			

			<td>
				'.$student->getCedula().'
				
			</td>
			<td>
				'.$student->getCorreo().'
				
			</td>
			<td>
				'.$student->getTelefono().'	
			</td>
			<td>
			</tr>';
		}
		$tabla.='<table><br>
		Profeso:'.$profesorSeleccionado->getNombre().' '. $profesorSeleccionado->getApellido().'<br>';
		return($tabla);



		echo tablaOferta($estudiantesEnElGrupo);
}