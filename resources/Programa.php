<?php
	class Programa
	{
		private $cod_plan;
		private $fecha_aprob;
		private $nombre;
		private	$descripccion;
		
		//cod_plan related
		function setCod_plan($newCod_plan)
		{
			$this->cod_plan = $newCod_plan;
		}	
		function getCod_plan()
		{
			return $this->cod_plan;
		}

		//fecha_aprob related

		function setFecha_apro($newFecha_aprob)
		{
			$this->fecha_aprob = $newFecha_aprob;
		}	
		function getFecha_aprob()
		{
			return $this->fecha_aprob;
		}

	}


?>
