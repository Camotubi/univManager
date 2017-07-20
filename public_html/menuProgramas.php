<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT * FROM Programa');
            $stmt->execute();
        $programasDisponibles=array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($programasDisponibles))
                {
                    array_push($programasDisponibles, new Programa($row['cod_plan'],$row['nombre'],$row['fecha_apro'],$row['descripccion']));

                    $_SESSION["programasDisponibles"]=$programasDisponibles;
                }
                else
                {
                    $programasDisponibles = array(new Programa($row['cod_plan'],$row['nombre'],$row['fecha_apro'],$row['descripccion']));
                    $_SESSION["programasDisponibles"]=$programasDisponibles;
                }
        }
                
            

function tablaProgramas($programasArr) 
{
    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Plan</th><th>Nombre</th><th>Descripccion</th><th>Fecha de Aprobacion</th><th>Accion</th></thead><tbody>';
    $x=0;
    foreach($programasArr as &$programa)
    {
        $tabla.='<tr>
            <td>
                '.$programa->getCod_plan().'
            </td>
            <td>
                '.$programa->getNombre().'
                
            </td>
            <td>
                '.$programa->getFecha_aprob().'
                
            </td>
            <td>
                '.$programa->getDescripccion().'
                
            </td>
            
            <td>
                <form method="post" action="modificarPrograma.php">
                    <input type="hidden" name="progToModify" value="'.$x.'">
                    <input type="hidden" name="accion" value="Modificar Programa">
                    <input class="btn btn-info btn-fill" type ="submit" value="Modificar Programa">
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
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          <a href="crearPrograma.php" class="btn btn-info btn-fill" style="margin-right: 20px">Crear</a>
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
                                <table >
                                    <?php echo tablaProgramas($programasDisponibles); ?>
                                </table>

                            </div>
                    </div>


                </div>
            </div>
        </div>

	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>
