<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

$body="";
$accion="normal";
$message="";
if(isset($_POST["accion"]))
{
	$accion = $_POST["accion"];
}

switch($accion)
{
	case "crearGrupo":
			$cod_grupo = $_POST["cod_grupo"];
			$cod_plan = $_POST["cod_plan"];
			$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT * FROM Grupo;');
			$stmt->execute();
			if($stmt->rowCount()>0)
			{
				$message = "Grupo ya existe";
				echo $message;
			}
			else
			{
				$stmt=$con->prepare('INSERT INTO Grupo(cod_grupo,cod_plan) VALUES(:cod_grupo, :cod_plan)');
				$stmt->execute(['cod_grupo'=>$cod_grupo,'cod_plan'=>$cod_plan]);
				$message ="Exito";
				$_SESSION["message"]=$message;
				header("Location: Grupos.php");
			}
	break;

	default:
	$body=formCrearGrupo($config);
	break;
}

function formCrearGrupo($config)
{
	return(
		'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="accion" value= "crearGrupo">
			<lable>Codigo de Grupo: <lable><input type="text" name = cod_grupo>
			'.generateAvailableProgramsComboBox($config).'
			<input type="submit" value="Crear Grupo">
		</form>
		');
}

function generateAvailableProgramsComboBox($config)
{
			$programasDisponibles=array();
			$db=$config["db"]["univManager"];
			$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
			$stmt=$con->prepare('SELECT * FROM Programa;');
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))

			{
					array_push($programasDisponibles,new Programa($row["cod_plan"],$row["nombre"],$row["fecha_apro"],$row["descripccion"]));
			}
	$comboBox='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<select name="cod_plan">
';
			foreach($programasDisponibles as $programa)
			{
				$comboBox.='<option value="'.$programa->getCod_plan().'">'.$programa->getCod_plan().'-'.$programa->getNombre().'</option>';
			}
			$comboBox.='</select>';
			$con=null;
			return ($comboBox);
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
	$navbarBrand = "Crear Grupo";
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
<?php echo $message;?>

                            </div>
                    </div>


                </div>
            </div>
</div>