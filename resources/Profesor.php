<?php
	class Profesor extends Persona {
		public  $salario;
		public  $id_profesor;

		function __CONSTRUCT($nombre,$apellido,$telefono,$cedula,$direccion,$correo,$sexo,$salario,$id_profesor)
		{
			parent::__CONSTRUCT($nombre,$apellido,$telefono,$cedula,$direccion,$correo,$sexo,$id_profesor);
			$this->salario = $salario;
			$this->id_profesor = $id_profesor;
		}

	
	}


?>
