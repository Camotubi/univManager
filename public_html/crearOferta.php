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

$body="";
$gruposDisponibles=array();
$profesoresDisponibles=array();
$asignaturasDeGrupo=array();
$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT * FROM Grupo');
            $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($gruposDisponibles))
                {
                    array_push($gruposDisponibles, new Grupo($row['cod_grupo'],$row['cod_plan']));

                    $_SESSION["gruposDisponibles"]=$gruposDisponibles;
                }
                else
                {   
                    $gruposDisponibles = array(new Grupo($row['cod_grupo'],$row['cod_plann']));
                    $_SESSION["gruposDisponibles"]=$gruposDisponibles;
                }
        }

$accion = "normal";
if(isset($_POST["accion"]))
{
	$accion=$_POST["accion"];
}
	switch($accion)
	{
		
		case "SeleccionarGrupo":
		$_SESSION["grupoSeleccionado"]=$gruposDisponibles[intval($_POST["selectedGrupoIndex"])];
		$grupoSeleccionado=$gruposDisponibles[intval($_POST["selectedGrupoIndex"])];
			$stmt=$con->prepare('SELECT * FROM Grupo as g INNER JOIN Programa as p on g.cod_plan = p.cod_plan INNER JOIN ProgramaAsignatura as pa on pa.cod_plan = p.cod_plan INNER JOIN Asignatura as a on a.cod_asig = pa.cod_asig WHERE g.cod_grupo=:cod_grupo');
			$stmt->execute(['cod_grupo' =>$grupoSeleccionado->getCod_grupo()]);
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				array_push($asignaturasDeGrupo, new Asignatura($row['cod_asig'],$row['nombre'],$row['creditos'],$row['duracion_bruta']));
			}
			$_SESSION["asignaturasDeGrupo"]=$asignaturasDeGrupo;
			$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<lable>Asignatura:</lable><input type="hidden" name="accion" value="SeleccionarAsignatura">'
			.generarComboboxAsignaturas($asignaturasDeGrupo).
			'<lable>Dias de Clase:</lable>'.	
			'<input type="number" name="cantDiasClase" max="2" min ="1">'.
			'<input type ="submit" value="Confirmar">
			</form>'
			;
			


			
		break;
		case "SeleccionarAsignatura":
		$asignaturasDeGrupo=$_SESSION["asignaturasDeGrupo"];
		$_SESSION["asignaturaSeleccionada"]=$asignaturasDeGrupo[intval($_POST["selectedAsigIndex"])];
		$_SESSION["cantDiasClase"]=$_POST["cantDiasClase"];
		$cantDiasClase=$_POST["cantDiasClase"];
		$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="accion" value="SeleccionarProfesor">'.
			generarCamposDeAsignatura($_POST["cantDiasClase"]).
			
			'<input type ="submit" value="Confirmar">
			</form>';

		break;

		case "SeleccionarProfesor":
		$cantDiasClase=$_SESSION["cantDiasClase"];
		$diasClase=array();
		$horasClase=array();
		$salones=array();
		for($i=0;$i<$cantDiasClase ;$i=$i+1)
		{
			array_push($diasClase,$_POST["dia".$i]);
			array_push($horasClase,$_POST["periodo".$i]);
			array_push($salones,$_POST["salon".$i]);
		}
		$_SESSION["diasClase"]=$diasClase;
		$_SESSION["horasClase"]=$horasClase;
		$_SESSION["salones"] = $salones;
		

		$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT pro.id_profesor,pro.cedula,pro.salario,p.nombre,p.apellido,p.cedula,p.telefono,p.direccion,p.sexo,p.correo FROM Profesor as pro INNER JOIN(SELECT pro.id_profesor,COUNT(Gpa.id_profesor) AS ocurrence FROM Profesor AS pro LEFT OUTER JOIN GrupoProfesorAsignatura AS Gpa on Gpa.id_profesor = pro.id_profesor GROUP BY pro.id_profesor) AS d on d.id_profesor = pro.id_profesor INNER JOIN Persona as p on pro.cedula = p.cedula WHERE d.ocurrence <2;');
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))

			{
					array_push($profesoresDisponibles,new Profesor($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo'],$row['salario'],$row['id_profesor']));
			}
			$_SESSION["profesoresDisponibles"]=$profesoresDisponibles;

		$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="accion" value="crearOferta">
			Profesor:'
			.generarComboboxProfesores($profesoresDisponibles).
			'Codigo Hora:<input type="text" name="codigo_hora">'.
			'<input type ="submit" value="Generar Oferta">
			</form>'
			;
		break;
		case "crearOferta":
		$profesoresDisponibles=$_SESSION["profesoresDisponibles"];
		$profesorSeleccionado =$profesoresDisponibles[intval($_POST["SelectedProfIndex"])];
		$_SESSION["profesorSeleccionado"]=$profesorSeleccionado;
		$cantDiasClase=$_SESSION["cantDiasClase"];
		$salones=$_SESSION["salones"];
		$diasClase=$_SESSION["diasClase"];
		$horasClase=$_SESSION["horasClase"];
		$asignaturaSeleccionada=$_SESSION["asignaturaSeleccionada"];
		$grupoSeleccionado=$_SESSION["grupoSeleccionado"];
		$codigoHora =$_POST["codigo_hora"];
		$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
		$stmt =$con->prepare('INSERT INTO GrupoProfesorAsignatura(cod_grupo,cod_asig,id_profesor,dia,salon,periodo,codhorario) VALUES(:cod_grupo,:cod_asig,:id_profesor,:dia,:salon,:periodo,:codigoHora)');
		for($i=0; $i<$cantDiasClase; $i++)
		{
				$stmt->execute(['cod_grupo'=>$grupoSeleccionado->getCod_grupo(),'cod_asig'=>$asignaturaSeleccionada->getCod_asig(),'id_profesor'=>$profesorSeleccionado->id_profesor,'dia'=>$diasClase[$i],'salon'=>$salones[$i],'periodo'=>$horasClase[$i],"codigoHora"=>$codigoHora]);
				;
		}

		break;

		default:
			$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="accion" value="SeleccionarGrupo">
			'
			.generarComboboxgrupos($gruposDisponibles).
			'<input type ="submit" value="Seleccionar Grupo">
			</form>'
			;
		break;
	}
function generarComboboxgrupos($grupos)
{
	$combobox='
	<select name="selectedGrupoIndex">';
	$x=0;
	foreach($grupos as &$grupo)
	{

		$combobox.='<option value="'.$x.'">'.$grupo->getCod_grupo().'</option>';
		$x=$x+1;
	}
	$combobox.='</select>';
	return($combobox);
}

function generarComboboxProfesores($profesores)
{
	$combobox='
	<select name="SelectedProfIndex">';
	$x=0;
	foreach($profesores as &$profesor)
	{
	
		$combobox.= '<option value="'.$x.'">'.$profesor->getNombre().' '.$profesor->getApellido().' '.$profesor->getCedula(). '</option>';
		$x=$x+1;
	}
	$combobox.='</select>';
	return($combobox);

}

function generarComboboxAsignaturas($asignaturas)
{
	$combobox='
	<select name="selectedAsigIndex">';
	$x=0;
	foreach($asignaturas as &$asignatura)
	{
	
		$combobox.='<option value="'.$x.'">'.$asignatura->getCod_asig().'-'.$asignatura->getNombre().'</option>';
		$x=$x+1;
	}
	$combobox.='</select>';
	return($combobox);
}
function generarCamposDeAsignatura($x)
{
	$campos="";
	for($i=0 ;$i<$x;$i++)
	{
		$campos.='<lable>Dia '.($i+1).':</lable>
		<select name="dia'.$i.'">
			<option value="Lunes">Lunes</option>
			<option value="Martes">Martes</option>
			<option value="Miercoles">Miercoles</option>
			<option value="Jueves">Jueves</option>
			<option value="Viernes">Viernes</option>
			<option value="Sabado">Sabado</option>
		</select>
		<label>Periodo</label><input type="time" name="periodo'.$i.'">
		<label>Salon:</label><input type="text" name = "salon'.$i.'">
		<br>';
	}
	return($campos);
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
	$navbarBrand = "Crear Oferta";
	require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
 
         
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

	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>



