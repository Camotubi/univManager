<!DOCTYPE html>

<?php
	include '../resources/config.php';
	$db=$config['db']['univManager'];
	$username=$_POST["Usuario"];
	$contra=$_POST["Passwod"];

	if($username != null)
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
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" media="all" >
  <link rel="stylesheet" type="text/css" href="assets/css/login.css" media="all" >
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  </script>
</head>
<body>
<div id="contenido">
  <div id="header">
    <div class="imgcuadro"><img src="assets/img/utp.png" alt="UTP"></div>
    <div  class="imgcuadro">
      <h1>Sistema de Oferta Académica</h1>
      <h3>Matrícula de Postgrado</h3>
    </div>
    <div class="imgcuadro"><img src="assets/img/fisc.png" alt="FISC"></div>
  </div>
  <div class="login-form">
    <!-- <h2>Login</h2> -->
	 <form method ="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">    
 <div class="form-group ">
       <!-- Usuario -->
       <input type="text" class="form-control" placeholder="Usuario" id="Usuario" name="Usuario">
       <i class="fa fa-user"></i>
     </div>
     <div class="form-group log-status">
       <!-- Passwod -->
       <input type="password" class="form-control" placeholder="Contraseña" id="Passwod" name="Passwod">
<?php if($errMessage !=null)
{
	echo "<p>".$errMessage."</p>";
}?>
       <i class="fa fa-lock"></i>
     </div>
      <span class="alert">Error en los datos colocados.</span>
   <input class="log-btn" type="submit" value="Iniciar Sesion"> 
</form>
  </div>
</div>
<script class="cssdeck" src="assets/js/jquery.min.js"></script>
</body>
</html>

