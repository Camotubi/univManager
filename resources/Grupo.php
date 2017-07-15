<?php
	class Clase
	{
		private $periodo;
		private $dia;
		private $salon;

		function __construct($perido,$dia,$salon)
		{
			$this->periodo = $periodo;
			$this->dia = $dia;
			$this->salon = $salon;
		}

		function setPeriodo($periodo)
		{
			$this->periodo=$periodo;
		}
		function getPeriodo()
		{
			return($this->periodo);
		}
		function setDia($dia)
		{
			$this->dia=$dia;
		}
		function getDia()
		{
			return($this->dia);
		}
		function setSalon($salon)
		{
			$this->salon=$salon;
		}
		function getSalon()
		{
			return($this->salon);
		}
	}

?>
