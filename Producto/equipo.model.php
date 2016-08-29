<?php
class ProductoModel
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=facturador', 'root', '');
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

			$stm = $this->pdo->prepare("SELECT * FROM producto order by Nombre asc");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$eq = new Producto();

				$eq->__SET('id', $r->id);
				$eq->__SET('Nombre', $r->Nombre);
				$eq->__SET('Precio', $r->Precio);
				$eq->__SET('existencia', $r->cantidadExiste);
				
				

				$result[] = $eq;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($prod)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM producto WHERE id = ?");
			          

			$stm->execute(array($prod));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$eq = new Producto();

			$eq->__SET('id', $r->id);
			$eq->__SET('Nombre', $r->Nombre);
			$eq->__SET('Precio', $r->Precio);
			$eq->__SET('existencia', $r->cantidadExiste);

			return $eq;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($prod)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM producto WHERE id = ?");			          

			$stm->execute(array($prod));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Producto $data)
	{
		try 
		{
			$sql = "UPDATE producto SET 
						Nombre     = ?, 
						Precio        = ?,	
						cantidadExiste =?				
					WHERE id = ?";

			$this->pdo->prepare($sql)->execute(
				array(					 
					$data->__GET('Nombre'), 
					$data->__GET('Precio'),
					$data->__GET('existencia'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Producto $data)
	{
		try 
		{
		$sql = "INSERT INTO producto (Nombre,Precio,cantidadExiste) 
		        VALUES (?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('Nombre'), 
				$data->__GET('Precio'),
				$data->__GET('existencia')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}