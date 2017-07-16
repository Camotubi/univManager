<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" media="all" >
  <link rel="stylesheet" type="text/css" href="assets/css/login.css" media="all" >
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/login.js"></script>
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
     <div class="form-group ">
       <!-- Usuario -->
       <input type="text" class="form-control" placeholder="Usuario" id="Usuario" name="Usuario">
       <i class="fa fa-user"></i>
     </div>
     <div class="form-group log-status">
       <!-- Passwod -->
       <input type="password" class="form-control" placeholder="Contraseña" id="Passwod" name="Passwod">
       <i class="fa fa-lock"></i>
     </div>
      <span class="alert">Error en los datos colocados.</span>
      <!-- button -->                                       <!-- Borrar el tag <a> -->
     <button type="button" class="log-btn" name="button" ><a href="Oferta.php">Acceder</a></button>
  </div>
</div>
<script class="cssdeck" src="assets/js/jquery.min.js"></script>
</body>
</html>
