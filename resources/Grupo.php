<?php
	class Grupo
	{
		private $cod_grupo;
		private $cod_plan;

		function __construct($cod_grupo,$cod_plan)
		{
			$this->cod_grupo = $cod_grupo;
			$this->cod_plan = $cod_plan;
		}

		function setCod_grupo($cod_grupo)
		{
			$this->cod_grupo=$cod_grupo;
		}
		function getCod_grupo()
		{
			return($this->cod_grupo);
		}
		function setCod_plan($cod_plan)
		{
			$this->cod_plan=$cod_plan;
		}
		function getCod_plan()
		{
			return($this->cod_plan);
		}
	}

?>