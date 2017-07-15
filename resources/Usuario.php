<?php
	class Usuario extends Persona
	{
		private $username;
		private $contra;

		function __construct($nombre,$apellido,$telefono,$cedula,$direccion,$correo,$username,$contra)
		{
			parent::__construct($nombre,$apellido,$telefono,$cedula,$direccion,$correo);
			$this->username=$username;
			$this->contra=$contra;
		}

		function setUsername($username)
		{
			$this->username = $username;
		}		
	
		function getUsername()
		{
			return($this->username);
		}
		function setContra($contra)
		{
			$this->contra = $contra;
		}		
	
		function getContra()
		{
			return($this->contra);
		}

	}		
?>
