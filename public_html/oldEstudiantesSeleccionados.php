/*
$selectedStudents=array();
$action = "normal";
if(isset($_POST["action"]))
{
	$action=$_POST["action"];
}
	switch($action)
	{
	case "removeRow":
		$rowToRemove=$_POST["rowToRemove"];
		array_splice($selectedStudents,intval($rowToRemove),1);
		$body=generarTabla($selectedStudents);
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
			$stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) INNER JOIN GRUPO AS g on (g.cod_grupo = e.cod_grupo) WHERE e.cedula = :cedula;');
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
	$body=generarTabla($selectedStudents);
	break;
	default:
	 $body= showSearchStudentForm();
	break;

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
?>
<!--
<!doctype html>
<html>
<?php require TEMPLATES_PATH.'/head.php';?>
<body>
<?php
	require TEMPLATES_PATH.'/sidebar.php';
?>
<div class="main-panel">

<?php
	$navbarBrand = "Programas";
	require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">

<div class="content">
            <div class="container-fluid">
                <div class="row">
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
<?php echo $body;?>

                            </div>
                    </div>


                </div>
            </div>
</div>

-->