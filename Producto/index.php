<?php
require_once 'equipo.entidad.php';
require_once 'equipo.model.php';


$c=mysql_connect("127.0.0.1","root",'');
mysql_select_db("facturador");

$orden1="SELECT descripcion FROM Presentacion"; 

$paquete1=mysql_query($orden1);


// Logica
$eq = new Producto();
$model = new ProductoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$eq->__SET('id',       $_REQUEST['id']);
			$eq->__SET('Nombre',     $_REQUEST['nombre']);
			$eq->__SET('Precio',        $_REQUEST['precio']);
           $eq->__SET('existencia',        $_REQUEST['existencia']);
			

			$model->Actualizar($eq);
			header('Location: index.php');
			break;

		case 'registrar':
			$eq->__SET('id',       $_REQUEST['id']);
            $eq->__SET('Nombre',     $_REQUEST['nombre']);
            $eq->__SET('Precio',        $_REQUEST['precio']);
            $eq->__SET('existencia',        $_REQUEST['existencia']);


			$model->Registrar($eq);
			header('Location: index.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: index.php');
			break;

		case 'editar':
			$eq = $model->Obtener($_REQUEST['id']);
			break;
	}
}
?>

<!DOCTYPE html>
<html lang="ES">
	<head>
        <meta charset="utf-8">
		<title>Manteminiento Productos</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">
        <h1>Manteminiento Productos</h1>

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $eq->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id" value="<?php echo $eq->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($eq->__GET('Nombre')); ?>" style="width:100%;" /></td>
                            <td><a class="btn btn-primary pull-left btn-lg" href="http://localhost/facturador/Producto">LIMPIAR</a></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Precio</th>
                            <td><input type="text" name="precio" value="<?php echo $eq->__GET('Precio'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Cantidad Existencia</th>
                            <td><input type="text" name="existencia" value="<?php echo $eq->__GET('existencia'); ?>" style="width:100%;" /></td>
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
                            <th style="text-align:left;">Dscripcion</th>
                            <th style="text-align:left;">Precio</th>
                            <th style="text-align:left;">Existencia</th>
                             <th style="text-align:left;"></th>
                            <th style="text-align:left;"></th>

                        </tr>
                    </thead>
                   
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Nombre'); ?></td>
                            <td><?php echo $r->__GET('Precio'); ?></td>
                            <td><?php echo $r->__GET('existencia'); ?></td>
                            
                            
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                   
                </table>     
              
            </div>
        </div>

    </body>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/ini.js"></script>
    <script src="js/jquery.anexsoft-validator.js"></script>
    <script src= "js/js-render.js"></script>
    <script src="js/jquery.anexgrid.min.js"></script>
</html>