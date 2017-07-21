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
use Dompdf\Dompdf;
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
	case "genTabla":
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
     
        $body=tablaOferta($estudiantesEnElGrupo);
	break;
	default:
	$db=$config["db"]["univManager"];
	$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
	$stmt=$con->prepare('SELECT DISTINCT g.cod_grupo FROM Asignatura AS a INNER JOIN GrupoProfesorAsignatura as gpa on gpa.cod_asig=a.cod_asig INNER JOIN Grupo as g on g.cod_grupo=gpa.cod_grupo ');
            $stmt->execute();
            $grupos = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {  
            array_push($grupos,$row["cod_grupo"]);
        }
            $stmt=$con->prepare('SELECT DISTINCT a.cod_asig,g.cod_grupo,a.nombre,a.duracion_bruta FROM Asignatura AS a INNER JOIN GrupoProfesorAsignatura as gpa on gpa.cod_asig=a.cod_asig INNER JOIN Grupo as g on g.cod_grupo=gpa.cod_grupo ');
            $stmt->execute();
            $cod_asignaturas= array();
            $nombreAsignaturas= array();
            
            $duraccion_brutas=array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {  
            array_push($cod_asignaturas,$row["cod_asig"]);
            array_push($nombreAsignaturas,$row["nombre"]);
        }
        var_dump($grupos);

		$body=forminicial($cod_asignaturas,$nombreAsignaturas,$grupos,$duraccion_brutas);
	break;
}

function forminicial($cod_asignaturas,$nombreAsignaturas,$grupos)
{
		$form='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		<input type="hidden" name="accion" value="mostrarFormInfoAdicional">
		Grupo: <select name="cod_grupo">';
		foreach($grupos as &$cod_grupo)
		{
			$form.='<option value="'.$cod_grupo.'">'.$cod_grupo.'</option>';
		}
		$form.='</select>
		Asignatura: <select name="cod_asig>';
		$x=0;
		foreach($cod_asignaturas as &$cod_asig)
		{
			$form.='<option value="'.$cod_asig.'>'.$cod_asig.' '.$nombreAsignaturas[$x].'</option>';
			$x=$x+1;		
		}
		$form.='<input type="submit" value="Seleccionar>"';
		return($form);
}

function formInfoAdicional($Asignatura,$gruposDisponibles,$AsignaturasDisponibles)
{
	$pagos=0;
	$form='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		<input type="hidden" name="accion" value="genTabla">';
	if ($Asignatura->getDuracion_bruta()<=20) {
		$pagos=1;
	}
	elseif ($Asignatura->getDuracion_bruta()>20 && $Asignatura->getDuracion_bruta()<=48)
	{
		$pago=2;
	}
	else
	{
		$pago=3;
	}
	for($i=1;$i<=$pago;$i++)
	{
		$form.='<lable>Fecha del Pago '.$i.': </lable><input type="text" name="fechaPago'.$i.'"><br><br>';
	}
	$form.='Fecha de Matricula: <input type="text" name="matricula"><br><br>
			Fecha de Clases: <input type="text" name="Clases"><br><br>
			Fecha de Retiro/ Inclusion: <input type="text" name="RetiroInclucion"><br><br>
			Fecha de Retiro Fuera del Periodo: <input type="text" name="RetiroFueradelPeriodo"><br><br>
			Fecha de Retiro Total: <input type="text" name="retiroTotal"><br><br>
			<input type="submit" value="Confirmar">
	</form>';
	return($form);
}
function formSelectAsigGrupo()
{
	return('<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		<input type="hidden" name="accion" value="mostrarInfoAdiciona">


');
}
function tablaOferta($estudiantes)
{
		$matricula = $_POST["matricula"];
		$clases = $_POST["Clases"];
		$retiroInclucion=$_POST["RetiroInclucion"];
		$retiroFueradelPeriodo=$_POST["RetiroFueradelPeriodo"];
		$retiroTotal = $_POST["retiroTotal"];
		$pagmatricu='http://matricula.utp.ac.pa';
		$profesoresDisponibles=$_SESSION["profesoresDisponibles"];
		$profesorSeleccionado =$_SESSION["profesorSeleccionado"];
		$cantDiasClase=$_SESSION["cantDiasClase"];
		$salones=$_SESSION["salones"];
		$diasClase=$_SESSION["diasClase"];
		$horasClase=$_SESSION["horasClase"];
		$asignaturaSeleccionada=$_SESSION["asignaturaSeleccionada"];
		$grupoSeleccionado=$_SESSION["grupoSeleccionado"];
		$tabla ='<html><body><h1> Universidad Tecnologica de Panamá</h1>
		<h2>Facultad de Ingenieria de Sistemas Computacionales</h2>
		<h3>Estudiantes de '.$asignaturaSeleccionada->getNombre().'</h3>
		<h4>Grupo'.$grupoSeleccionado->getCod_grupo().'</h4>
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
		$tabla.='<table>
		Profesor:'.$profesorSeleccionado->getNombre().' '. $profesorSeleccionado->getApellido().'<br> <br></body></html>';
		return($tabla);



		
	}


?>
	<!doctype html>
<html>
<?php require TEMPLATES_PATH.'/head.php';?>
<body>
<div class="wrapper">
<?php
    require TEMPLATES_PATH.'/sidebar.php';
?>
<div class="main-panel">

<?php
    $navbarBrand = "Estudiantes";
    require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Menu Principal</a>
       
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
                                
                                    <?php echo $body; 

                                    ?>
                                

                            </div>
                    </div>


                </div>
            </div>
        </div>

    
    </div>
    <?php require TEMPLATES_PATH.'/footer.php'; ?>  
</body>
</html>

