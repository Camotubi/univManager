<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Persona.php';
require RESOURCES_PATH.'/Profesor.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';

$profesors=array();
$db=$config["db"]["univManager"];
            $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
            $stmt=$con->prepare('SELECT * FROM Profesor e INNER JOIN Persona p on (p.cedula=e.cedula)');
            $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($profesors))
                {
                    array_push($profesors, new Profesor($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo'],$row["salario"],$row["id_profesor"]));

                    
                }
                else
                {   
                    $profesors = array( new Profesor($row['nombre'],$row['apellido'],$row['telefono'],$row['cedula'],$row['direccion'],$row['correo'],$row['sexo'],$row["salario"],$row["id_profesor"]));
                    
                }
        }
                
      if(isset($_POST["accion"])) 
      {
        
        $accion = $_POST["accion"];
        $rowToRemove=$_POST["rowToRemove"];
        switch($accion)
        {
            case "removeRow":

                header("Location: modificarPrograma.php");
            break;
        }
      }     

function generarTabla($studentsArr)
{
    $tabla='<table class="table table-hover table-striped"><tr><th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Correo</th><th>Telefono</th><th>Direccion</th><th>Sexo</th><th>Accion</th>';
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
                    <input type ="submit" value="Remover Profesor">
                </form>
            </td>
            </tr>';
        $x=$x+1;
    }
    $tabla.='</table>';
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
    $navbarBrand = "Profesors";
    require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          <a href="registroProfesor.php" class="btn btn-info btn-fill" style="margin-right: 20px">Crear</a>
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
                                
                                    <?php echo generarTabla($profesors); 
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

