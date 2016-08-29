<?php
require_once 'equipo.entidad.php';
require_once 'equipo.model.php';


$c=mysql_connect("127.0.0.1","root",'123456');

mysql_select_db("facturador");
$prod=mysql_query("SELECT * FROM producto");
$prese=mysql_query("SELECT * FROM PRESENTACION");

// Logica
$eq = new Detalle();
$model = new DetalleModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$eq->__SET('detalle_id',       $_REQUEST['detalle_id']);
			$eq->__SET('comprobante_id',     $_REQUEST['comprobante_id']);
			$eq->__SET('producto_id',        $_REQUEST['producto_id']);          
            $eq->__SET('presenta',        $_REQUEST['presenta']);
            $eq->__SET('cantidad',        $_REQUEST['cantidad']);
            $eq->__SET('precioUnitario',      $_REQUEST['precioU']);
            $eq->__SET('descuento',        $_REQUEST['descuento']);
            $eq->__SET('total',        $_REQUEST['precioU']);

           
			

			$model->Actualizar($eq);
			header('Location: index.php');
			break;

		case 'registrar':
			$eq->__SET('detalle_id',       $_REQUEST['detalle_id']);
            $eq->__SET('comprobante_id',     $_REQUEST['comprobante_id']);
            $eq->__SET('producto_id',        $_REQUEST['producto_id']);          
            $eq->__SET('presenta',        $_REQUEST['presenta']);
            $eq->__SET('cantidad',        $_REQUEST['cantidad']);
            $eq->__SET('precioUnitario',      $_REQUEST['precioU']);
            $eq->__SET('descuento',        $_REQUEST['descuento']);
            $eq->__SET('total',        $_REQUEST['precioU']-(($_REQUEST['descuento']/100)*$_REQUEST['precioU']));
            

			$model->Registrar($eq);
			header('Location: index.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['detalle_id']);
			header('Location: index.php');
			break;

		case 'editar':
			$eq = $model->Obtener($_REQUEST['detalle_id']);
			break;
	}
}
?>

<!DOCTYPE html>
<html lang="ES">
	<head>
        <meta charset="utf-8">
		<title>DETALLE DE FACTURAS</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">
        <h1>DETALLE DE FACTURAS</h1>

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $eq->detalle_id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="detalle_id" value="<?php echo $eq->__GET('detalle_id'); ?>" />
                    
                    <table style="width:500px;">
                        <tr>
                            <th style="text-align:left;">Número de Factura</th>
                            <td><input type="text" name="comprobante_id"  value="<?php echo $eq->__GET('comprobante_id'); ?>" width:100%; /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Producto</th>
                            <td>
                            <select  name="producto_id" style="width:100%;">
                                <?php 

                                while($row=mysql_fetch_array($prod)){ ?>
                                    <option  value="<?php echo $row[0]; ?>"> <?php echo $row[1];?></option> 
                                <?php } ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Presentación</th>
                            <td>
                                <select  name="presenta" style="width:100%;">
                                <?php 

                                while($row=mysql_fetch_array($prese)){ ?>
                                    <option  value="<?php echo $row[0]; ?>"> <?php echo $row[1];?></option> 
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Cantidad</th>
                            <td><input type="text"  name="cantidad" value="<?php echo $eq->__GET('cantidad'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Precio Unitario</th>
                            <td><input type="text" name="precioU" value="<?php echo $eq->__GET('precioUnitario'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Descuento</th>
                            <td><input type="text" name="descuento" value="<?php echo $eq->__GET('descuento'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal" style="width:1000px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">factura</th>
                            <th style="text-align:left;">producto</th>
                            <th style="text-align:left;">presentación</th>
                            <th style="text-align:left;">cantidad</th>
                            <th style="text-align:left;">precio</th>
                            <th style="text-align:left;">descuento</th>
                            <th style="text-align:left;">total</th>

                        </tr>
                    </thead>
                   
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('comprobante_id'); ?></td>
                            <td><?php echo $r->__GET('producto_id'); ?></td>
                            <td><?php echo $r->__GET('presenta'); ?></td>
                            <td><?php echo $r->__GET('cantidad'); ?></td>
                            <td><?php echo $r->__GET('precioUnitario'); ?></td>
                            <td><?php echo $r->__GET('descuento'); ?></td>
                            <td><?php echo $r->__GET('total'); ?></td>
                            
                            
                            <td>
                                <a href="?action=editar&detalle_id=<?php echo $r->detalle_id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&detalle_id=<?php echo $r->detalle_id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                   
                </table>     
              
            </div>
        </div>

    </body>
</html>