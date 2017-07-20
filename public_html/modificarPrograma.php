<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';
$selectedPrograma = null;
if(isset($_SESSION["selectedPrograma"]))
{
	$selectedPrograma = $_SESSION["selectedPrograma"];
}
else
{
	header('Location: menuProgramas.php');
}
?>