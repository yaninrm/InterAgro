<?php
class Detalle
{
	private $detalle_id;
	private $comprobante_id;
	private $producto_id;
	private $presenta;
	private $cantidad;
	private $precioUnitario;
	private $descuento;
	private $total;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}