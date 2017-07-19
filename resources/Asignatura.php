<?php
	class Asignatura
	{
		private $cod_asig;
		private $creditos;
		private $nombre;
		private $duracion_bruta;

		function __construct($cod_asig,$nombre,$creditos,$duracion_bruta)
		{
			$this->cod_asig = $cod_asig;
			$this->creditos = $creditos;
			$this->nombre =$nombre;
			$this->duracion_bruta=$duracion_bruta;
		}

		function setCod_asig($cod_asig)
		{
			$this->cod_asig = $cod_asig;
		}
		function getCod_asig()
		{
			return($this->cod_asig);
		}

		function setCreditos($creditos)
		{
			$this->creditos = $creditos;
		}
		function getCreditos()
		{
			return($this->creditos);
		}
		function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}
		function getNombre()
		{
			return($this->nombre);
		}
		function setDuracion_bruta($nombre)
		{
			$this->duracion_bruta = $duracion_bruta;
		}
		function getDuracion_bruta()
		{
			return($this->duracion_bruta);
		}

	}


?>
