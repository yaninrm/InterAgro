<?php
class Cliente
{
	private $id;
	private $Nombre;
	private $RUC;
	private $Direccion;
	private $Agente;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}