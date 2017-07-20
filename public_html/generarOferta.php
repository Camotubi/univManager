<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';
if(isset($_SESSION["selectedProgram"]))
{
	$selectedProgram = $_SESSION["selectedProgram"];
}
if(isset($_SESSION["selectedStudents"]))
{
	$selectedStudents=$_SESSION["selectedStudents"];
}
$selectedStudents=array();
if(isset($_POST["action"]))
{
	$action=$_POST["action"];
	switch($action)
	{
	case "removeRow":
		$rowToRemove=$_POST["rowToRemove"];
		array_splice($selectedStudents,intval($rowToRemove),1);
		break;	
	case "searchStudent":
		$cedula = $_POST["cedula"];
		$alreadySelected = false;
		if(isset($selectedStudents))
		{
			foreach($selectedStudents as $student)
			{
				if($student->getCedula()==$cedula)
				{
					$alreadySelected = true;
				}
			}
			if($alreadySelected)
			{
				echo'already Selected';
			}
		}
		if(!$alreadySelected)
		{

			$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) WHERE e.cedula = :cedula;');
			$stmt->execute(['cedula'=>$cedula]);
		       	$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount()<=0)
			{
				echo 'not in db';
			}
			else
			{
				if(isset($selectedStudents))
				{
					array_push($selectedStudents, new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));

					$_SESSION["selectedStudents"]=$selectedStudents;
				}
				else
				{
					$selectedStudents = array(new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));
					$_SESSION["selectedStudents"]=$selectedStudents;
				}
			}	
		}
	}
}
function generarTabla($studentsArr)
{
	$tabla='<table><tr><th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Correo</th><th>Telefono</th><th>Direccion</th><th>Sexo</th>';
	$x=0;
	foreach($studentsArr as &$student)
	{
		$tabla.='<tr>
			<td>
				'.$student->getNombre().'
			</td>
			<td>
				'.$student->getApellido().'
				
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
				
				'.$student->getDireccion().'
			</td>

			<td>
				'.$student->getSexo().'
			</td>
			<td>
				<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
					<input type="hidden" name="rowToRemove" value="'.$x.'">
					<input type="hidden" name="action" value="removeRow">
					<input type ="submit" value="Remover Estudiante">
				</form>
			</td>
			</tr>';
		$x=$x+1;
	}
	$tabla.='<table>';
	return($tabla);
}

function showSearchStudentForm()
{
	return('
				<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
					<input type="text" name="cedula" >
					<input type="hidden" name="action" value="searchStudent">
					<input type ="submit" value="Buscar Cedula">
				</form>
');
}

function generateAvailableProgramsComboBox()
{
			$programasDisponibles=array();
			$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT * FROM Programa;');
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
					array_push($programasDisponibles,new Programa($row["cod_plan"],$row["fecha_aprob"],$row["nombre"],$row["descripccion"]));
			}

	$comboBox='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="action" value="selectPrograma">
			<select>
';
			foreach($programasDisponibles as $programa)
			{
				$comboBox.='<option value="'.$programa->getCod_plan().'">'.$programa->getCod_plan().'-'.$programa->getNombre().'</option>';
			}
			$comboBox.='</select>
					<input type ="submit" value="Seleccionar Programa">
				</form>
';
			return ($comboBox);
}
?>

<!doctype html>
<html>
<head>
</head>
<body>

<?php echo showSearchStudentForm(); ?>
<?php echo generarTabla($selectedStudents);?>

</body>
</html>

