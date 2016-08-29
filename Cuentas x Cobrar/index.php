<?php
require_once 'cuentasC.entidad.php';
require_once 'cuentasC.model.php';


$c=mysql_connect("127.0.0.1","root",'');
mysql_select_db("facturador");

$orden1="SELECT * FROM cliente ";
$paquete1=mysql_query($orden1);




// Logica
$eq = new CuentaC();
$model = new CuentasCModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$eq->__SET('id_Cliente',       $_REQUEST['id_Cliente']);
			$eq->__SET('id_Comprobante',     $_REQUEST['id_Comprobante']);
			$eq->__SET('fecha_Inicio',        $_REQUEST['fecha_Inicio']);
            $eq->__SET('fecha_Vence',  $_REQUEST['fecha_Vence']);
            $eq->__SET('monto_Inicio',  $_REQUEST['monto_Inicio']);
            $eq->__SET('abono',  $_REQUEST['abono']);
            $eq->__SET('intereses',  $_REQUEST['intereses']);
            $eq->__SET('saldo_Factura',  $_REQUEST['saldo_Factura']);
            $eq->__SET('saldo_Global',  $_REQUEST['saldo_Global']);
			

			$model->Actualizar($eq);
			header('Location: index.php');
			break;

		case 'registrar':
			$eq->__SET('id_Cliente',       $_REQUEST['id_Cliente']);
            $eq->__SET('id_Comprobante',     $_REQUEST['id_Comprobante']);
            $eq->__SET('fecha_Inicio',        $_REQUEST['fecha_Inicio']);
            $eq->__SET('fecha_Vence',  $_REQUEST['fecha_Vence']);
            $eq->__SET('monto_Inicio',  $_REQUEST['monto_Inicio']);
            $eq->__SET('abono',  $_REQUEST['abono']);
            $eq->__SET('intereses',  $_REQUEST['intereses']);
            $eq->__SET('saldo_Factura',  $_REQUEST['saldo_Factura']);
            $eq->__SET('saldo_Global',  $_REQUEST['saldo_Global']);

			$model->Registrar($eq);
			header('Location: index.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id_Cliente'],$_REQUEST['id_Comprobante']);
			header('Location: index.php');
			break;

		case 'editar':
			$eq = $model->Obtener($_REQUEST['id_Cliente'],$_REQUEST['id_Comprobante']);
			break;
	}
}
?>

<!DOCTYPE html>
<html lang="ES">
	<head>
        <meta charset="utf-8">
		<title>Manteminiento Clientes</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">
        <h1>Manteminiento Cuentas x Cobrar</h1>

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $eq->id_Cliente > 0,$eq->id_Comprobante > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id_Cliente" value="<?php echo $eq->__GET('id_Cliente'); ?>" />
                    <input type="hidden" name="id_Comprobante" value="<?php echo $eq->__GET('id_Comprobante'); ?>" />                    
                    <table style="width:500px;">
                        <tr>
                            <td>

                            <select id="cliente">
                                    <option value=" " selected>Clientes</option>
                                    <?php while($reg1=mysql_fetch_array($paquete1)) { ?>
                                    <option value="<?php echo $reg1[0];?>"><?php echo "<li><a href=\"index.php?fact=".urlencode($reg1[0])."\">".$reg1[1]."</a></li>"?>;</option>
                                    <?php };?>
                            </select>


                            <script>
                                $(document).ready(function(){
                                    $("#cliente").click(functtion(){
                                        $("#cliente").val();
                                    });
                                })
                            </script>
                        </td>
                        </tr>
                        <tr>
                            
                            <?php
                                 
                                $orden2="SELECT * FROM comprobante ";//where Cliente_id = $idC";
                                $paquete2=mysql_query($orden2);?>
                            <th style="text-align:left;">Factura</th>
                            <td>
                                    <select name="facturas" style="width:200%;">
                                    <option value="" selected>Facturas</option>
                                    <?php while($reg2=mysql_fetch_array($paquete2)) { ?>
                                    <option></option>
                                    <?php };?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Fecha Inicio</th>
                            <td><input type="text" name="fecha_Inicio" value="<?php echo $eq->__GET('fecha_Inicio'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Fecha Vence</th>
                            <td><input type="text" name="fecha_Vence" value="<?php echo $eq->__GET('fecha_Vence'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Monto Inicio</th>
                            <td><input type="text" name="monto_Inicio" value="<?php echo $eq->__GET('monto_Inicial'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Abono</th>
                            <td><input type="text" name="abono" value="<?php echo $eq->__GET('abono'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Intereses</th>
                            <td><input type="text" name="intereses" value="<?php echo $eq->__GET('interes'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Saldo Factura</th>
                            <td><input type="text" name="saldo_Factura" value="<?php echo $eq->__GET('saldo_Factura'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Saldo Global</th>
                            <td><input type="text" name="saldo_Global" value="<?php echo $eq->__GET('saldo_Global'); ?>" style="width:200%;" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <!-- <table class="pure-table pure-table-horizontal" style="width:1300px;">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            <th style="text-align:left;">Teléfono</th>
                             <th style="text-align:left;">Dirección</th>
                              <th style="text-align:left;"></th>
                               <th style="text-align:left;"></th>
                        </tr>
                    </thead>
                   
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Nombre'); ?></td>
                            <td><?php echo $r->__GET('RUC'); ?></td>
                            <td><?php echo $r->__GET('Direccion'); ?></td>
                            
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                   
                </table>      -->
              
            </div>
        </div>

    </body>
</html>
