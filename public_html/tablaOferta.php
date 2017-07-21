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
	$db=$config["db"]["univManager"];
	$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);

            $stmt=$con->prepare('SELECT DISTINCT a.cod_asig,g.cod_grupo,a.nombre,a.duracion_bruta,pro.id_profesor,CONCAT(per.nombre,\' \',per.apellido ) AS nomprof FROM Asignatura AS a INNER JOIN GrupoProfesorAsignatura as gpa on gpa.cod_asig=a.cod_asig INNER JOIN Grupo as g on g.cod_grupo=gpa.cod_grupo INNER JOIN Profesor as pro on pro.id_profesor = gpa.id_profesor INNER JOIN  Persona as per on per.cedula = pro.cedula');

            $stmt->execute();
           $ofertas = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
           array_push($ofertas,array("cod_asig"=>$row["cod_asig"],"cod_grupo"=>$row["cod_grupo"],"duracion_bruta"=>$row["duracion_bruta"],"nomprof" =>$row["nomprof"],"id_profesor"=>$row["id_profesor"],"nomAsig"=>$row["nombre"]));
        }
if(isset($_POST["accion"]))
{
	$accion=$_POST["accion"];
}

switch($accion)
{
	case "calendario":
		$ofertaI=$_POST["ofertaToCalendario"];
		$nom_asig = $ofertas[$ofertaI]["nomAsig"];
		$cod_asig = $ofertas[$ofertaI]["cod_asig"];
		$cod_grupo = $ofertas[$ofertaI]["cod_grupo"];
		$nomprof=$ofertas[$ofertaI]["nomprof"];
		$id_profesor = $ofertas[$ofertaI]["id_profesor"];
		$duracion_bruta = $ofertas[$ofertaI]["duracion_bruta"];
		$pago=0;
	$form='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
			<input type="hidden" name="accion" value="genTabla">';
	if ($duracion_bruta<=20) {
		$pago=1;
	}
	elseif ($duracion_bruta>20 && $$duracion_bruta=48)
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
			<input type="hidden" name ="ofertaI" value ="'.$ofertaI.'">
			<input type="submit" value="Confirmar">
	</form>';

	$body=$form;
	break;

	case "genTabla":
		$ofertaI=$_POST["ofertaI"];
		$nom_asig = $ofertas[$ofertaI]["nomAsig"];
		$cod_asig = $ofertas[$ofertaI]["cod_asig"];
		$cod_grupo = $ofertas[$ofertaI]["cod_grupo"];
		$nomprof=$ofertas[$ofertaI]["nomprof"];
		$id_profesor = $ofertas[$ofertaI]["id_profesor"];
		$duracion_bruta = $ofertas[$ofertaI]["duracion_bruta"];
		$fpago1 =$_POST["fechaPago1"];
		if(isset($_POST["fechaPago2"]))
		{

		}
		if(isset($_POST["fechaPago3"]))
		{
			
		}
		$fmatri = $_POST["matricula"];
		$fclase =$_POST["Clases"];
		$fRetIncl = $_POST["RetiroInclucion"];
		$fRetFuePer = $_POST["RetiroFueradelPeriodo"];
		$fRetTot = $_POST["retiroTotal"];

	$estudiantesEnElGrupo=array();
			$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT nombre, apellido, e.cedula AS cedula, correo,telefono,direccion,sexo FROM Persona AS p INNER JOIN Estudiante AS e on (e.cedula = p.cedula) INNER JOIN Grupo AS g on (g.cod_grupo = e.cod_grupo) WHERE (g.cod_grupo= :cod_grupo)');
            $stmt->execute(['cod_grupo'=>$grupoSeleccionado->getCod_grupo()]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
                    array_push($estudiantesEnElGrupo, new Estudiante($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo']));
        }
        $body=tablaOferta($nom_asig,$cod_grupo,$nomprof,$duracion_bruta,$fpago1,$fmatri,$fclase,$fRetIncl,$fRetFuePer,$fRetTot,$estudiantesEnElGrupo);
	break;



	break;
	default:

        $body=tablaOfertas($ofertas);
          break;      
    
 }     

function tablaOfertas($ofertas) 
{
    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Asignatura</th><th>Codigo-Grupo<th>Nombre Profesor</th></th><th>Accion</th></thead><tbody>';
    $x=0;
    foreach($ofertas as &$oferta)
    {
        $tabla.='<tr>
            <td>
                '.$oferta["cod_asig"].'
            </td>
            <td>
                '.$oferta["cod_grupo"].'
                
            </td>
           
            <td>
                '.$oferta["nomprof"].'
                
            </td>
            
            <td>
                <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                    <input type="hidden" name="ofertaToCalendario" value="'.$x.'">
                    <input type="hidden" name="accion" value="calendario">
                    <input class="btn btn-info btn-fill" type ="submit" value="Calendario de Oferta">
                </form>
            </td>
            </tr>';
        $x=$x+1;
    }
    $tabla.='</tbody><table>';
    return($tabla);
}


function tablaOferta($nom_asig,$cod_grupo,$nomprof,$duracion_bruta,$fechaPago1,$fmatri,$fclase,$fRetIncl,$fRetFuePer,$fRetTot,$estudiantes)
{

		$tabla ='
<div><h3 style=" text-align: center;"> Universidad Tecnologica de Panamá</h3>
		<h4 style=" text-align: center;">Facultad de Ingenieria de Sistemas Computacionales</h4>
		<h5 style=" text-align: center;">Estudiantes de '.$nom_asig.'</h5>
		<h5 style=" text-align: center;">Grupo'.$cod_grupo.'</h5>
		<table border ="1" style=";
    margin-left: auto;
    margin-right: auto;">
			<tr>
				<th>Actividades</th><th>Fecha</th>
			</tr>
			<tr>
			<td>ASIGNATURA</td><td>'.$nom_asig.'</td>
			<tr>
			<td>Fecha Pago</td><td>'.$fechaPago1.'</td>
			</tr>
			<tr>
			<td>Matricula</td><td>'.$fclase.'</td>
			</tr>
			<tr>
			<td>Duracion Bruta<td>'.$duracion_bruta.'</td>
			</tr>
			<tr>
			<td>Retiro / Inclusion<td>'.$fRetIncl.'</td>
			</tr>
			<tr>
			<td>Retiro Fuera del Periodo<td>'.$fRetFuePer.'</td>
			</tr>
			<tr>
			<td>Retiro Total<td>'.$fRetTot.'</td>
			</tr>				
			<tr>
			<td>Sitio de Matricula<td> http://matricula.utp.ac.pa</td>
			</tr>
			
			</tr>';
		
		$tabla.='</table>
		<p style=" text-align: center;">Profesor:'.$nomprof.'<p><br> <br></div>';
$tabla .='
		<div><h3 style=" text-align: center;"> Universidad Tecnologica de Panamá</h3>
		<h4 style=" text-align: center;">Facultad de Ingenieria de Sistemas Computacionales</h4>
		<h5 style=" text-align: center;">Estudiantes de '.$nom_asig.'</h5>
		<h5 style=" text-align: center;">Grupo'.$cod_grupo.'</h5>
		<table border ="1" style=";
    margin-left: auto;
    margin-right: auto;">
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
			
			</tr>';
		}
		$tabla.='</table>
		<p style=" text-align: center;">Profesor:'.$nomprof.'<p><br> <br></div>';
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

