<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Asignatura.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';


if(isset($_POST["accion"]))
{
    $asignaturaSeleccionada=$_SESSION["asignaturasDisponibles"][intval($_POST["asigToModify"])];
    $accion = $_POST["accion"];
    $db=$config["db"]["univManager"];
    switch($accion)
    {
        case "Actualizar":
            $newNombre = $_POST["newNombre"];
            $newCreditos = $_POST["newCreditos"];
            $newDuracion_bruta = $_POST["newDuracion_bruta"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('UPDATE Asignatura SET nombre=:newNombre, creditos=:newCreditos,duracion_bruta =:newDuracion_bruta WHERE cod_asig = :cod_asig');
            $stmt->execute(['newNombre'=>$newNombre,'newCreditos'=>$newCreditos,'newDuracion_bruta'=>$newDuracion_bruta, 'cod_asig'=>$asignaturaSeleccionada->getCod_asig()]);
            $con=null;
            header("Location: Asignaturas.php");
            break;
        

        case "Eliminar":
    
        $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('DELETE FROM Asignatura WHERE cod_asig = :cod_asig');
            $stmt->execute(['cod_asig'=>$asignaturaSeleccionada->getCod_asig()]);
            $con=null;
            header("Location: Asignaturas.php");
        break;
        case "Modificar Asignatura":
        if(isset($_POST["asigToModify"]))
        {
            
         }  
        else
        {
            header("Location: Asignaturas.php");
        }
        break;
    }
}                
            

function infoAsignatura($asignatura) 
{
    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Asignatura</th><th>Nombre</th><th>Creditos</th><th>Duracion Bruta</th></thead><tbody>';
        $tabla.='<tr>
            <td>
                '.$asignatura->getCod_asig().'
            </td>
            <td>
                <input type="text", name="newNombre" value="'.$asignatura->getNombre().'">
                
            </td>
            <td>
                 <input type="text", name="newCreditos" value="'.$asignatura->getCreditos().'">
                
            </td>
            <td>
                <input type="text", name="newDuracion_bruta" value="'.$asignatura->getDuracion_bruta().'">
                
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
                <a href="Asignaturas.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          <a href="agregarAsignatura.php" class="btn btn-info btn-fill" style="margin-right: 20px">Agregar</a>

          
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            <?php var_dump($_POST["accion"]);
                            echo isset($_POST["accion"]);?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                          
                                    <?php echo infoAsignatura($asignaturaSeleccionada); ?>
                                    <input type="submit" class="btn btn-info btn-fill" name="accion" style="margin-right: 20px" value ="Actualizar">
                                    
                                    <input type="submit" class="btn btn-info btn-fill" style="margin-right: 20px" name="accion"  value ="Eliminar">
</form>                                

                            </div>
                    </div>
  

                </div>
            </div>
        </div>



       
  


    </div>
 <?php require TEMPLATES_PATH.'/footer.php'; ?>   
 </body>
 </html>