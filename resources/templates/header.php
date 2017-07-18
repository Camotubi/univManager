<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico"> <!-- Icono Favicon de la página    -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Sistema de Matrícula de Postgrado</title> <!-- Título de página     -->

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    
    <link href="assets/css/style.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
    
<body>

    <div class="sidebar" data-color="purple">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    Sistema de Oferta Académica
                </a>
                <!--

        CAMBIAR LA DIRECCIÓN DE LA IMAGEN SIGUIENTE

    -->
                <img id="logo" src="assets/img/logofisc.png" alt="Logo Fisc">
                <a id="postgtext">
                    Departamento de Postgrado
                </a>
            </div>

            <ul class="nav">
               <!-- <li class="active" id="1"> Solo funciona poniendo toda esta seccion en cada una de las pags -->
                <li>
                    <a href="Oferta.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Oferta Académica</p>
                    </a>
                </li>
                <li>
                    <a href="Programas.php">
                        <i class="pe-7s-note2"></i>
                        <p>Programas</p>
                    </a>
                </li>
                <li>
                    <a href="Asignaturas.php">
                        <i class="pe-7s-science"></i>
                        <p>Asignaturas</p>
                    </a>
                </li>
                <li>
                    <a href="Profesores.php">
                        <i class="pe-7s-id"></i>
                        <p>Profesores</p>
                    </a>
                </li>
                <li>
                    <a href="Grupos.php">
                        <i class="pe-7s-users"></i>
                        <p>Grupos</p>
                    </a>
                </li>
                <li>
                    <a href="Estudiantes.php">
                        <i class="pe-7s-user"></i>
                        <p>Estudiantes</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>


</body>

     <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js"></script>

	<script src="assets/js/move.js"></script>

</html>
