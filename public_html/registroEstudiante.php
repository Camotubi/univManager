<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../resources/config.php";
require "../resources/security.php";
require "../resources/Persona.php";
if(isset($_POST["tipoRegistro"])){$tipoRegistro = $_POST["tipoRegistro"];}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registro de Estudiantes</title>
		<meta charset="UTF-8">
	</head>
<body>
<?php
	if(!isset($_POST["tipoRegistro"]))
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
echo 'Nombre: <input type="text" name="nombre" required autofocus placeholder="Nombre del Propietario" title="Nombre"><br><br>
       Apellido:
      <input type="text" name="apellido" required autofocus placeholder="Apellido del Propietario" title="Apellido"><br><br>
      Cedula:
<input type="text" name="cedula" required autofocus placeholder="Cedula del Propietario" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="email" required autofocus placeholder="Cedula del Propietario" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="telefono" required autofocus placeholder="Cedula del Propietario" title="Introduzca su nombre aqui"><br><br>
<input type="text" name="direccion" required autofocus placeholder="Cedula del Propietario" title="Introduzca su nombre aqui"><br><br>
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

									}
								}
							}
							if($user['username']==$username && $user['contra']=$contra)
							{
								session_start();
								$_SESSION["username"]=$username;
								header("Location: Oferta.php" );
							}
							else
							{
								$errMessage= 'Usuario/contraseña incorrecta';
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
?>

</body>
</html>
<?php


?>
