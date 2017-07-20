
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Asignatura.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT * FROM Asignatura');
            $stmt->execute();
        $asignaturasDisponibles=array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($asignaturasDisponibles))
                {
                    array_push($asignaturasDisponibles, new Asignatura($row['cod_asig'],$row['nombre'],$row['creditos'],$row['duracion_bruta']));

                    $_SESSION["asignaturasDisponibles"]=$asignaturasDisponibles;
                }
                else
                {
                    $asignaturasDisponibles = array(new Asignatura($row['cod_asig'],$row['nombre'],$row['creditos'],$row['duracion_bruta']));
                    $_SESSION["asignaturasDisponibles"]=$asignaturasDisponibles;
                }
        }
                
            

function tablaAsignaturas($asignaturasArr) 
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
                <form method="post" action="modificarAsignatura.php">
                    <input type="hidden" name="asigToModify" value="'.$x.'">
                    <input type="hidden" name="accion" value="Modificar Asignatura">
                    <input class="btn btn-info btn-fill" type ="submit" value="Modificar Asignatura">
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
    $navbarBrand = "Asignaturas";
    require TEMPLATES_PATH.'/navbar.php';
?>

    


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          <a href="agregarAsignatura.php" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Agregar</a>
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
                                <table >
                                    <?php echo tablaAsignaturas($asignaturasDisponibles); ?>
                                </table>

                            </div>
                    </div>


                </div>
            </div>
        </div>



       
  


    </div>
 <?php require TEMPLATES_PATH.'/footer.php'; ?>   
 </body>
 </html>