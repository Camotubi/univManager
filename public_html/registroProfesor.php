<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/security.php';
require RESOURCES_PATH.'/Persona.php';
require RESOURCES_PATH.'/Profesor.php';




$accion="default";
if(isset($_POST["accion"]))
{
	$accion=$_POST["accion"];
}
switch ($accion)
{
	case "registrar":
	$db=$config["db"]["univManager"];
	 $con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
	$profesor = new Profesor($_POST['nombre'],$_POST['apellido'],$_POST['telefono'],$_POST['cedula'],$_POST['direccion'],$_POST['correo'],$_POST['sexo'],$_POST['salario'],0);
	$stmt=$con->prepare('INSERT INTO  Persona(cedula,nombre,apellido,correo,direccion,sexo,telefono) VALUES(:cedula,:nombre,:apellido,:correo,:direccion,:sexo,:telefono);INSERT INTO Profesor(cedula,salario)VALUES(:cedula,:salario);');
	$stmt->execute(['cedula'=>$profesor->getCedula(),'nombre'=>$profesor->getNombre(),'apellido'=>$profesor->getApellido(),'correo'=>$profesor->getCorreo(),'direccion'=>$profesor->getDireccion(),'sexo'=>$profesor->getSexo(),'telefono'=>$profesor->getTelefono(), 'salario'=>$profesor->salario]);
	header("Location: Profesores.php");
	break;

	default:
		$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
Nombre: <input type="text" name="nombre" required autofocus placeholder="Nombre" title="Nombre"><br><br>
       Apellido:
      <input type="text" name="apellido" required autofocus placeholder="Apellido" title="Apellido"><br><br>
      Cedula:
<input type="text" name="cedula" required autofocus" ><br><br>
Email:
<input type="text" name="correo" required autofocus  ><br><br>
Telefono:
<input type="text" name="telefono" required autofocus  ><br><br>
Direccion:
<input type="text" name="direccion" required autofocus  ><br><br>
Salario:
<input type="number" name="salario" required autofocus ><br><br>
Sexo:
<select name="sexo">
<option value="M">Masculino</option>
<option value="F">Femenino</option>
</select><br><br>
<input type ="hidden" name="accion" value="registrar">
<input type ="submit" class= "btn btn-info btn-fill" value= "Registrar a Profesor">
</form>
'

;
	break;

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
	$navbarBrand = "Registro de Profesor";
	require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Profesores.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          
         
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

	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>