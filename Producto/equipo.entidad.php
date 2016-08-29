<?php
class Producto
{
	private $id;
	private $Nombre;
	private $Precio;
	private $presentacion;
	private $existencia;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}