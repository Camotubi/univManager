<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Grupo.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';
$gruposDisponibles=array();
$body="";
$accion="normal";
$message="";
if(isset($_POST["accion"]))
{
    $accion = $_POST["accion"];
}
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
                
      if(isset($_POST["accion"])) 
      {
      	
      	$accion = $_POST["accion"];
      	$grupoToModify=$_POST["grupoToModify"];
      	switch($accion)
      	{
      		case "ModificarGrupo":
      			$message='paseporisdfsdfq';
      			$_SESSION["selectedGrupo"]=$gruposDisponibles[intval($grupoToModify)];
      			header("Location: modificarGrupo.php");
      		break;
      	}
      }     

function tablaGrupo($gruposArr) 
{
    $tabla='<table class="table table-hover table-striped"><thead><th>Codigo-Grupo</th><th>Codigo-plan</th><th>Accion</th></thead><tbody>';
    $x=0;
    foreach($gruposArr as &$grupo)
    {
        $tabla.='<tr>
            <td>
                '.$grupo->getCod_grupo().'
            </td>
            <td>
                '.$grupo->getCod_plan().'
                
            </td>
            
            <td>
                <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                    <input type="hidden" name="grupoToModify" value="'.$x.'">
                    <input type="hidden" name="accion" value="ModificarGrupo">
                    <input class="btn btn-info btn-fill" type ="submit" value="Modificar Grupo">
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
	$navbarBrand = "Grupos";
	require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Oferta.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          <a href="crearGrupo.php" class="btn btn-info btn-fill" style="margin-right: 20px">Crear</a>
         
                </div>
                <br> 
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                            
                            
                                
                                    <?php echo tablaGrupo($gruposDisponibles); 
                                    ?>
                                

                            </div>
                    </div>


                </div>
            </div>
        </div>

	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>
