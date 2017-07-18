<?php
class Persona
{


	private $nombre;
	private $apellido;
	private $telefono;
	private $cedula;
	private $direccion;
	private $correo;
	private $sexo;
	function __construct($nombre,$apellido,$telefono,$cedula,$direccion,$correo,$sexo)
	{
		$this->nombre=$nombre;
		$this->apellido=$apellido;
		$this->telefono=$telefono;
		$this->cedula=$cedula;
		$this->direccion=$direccion;
		$this->correo=$correo;
		$this->sexo=$sexo;
	}

	function setNombre($nombre)
	{
		$this->nombre=$nombre;
	}
	function getNombre()
	{
		return($this->nombre);
	}
	function setApellido($apellido)
	{
		$this->apellido=$apellido;
	}
	function getApellido()
	{
		return($this->apellido);
	}
	function setTelefono($telefono)
	{
		$this->telefono=$telefono;
	}
	function getTelefono()
	{
		return($this->telefono);
	}
	function getCedula()
	{
		return($this->cedula);
	}
	function setCedula($cedula)
	{
		$this->cedula=$cedula;
	}
	function getDireccion()
	{
		return($this->direccion);
	}
	function setDireccion($direccion)
	{
		$this->direccion=$direccion;
	}
	function getCorreo()
	{
		return($this->correo);
	}
	function getSexo()
	{
		return($this->sexo);
	}
	function setSexo($sexo)
	{
		$this->sexo = $sexo;
	}
}
?>
