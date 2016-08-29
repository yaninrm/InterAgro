<?php
class CuentaC
{
	private $id_Cliente;
	private $id_Comprobante;
	private $fecha_Inicio;
	private $fecha_Vence;
	private $monto_Inicial;
	private $abono;
	private $interes;
	private $saldo_Factura;
	private $saldo_Global;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}