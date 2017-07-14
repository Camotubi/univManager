<?php
	class Asignatura
	{
		private $cod_asig;
		private $creditos;
		private $nombre;

		function __construct($cod_asig,$creditos,$nombre)
		{
			$this->cod_asig = $cod_asig;
			$this->creditos = $creditos;
			$this->nombre =$nombre;
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

	}


?>
