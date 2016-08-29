<?php require_once("includes/conection_db.php");?>
<?php require_once("includes/function.php");?>
<?php

$errores = array();
$campos_obli = array('cliente', 'factura','montoAbono');

validarCamposObli($campos_obli,$errores);

if(!empty($errores)){
	header("Location: new_credito.php");
	exit;
}
?>

<?php
$cliente   = preparar_consulta(htmlentities($_POST['cliente'],ENT_QUOTES,"UTF-8"));
$factura   = preparar_consulta(htmlentities($_POST['factura'],ENT_QUOTES,"UTF-8"));
$monto = preparar_consulta(htmlentities($_POST['montoAbono'],ENT_QUOTES,"UTF-8"));
$tipo = preparar_consulta(htmlentities($_POST['tipoAbono'],ENT_QUOTES,"UTF-8"));
$deta = preparar_consulta(htmlentities($_POST['detalle'],ENT_QUOTES,"UTF-8"));
$fecha = preparar_consulta(htmlentities($_POST['fecha'],ENT_QUOTES,"UTF-8"));

date_default_timezone_set('America/Costa_Rica');

$fec=date('d-m-Y');

$recibo= "SELECT * from cuenta_cobrar where id_comprobante={$factura}";

if (mysql_query($recibo,$conexion)){
	$respuesta=mysql_query($recibo,$conexion);
	$cuenta = mysql_fetch_array($respuesta);
	
}

$consulta="INSERT INTO abono (comprobante_id,cliente_id,monto,fecha,id_tipo_credito,detalle)
values({$factura},{$cliente},{$monto},'{$fecha}',{$tipo},'{$deta}')";

if (mysql_query($consulta,$conexion)){
	

	$saldoF=$cuenta['saldo_Factura'] - $monto;
	$tPago=$cuenta['tipo_pago'];
	$mone=$cuenta['moneda'];

	if($saldoF==0){

		$modiEstado="UPDATE cuenta_cobrar SET estado='CANCELADO',saldo_Factura=0 where id_comprobante={$factura}" ;	
		mysql_query($modiEstado,$conexion);
		
	}


	if($mone=='DOLARES'){
			$saldoG=0;
			$global= "SELECT * from cuenta_cobrar where id_cliente= {$cliente} and tipo_pago='Credito' and estado='PENDIENTE'";
			if (mysql_query($global,$conexion)){
				$respuesta=mysql_query($global,$conexion);
            	while($cuenta = mysql_fetch_array($respuesta)){
            		$saldoG+=$cuenta['saldo_Factura'];
            	}

				$iSQL2="UPDATE cuenta_cobrar SET saldo_global_dolares= {$saldoG}
                		WHERE  id_cliente= {$cliente}";
            	
            	if(mysql_query($iSQL2,$conexion)){
        			header("location: content.php");
					exit();
        		}else{
					echo "ABONO NO realizado ! ".mysql_error();
				}
            }
	}

	if($mone=='COLONES'){
			$saldoG=0;
			$global= "SELECT * from cuenta_cobrar where id_cliente= {$cliente} and tipo_pago='Credito' and estado='PENDIENTE'";
			if (mysql_query($global,$conexion)){
				$respuesta=mysql_query($global,$conexion);
            	while($cuenta = mysql_fetch_array($respuesta)){
            		$saldoG+=$cuenta['saldo_Factura'];
            	}

				$iSQL2="UPDATE cuenta_cobrar SET saldo_global= {$saldoG}
                		WHERE  id_cliente= {$cliente}";

                if(mysql_query($iSQL2,$conexion)){
        			echo "ABONO NO realizado ! ".mysql_error();
					exit();
        		}else{
					echo "ABONO NO realizado ! ".mysql_error();
				}
            	
            }
            
	}                
	
}else{
		echo "ABONO NO realizado ! ".mysql_error();
	}
	

?>

<?php
 mysql_close($conexion);
 ?>