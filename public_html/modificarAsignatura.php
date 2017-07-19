<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Asignatura.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

if(isset($_POST["asigToModify"]))
{
    $asignaturaSeleccionada=$_SESSION["asignaturasDisponibles"][intval($_POST["asigToModify"])];
 }  
else
{
    header("Location: Asignaturas.php");
}

                
            

function infoAsignatura($asignatura) 
{
    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Asignatura</th><th>Nombre</th><th>Creditos</th><th>Duracion Bruta</th></thead><tbody>';
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
    
            </tr>';
    
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
          <a href="Asignaturas/Agregar.php" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Agregar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Modificar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Eliminar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Buscar</a>
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            

                                <table >
                                    <?php echo infoAsignatura($asignaturaSeleccionada); ?>
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