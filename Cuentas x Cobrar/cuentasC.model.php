<?php
class CuentasCModel
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=cuentaC', 'root', '');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		        
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM cuentas_cobrar");
			$stm->execute();

//FETCH_OBJ devuelve un objeto anónimo con nombres de propiedades que se corresponden a los nombres de las columnas devueltas en el conjunto de resultados.
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)  
			{
				$eq = new CuentasC();

				$eq->__SET('id_Cliente', $r->id_Cliente);
				$eq->__SET('id_Comprobante', $r->id_Comprobante);
				$eq->__SET('fecha_Inicio', $r->fecha_Inicio);
				$eq->__SET('fecha_Vence', $r->fecha_Vence);
				$eq->__SET('monto_Inicial', $r->monto_Inicial);
				$eq->__SET('abono', $r->abono);
				$eq->__SET('intereses', $r->intereses);
				$eq->__SET('saldo_Factura', $r->saldo_Factura);
				$eq->__SET('saldo_Global', $r->saldo_Global);

				

				$result[] = $eq;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($idCliente,$idCompro)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM cuentas_cobrar WHERE id_Cliente = ? and id_Comprobante= ?");
			          

			$stm->execute(array($idCliente,$idCompro));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$eq = new CuentasC();

			$eq->__SET('id_Cliente', $r->id_Cliente);
			$eq->__SET('id_Comprobante', $r->id_Comprobante);
			$eq->__SET('fecha_Inicio', $r->fecha_Inicio);
			$eq->__SET('fecha_Vence', $r->fecha_Vence);
			$eq->__SET('monto_Inicial', $r->monto_Inicial);
			$eq->__SET('abono', $r->abono);
			$eq->__SET('intereses', $r->intereses);
			$eq->__SET('saldo_Factura', $r->saldo_Factura);
			$eq->__SET('saldo_Global', $r->saldo_Global);

			return $eq;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idCliente,$idCompro)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM cuentas_cobrar WHERE id_Cliente = ? and id_Comprobante= ?");			          

			$stm->execute(array($idCliente,$idCompro));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(CuentasC $data)
	{
		try 
		{
			$sql = "UPDATE cuentas_cobrar SET 
						fecha_Inicio  = ?,
						fecha_Vence = ?,
						monto_Inicial = ?,
						abono = ?,
						intereses = ?,
						saldo_Factura = ?,
						saldo_Global = ?
					WHERE id_Cliente = ? and id_Comprobante = ?";

			$this->pdo->prepare($sql)->execute(
				array(
					$data->__GET('fecha_Inicio'),
					$data->__GET('fecha_Vence'), 
					$data->__GET('monto_Inicial'), 
					$data->__GET('abono'), 
					$data->__GET('intereses'), 
					$data->__GET('saldo_Factura'), 
					$data->__GET('saldo_Global'),
					$data->__GET('id_Cliente'),
					$data->__GET('id_Comprobante')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(CuentasC $data)
	{
		try 
		{
		$sql = "INSERT INTO cuentas_cobrar (id_Cliente,id_Comprobante,fecha_Inicio,fecha_Vence,monto_Inicial,abono,intereses,saldo_Factura,saldo_Global) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('id_Cliente'), 
				$data->__GET('id_Comprobante'),
				$data->__GET('fecha_Inicio'),
				$data->__GET('fecha_Vence'),
				$data->__GET('monto_Inicial'),
				$data->__GET('abono'),
				$data->__GET('intereses'),
				$data->__GET('saldo_Factura'),
				$data->__GET('saldo_Global')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}