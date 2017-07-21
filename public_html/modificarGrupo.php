<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Grupo.php';
require RESOURCES_PATH.'/security.php';
$body= "";
$selectedGrupo = null;
if(isset($_SESSION["selectedGrupo"]))
{
	$selectedGrupo = $_SESSION["selectedGrupo"];
}
else
{
	header("Location: Grupos.php");
}
$estudiantesEnElGrupo=array();
$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) INNER JOIN Grupo AS g on (g.cod_grupo = e.cod_grupo) WHERE (g.cod_grupo= :cod_grupo)');
            $stmt->execute(['cod_grupo'=>$selectedGrupo->getCod_grupo()]);
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
      

$selectedStudents=array();
$accion = "normal";
if(isset($_POST["accion"]))
{
	$accion=$_POST["accion"];
}
	switch($accion)
	{
		case "buscarCedula":
		$body='Codigo Grupo:'.$selectedGrupo->getCod_grupo().'<br>'.showSearchStudentForm().'<br>';
		$cedula = $_POST["cedula"];
		$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) WHERE e.cedula = :cedula;');
			$stmt->execute(['cedula'=>$cedula]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount()>0)
			{
				$body.=searchedStudentInfo(new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));
			}
			$body.=generarTabla($estudiantesEnElGrupo);
	break;
		case "agregarAlgGrupo":
		$cedula = $_POST["cedula"];
		$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('UPDATE Estudiante SET cod_grupo=:cod_grupo WHERE cedula = :cedula');
			$stmt->execute(['cod_grupo'=>$selectedGrupo->getCod_grupo(),'cedula'=>$cedula]);
		$body= 'Codigo Grupo:'.$selectedGrupo->getCod_grupo().'<br>'.showSearchStudentForm().'<br><h4>Estudiantes en el Grupo:</h4>'.generarTabla($estudiantesEnElGrupo);	
		break;
	default:
	 $body= 'Codigo Grupo:'.$selectedGrupo->getCod_grupo().'<br>'.showSearchStudentForm().'<br><h4>Estudiantes en el Grupo:</h4>'.generarTabla($estudiantesEnElGrupo);
	break;

	}

function generarTabla($studentsArr)
{
	$tabla='<table class="table table-hover table-striped"><tr><th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Correo</th><th>Telefono</th><th>Direccion</th><th>Sexo</th>';
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
	$tabla.='</table>';
	return($tabla);
}


function searchedStudentInfo($student)
{
	$tabla='<table class="table table-hover table-striped"><tr><th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Correo</th><th>Telefono</th><th>Direccion</th><th>Sexo</th>';
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
					<input type="hidden" name="cedula" value="'.$student->getCedula().'">
					<input type="hidden" name="accion" value="agregarAlgGrupo">
					<input type ="submit" value="Agregar Al grupo">
				</form>
			</td>
			</tr>';
	$tabla.='</table>';
	return($tabla);
}

function showSearchStudentForm()
{
	return('
				<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
					<input type="text" name="cedula" >
					<input type="hidden" name="accion" value="buscarCedula">
					<input type ="submit" value="Buscar Cedula">
				</form>
');
}
?>

<!doctype html>
<html>
<?php require TEMPLATES_PATH.'/head.php';?>
<body>
<?php
	require TEMPLATES_PATH.'/sidebar.php';
?>
<div class="main-panel">

<?php
	$navbarBrand = "Modificar Grupo";
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