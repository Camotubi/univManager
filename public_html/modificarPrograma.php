<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/Asignatura.php';
require RESOURCES_PATH.'/security.php';

$selectedPrograma = null;
$selectedProgramaAsignaturas = array();
if(isset($_SESSION["selectedPrograma"]))
{
	$selectedPrograma = $_SESSION["selectedPrograma"];
}
else
{

	header('Location: menuProgramas.php');
}
$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT a.cod_asig,a.nombre,a.creditos,a.duracion_bruta FROM Asignatura AS a INNER JOIN ProgramaAsignatura AS pa on(a.cod_asig = pa.cod_asig) INNER JOIN Programa AS p on(p.cod_plan = pa.cod_plan) WHERE pa.cod_plan = :cod_plan');
			$stmt->execute(['cod_plan'=>$selectedPrograma->getCod_plan()]);
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			array_push($selectedProgramaAsignaturas, new Asignatura($row['cod_asig'],$row['nombre'],$row['creditos'],$row['duracion_bruta']));
		}
		$con = null;
$accion = "normal";
if(isset($_POST["accion"]))
{
	$accion =$_POST["accion"];
}
$body=null;
switch ($accion) {

	case 'mostrarBusquedaAsignatura':
	$body='
		<form method ="post" action= "'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		<input type="hidden" name="accion" value="buscarAsignatura">
		<lable>Codigo Asignatura:</label> <input type ="text" name="cod_asigBusqueda">
		<lable>Nombre Asignatura:</labla> <input type="text" name="nombreBusqueda">
		<input type="submit" value="Buscar Asignatura">
		</form>

	';

	break;

	case 'buscarAsignatura':
	$resultadoBusquedaAsignatura= array();
	$cod_asigBusqueda=$_POST["cod_asigBusqueda"];
	$nombreBusqueda=$_POST["nombreBusqueda"];

	$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT a.cod_asig,a.nombre,a.creditos,a.duracion_bruta FROM Asignatura AS a WHERE a.cod_asig LIKE :cod_asig or a.nombre  LIKE :nombre');
			$stmt->execute(['cod_asig'=>'%'.$cod_asigBusqueda.'%','nombre'=>'%'.$nombreBusqueda.'%']);
	
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			array_push($resultadoBusquedaAsignatura, new Asignatura($row['cod_asig'],$row['nombre'],$row['creditos'],$row['duracion_bruta']));
		}
		$con = null;
		$_SESSION["resultadoBusquedaAsignatura"]=$resultadoBusquedaAsignatura;
		$body=tablaAsignaturasAgregar($resultadoBusquedaAsignatura);
	break;

	case 'agregarAsignaturaPrograma':
	$asigToAdd=$_POST["asigToAdd"];
	$resultadoBusquedaAsignatura=$_SESSION["resultadoBusquedaAsignatura"];
	$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
	$stmt=$con->prepare('SELECT a.cod_asig,a.nombre,a.creditos,a.duracion_bruta FROM Asignatura AS a INNER JOIN ProgramaAsignatura AS pa on(a.cod_asig = pa.cod_asig) INNER JOIN Programa AS p on(p.cod_plan = pa.cod_plan )WHERE pa.cod_plan = :cod_plan AND pa.cod_asig = :cod_asig' );
			$stmt->execute(['cod_plan'=>$selectedPrograma->getCod_plan(),'cod_asig'=>$resultadoBusquedaAsignatura[intval($asigToAdd)]->getCod_asig()]);

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$_SESSION["message"]="las asignatura ya existe en el programa";
		header('Location: '.htmlspecialchars($_SERVER["PHP_SELF"]));
	}
	else
	{
		$stmt=$con->prepare('INSERT INTO ProgramaAsignatura(cod_asig,cod_plan) VALUES(:cod_asig,:cod_plan)');
		$stmt->execute(['cod_asig'=>$resultadoBusquedaAsignatura[intval($asigToAdd)]->getCod_asig(),'cod_plan'=>$selectedPrograma->getCod_plan()]);
		$_SESSION["message"]="Exito";
		header('Location: '.htmlspecialchars($_SERVER["PHP_SELF"]));
	}
	break;

	case 'quitarAsignaturaProgama':
		$asigToRemove=$_POST["asigToRemove"];
		$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
		$stmt=$con->prepare('DELETE FROM ProgramaAsignatura WHERE( cod_asig =:cod_asig AND cod_plan = :cod_plan)' );
		$stmt->execute(['cod_plan'=>$selectedPrograma->getCod_plan(),'cod_asig'=>$selectedProgramaAsignaturas[intval($asigToRemove)]->getCod_asig()]);
		header('Location: '.htmlspecialchars($_SERVER["PHP_SELF"]));
	break;
	default:
		$body='  <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		                    <input type="hidden" name="accion" value="mostrarBusquedaAsignatura">
		                    <input class="btn btn-info btn-fill" type ="submit" value="Agregar asignatura al Programa">
		                    </form>'.tablaAsignaturasEnprograma($selectedProgramaAsignaturas);
		break;
}
		function tablaAsignaturasAgregar($asignaturasArr) 
		{
		    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Asignatura</th><th>Nombre</th><th>Creditos</th><th>Duracion Bruta</th><th>Accion</th></thead><tbody>';
		    $x=0;
		    foreach($asignaturasArr as &$asignatura)
		    {
		        $tabla.='<tr>
		            <td>
		                '.$asignatura->getCod_asig().'
		            </td>
		            <td>
		                '.$asignatura->getNombre().'
		                
		            </td>
		            <td>
		                '.$asignatura->getCreditos().'
		                
		            </td>
		            <td>
		                '.$asignatura->getDuracion_bruta().'
		                
		            </td>
		            
		            <td>
		                <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		                    <input type="hidden" name="asigToAdd" value="'.$x.'">
		                    <input type="hidden" name="accion" value="agregarAsignaturaPrograma">
		                    <input class="btn btn-info btn-fill" type ="submit" value="Agregar asignatura al Programa">
		                </form>
		            </td>
		            </tr>';
		        $x=$x+1;
		    }
		    $tabla.='</tbody><table>';
		    return($tabla);
		}


		function tablaAsignaturasEnprograma($asignaturasArr) 
		{
		    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Asignatura</th><th>Nombre</th><th>Creditos</th><th>Duracion Bruta</th><th>Accion</th></thead><tbody>';
		    $x=0;
		    foreach($asignaturasArr as &$asignatura)
		    {
		        $tabla.='<tr>
		            <td>
		                '.$asignatura->getCod_asig().'
		            </td>
		            <td>
		                '.$asignatura->getNombre().'
		                
		            </td>
		            <td>
		                '.$asignatura->getCreditos().'
		                
		            </td>
		            <td>
		                '.$asignatura->getDuracion_bruta().'
		                
		            </td>
		            
		            <td>
		                <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
		                    <input type="hidden" name="asigToRemove" value="'.$x.'">
		                    <input type="hidden" name="accion" value="quitarAsignaturaProgama">
		                    <input class="btn btn-info btn-fill" type ="submit" value="Quitar Asignatura del Programa">
		                </form>
		            </td>
		            </tr>';
		        $x=$x+1;
		    }
		    $tabla.='</tbody><table>';
		    return($tabla);
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
                            
                            
                                
                                 <?php 
                                 echo'Nombre del Programa:'.$selectedPrograma->getNombre();
echo $body;?>

                            </div>
                    </div>


                </div>
            </div>
</div>