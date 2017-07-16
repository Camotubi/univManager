<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require '../resources/security.php';
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
<input type="text" name="direccion" required autofocus placeholder="Cedula del Propietario" title="Introduzca su nombre aqui"><br><br>';
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
					if(!isset($_POST["EjecutarRegistroMasivo"]))
					{

					
						echo'<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
						echo '<input type="hidden" name="tipoRegistro" value="Registro Masivo">';
							$cantRegistros=$_POST["cantRegistros"];
							echo'<table>
								<tr>
									<th>Nombre</th><th>Apellido</th><th>Cedula</th><th>Email</th><th>Telefono</th><th>Direccion</th>
								</tr>';
							for($i= 1; $i<=$cantRegistros;$i++)
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
										<input type=text name="email'.$i.'" required>	
										
									</td>
									<td>
										<input type=text name="telefono'.$i.'" required>	
										
									</td>
									<td>
										
										<input type=text name="direccion'.$i.'" required>	
									</td>
								</tr>';

							}
							echo'</table>';
							echo'<input type="hidden" name="cantRegistros" value='.$cantRegistros.'>';
							echo'<input type="hidden" >';
							echo'<input type="submit",name="EjecutarRegistroMasivo">'; 

							echo '</form>';
					}
					else
					{

						try
						{
							$con = new PDO('mysql:host='.$db['host'].';'.'dbname='.$db['dbname'],$db['username'],$db['password']);
							$stmt = $con->prepare('SELECT username, contra FROM Usuario WHERE username = :username AND contra = :contra');

							$stmt->execute(['username'=>$username,'contra'=>$contra]);
							
							$user=$stmt->fetch(PDO::FETCH_ASSOC);
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
<?php


?>
