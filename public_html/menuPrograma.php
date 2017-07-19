<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';
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
	$navbarBrand = "Programas";
	require TEMPLATES_PATH.'/navbar.php';
?>
	<ul>
		<li>
		<a href="crearPrograma.php">Crear Programa</a>
		</li>
		<li>
			<a href ="EditorPrograma.php">Editar Programa</a>
		</li>

	</ul>
	<?php require TEMPLATES_PATH.'/footer.php'; ?>	
</body>
</html>
