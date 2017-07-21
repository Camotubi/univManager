<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require RESOURCES_PATH.'/security.php';
require RESOURCES_PATH.'/Estudiante.php';




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
	$estudiante = new Estudiante($_POST['nombre'],$_POST['apellido'],$_POST['telefono'],$_POST['cedula'],$_POST['direccion'],$_POST['correo'],$_POST['sexo']);
	$stmt=$con->prepare('INSERT INTO  Persona(cedula,nombre,apellido,correo,direccion,sexo,telefono) VALUES(:cedula,:nombre,:apellido,:correo,:direccion,:sexo,:telefono);INSERT INTO Estudiante(cedula)VALUES(:cedula);');
	$stmt->execute(['cedula'=>$estudiante->getCedula(),'nombre'=>$estudiante->getNombre(),'apellido'=>$estudiante->getApellido(),'correo'=>$estudiante->getCorreo(),'direccion'=>$estudiante->getDireccion(),'sexo'=>$estudiante->getSexo(),'telefono'=>$estudiante->getTelefono()]);
	break;

	default:
		$body='<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
Nombre: <input type="text" name="nombre" required autofocus placeholder="Nombre" title="Nombre"><br><br>
       Apellido:
      <input type="text" name="apellido" required autofocus placeholder="Apellido" title="Apellido"><br><br>
      Cedula:
<input type="text" name="cedula" required autofocus" title="Introduzca su nombre aqui"><br><br>
Email:
<input type="text" name="correo" required autofocus  title="Introduzca su nombre aqui"><br><br>
Telefono:
<input type="text" name="telefono" required autofocus  title="Introduzca su nombre aqui"><br><br>
Direccion:
<input type="text" name="direccion" required autofocus  title="Introduzca su nombre aqui"><br><br>
Sexo:
<select name="sexo">
<option value="M">Masculino</option>
<option value="F">Femenino</option>
</select><br><br>
<input type ="hidden" name="accion" value="registrar">
<input type ="submit" class= "btn btn-info btn-fill" value= "Registrar a Estudiante">
</form>
'

;
	break;

}
	/*if(!isset($_POST["tipoRegistro"]))
	{
		echo'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
			echo '<input type="submit" name="tipoRegistro" value="Registro Unico">';
			echo '<input type="submit" name="tipoRegistro" value="Registro Masivo">';	
		echo '</form>';
	}
	else
	{
		if($tipoRegistro=="Registro Unico")
		{
			
				echo'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
echo 'Nombre: <input type="text" name="nombre" required autofocus placeholder="Nombre" title="Nombre"><br><br>
       Apellido:
      <input type="text" name="apellido" required autofocus placeholder="Apellido" title="Apellido"><br><br>
      Cedula:
<input type="text" name="cedula" required autofocus placeholder="Cedula" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="email" required autofocus placeholder="Cedula" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="telefono" required autofocus placeholder="Cedula" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="direccion" required autofocus placeholder="Cedula" title="Introduzca su nombre aqui"><br><br>
<select name="sexo">
<option value="M">Masculino</option>
<option value="F">Femenino</option>
</select>';

					echo '<input type="hidden" name="tipoRegistro" value="Registro Unico">';

					echo'<input type="submit">';
				echo '</form>';
		}
		else
		{
			if($tipoRegistro=="Registro Masivo")
			{
				if(isset($_POST["cantRegistros"]))
				{
							$cantRegistros=$_POST["cantRegistros"];
					if(!isset($_POST["EjecutarRegistroMasivo"]))
					{

					
						echo'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
						echo '<input type="hidden" name="tipoRegistro" value="Registro Masivo">';
							echo'<table>
								<tr>
									<th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Email</th><th>Telefono</th><th>Direccion</th>
								</tr>';
							for($i= 0; $i<$cantRegistros;$i++)
							{
								echo '
								<tr>
									<td>
										<input type=text name="nombre'.$i.'" required>	
									</td>
									<td>
										<input type=text name="apellido'.$i.'" required>	
										
									</td>
									<td>
										<input type=text name="cedula'.$i.'" required>	
										
									</td>
									<td>
										<input type=text name="correo'.$i.'" required>	
										
									</td>
									<td>
										<input type=text name="telefono'.$i.'" required>	
										
									</td>
									<td>
										
										<input type=text name="direccion'.$i.'" required>	
									</td>

									<td>

										<select name="sexo'.$i.'">
										<option value="M">Masculino</option>
										<option value="F">Femenino</option>
										</select>
									</td>
									</tr>';

							}
							echo'</table>';
							echo'<input type="hidden" name="cantRegistros" value='.$cantRegistros.'>';
							echo'<input type="hidden" name="EjecutarRegistroMasivo" value="go" >';
							echo'<input type="submit">'; 

							echo '</form>';
					}
					else
					{
						$estudiante=array();
						for($i=0;$i<$cantRegistros;$i++)
						{
							array_push($estudiante,new Persona($_POST['nombre'.$i],$_POST['apellido'.$i],$_POST['telefono'.$i],$_POST['cedula'.$i],$_POST['direccion'.$i],$_POST['correo'.$i],$_POST['sexo'.$i]));
						}
						
						echo$estudiante[1]->getNombre();	
						try
						{
							$db=$config["db"]["univManager"];
							$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
							for($i =0 ; $i<$cantRegistros;$i++)
							{

								$stmt = $con->prepare('SELECT cedula FROM Persona WHERE cedula = :cedula');
								$stmt->execute(['cedula'=>$estudiante[$i]]->getCedula());
								$row=$stmt->fetch(PDO::FETCH_ASSOC);
								if($row->rowCount()<=0)
								{

									$stmt=$con->prepare('INSERT INTO  Persona(cedula,nombre,apellido,correo,direccion,sexo,telefono) VALUES(:cedula,:nombre,:apellido,:direccion,:sexo,:telefono);INSERT INTO Estudiante(cedula)VALUES(:cedula);');
									$stmt->execute(['cedula'=>$estudiante[$i]->getCedula(),'nombre'=>$estudiante[$i]->getNombre(),'apellido'=>$estudiante[$i]->getApellido(),'correo'=>$estudiante[$i]->getCorreo(),'direccion'=>$estudiante[$i]->getDireccion(),'sexo'=>$estudiante[$i]->getSexo()]);
								}
								else
								{
									$stmt = $con->prepare('SELECT * FROM Persona WHERE cedula = :cedula AND nombre =:nombre AND apellido =:apellido AND direccion = :direccion AND sexo =:sexo AND correo=:correo AND telefono=:telefono');
									$stmt->execute(['cedula'=>$estudiante[$i]->getCedula(),'nombre'=>$estudiante[$i]->getNombre(),'apellido'=>$estudiante[$i]->getApellido(),'correo'=>$estudiante[$i]->getCorreo(),'direccion'=>$estudiante[$i]->getDireccion(),'sexo'=>$estudiante[$i]->getSexo()]);
									$row=$stmt->fetch(PDO::FETCH_ASSOC);
									if($row->roWCount()<=0)
									{
										array_push($personaExistente,$i);
									}
								}
							}
						}catch(PDOException $e)
						{
							$errMessage= "Coneccion Fallida: " ;
						}
						finally
						{
							$con=null;
						}
					}
				}
				else
				{
				echo'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
				echo '<input type="hidden" name="tipoRegistro" value="Registro Masivo">';

						echo '<input type="number" min="1" max ="50" name="cantRegistros">';	
						echo'<input type="submit">';
					echo '</form>';
				}
			}
		}
	}
	*/
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
	$navbarBrand = "Registro de Estudiante";
	require TEMPLATES_PATH.'/navbar.php';
?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                <a href="Estudiante.php" class="btn btn-info btn-fill" style="margin-right: 20px">Atras</a>
          
         
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