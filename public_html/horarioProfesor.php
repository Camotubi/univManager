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
  $accion=$_POST["accion"];
}
           
        switch("$accion")
        {
          case "mostrarHorario":
          $db=$config["db"]["univManager"];
          $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
          $stmt=$con->prepare('SELECT gpa.dia,gpa.periodo,gpa.salon,a.nombre,per.nombre as nomprof ,gpa.codhorario, per.apellido  FROM Asignatura AS a INNER JOIN GrupoProfesorAsignatura as gpa on gpa.cod_asig=a.cod_asig INNER JOIN Grupo as g on g.cod_grupo=gpa.cod_grupo INNER JOIN Profesor as pro on pro.id_profesor = gpa.id_profesor INNER JOIN Persona as per on per.cedula = pro.cedula WHERE pro.cedula = :cedula ORDER BY periodo');
         
            $stmt->execute(['cedula'=>$_POST["cedula"]]);
          $clase =array();
          while($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
            array_push($clase,array("nombre"=>$row["nombre"],"salon"=>$row["salon"],"periodo"=>$row["periodo"],"dia"=>$row["dia"],"codhorario"=>$row["codhorario"]));
            $nombrePersona= $row["nomprof"].' '.$row["apellido"];
          }
          $body=tablaHorario($clase,$nombrePersona);
          break;
          default:
          $body=formInicial();
          break;
        }
                
    	
      	
      	 

function tablaHorario($clases, $nombrePer) 
{
   $lunes=array();
    $martes=array();
    $miercoles=array();
    $jueves=array();
    $viernes=array();
    $sabado=array();

  foreach($clases as &$clase)
  {
   
    switch($clase["dia"])
    {
      case 'Lunes':
        array_push($lunes,$clase);
      break;
      case 'Martes':
      array_push($martes,$clase);
      break;
      case 'Miercoles':
      array_push($miercoles,$clase);
      break;
      case 'Jueves':
      array_push($jueves,$clase);
      break;
      case 'Viernes':
      array_push($viernes,$clase);
      break;
      case 'Sabado':
      array_push($sabado,$clase);
      break;
    }
  }
  
 
    $form='<table border=1 >
            <thead>
              <th>
                Lunes
              </th>
              <th>
                Martes
              </th>
              <th>
                Miercoles
              </th>
              <th>
                Jueves
              </th>
              <th>
                Viernes
              </th>
              <th>
                Sabado
              </th>
            </thead>
            <tr><td padding="2">';
            for($i =0 ; $i<count($lunes);$i=$i+1)
            {
              $tmp=$lunes[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td><td padding="2">';
             for($i =0 ; $i<count($martes);$i=$i+1)
            {
              $tmp=$martes[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td><td padding="2">';
             for($i =0 ; $i<count($miercoles);$i=$i+1)
            {
              $tmp=$miercoles[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td><td padding="2">';
             for($i =0 ; $i<count($jueves);$i=$i+1)
            {
              $tmp=$jueves[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td><td padding="2">';
             for($i =0 ; $i<count($viernes);$i=$i+1)
            {
              $tmp=$viernes[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td><td padding="2">';
             for($i =0 ; $i<count($sabado);$i=$i+1)
            {
              $tmp=$sabado[$i];
              $form.=$tmp["periodo"].':<br>'.$tmp["nombre"].'<br>Salon: '.$tmp["salon"].'<br>Codigo Horario:'.$tmp["codhorario"].'<br>';
            }
            $form.='</td></tr></table>
            <br>Nombre del Profesor: '. $nombrePer;


return($form);     
}


function formInicial()
{
  $form='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                    <input type="hidden" name="accion" value="mostrarHorario">
                    Cedula: <input type="text" name = "cedula">
                    <input class="btn btn-info btn-fill" type ="submit" value=" Mostrar Horario">
                </form>';
                return($form);
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
	$navbarBrand = "Horario Profesor";
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
                            
                            
                                
                                    <?php echo $body;; 
                                    
                                    ?>
                                

                            </div>
                    </div>


                </div>
            </div>
        </div>

	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>
