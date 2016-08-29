<?php
$c=mysql_connect("127.0.0.1","root","");
mysql_select_db("facturador");

$orden1="SELECT * FROM presentacion"; 
$paquete1=mysql_query($orden1);

?>
<script type="text/javascript">
$(document).ready(function(){
    $('#btnCli').click(function(){
        url = "Cliente/index.php";
        window.open(url, '_blank');
        return false;
    });
    $('#btnProd').click(function(){
        url = "Producto/index.php";
        window.open(url, '_blank');
        return false;
    });
});
</script>
<ol class="breadcrumb">
  <li><a href="?c=Comprobante&a=index">Inicio</a></li>
  <li class="active">Nuevo comprobante</li>
</ol>
<form id="frm-comprobante" method="post" action="?c=Comprobante&a=GuardaPreFactura">

    <div class="row">
        <div class="col-xs-12">
            <input name='fecha' type="hidden" value="<?php echo date('d-m-y');?>" />
            <fieldset>
                <legend>Datos de nuestro cliente</legend>

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Cliente</label>
                            <input name="cliente_id" type="hidden" value="<?php echo $comprobante->Cliente->Nombre; ?>" />
                            <input autocomplete="off" id="cliente" class="form-control" type="text" placeholder="Ingrese el nombre del cliente" />
            
                        </div>

                    </div>
                    <div class="col-xs-1">
                            <div class="form-group">
                                <label type="hidden"></label>
                                <button class="btn btn-primary form-control" id="btnCli" type="button" href="Cliente/index.php">
                                <i>Nuevo</i>
                                </button>
                            </div>
                        </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input name="comprob_id" type="hidden" value="<?php echo $comprobante->id; ?>" />
                            <input autocomplete="off" id="ruc" disabled class="form-control" type="text" placeholder="Telefono" />                    
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input autocomplete="off" id="direccion" disabled class="form-control" type="text" placeholder="Dirección" />                    
                        </div>
                    </div>
                    
                </div>
            </fieldset>

            <div class="well well-sm">
                <div class="row">
                    <div class="col-xs-4">
                        <input id="producto_id" type="hidden" value="0" />
                        <input autocomplete="off" id="producto" class="form-control" type="text" placeholder="Nombre del producto" />
                    </div>
                    <div class="col-xs-1">
                            <div class="form-group">
                                <button class="btn btn-primary form-control" id="btnProd" type="button">
                                <i>Nuevo</i>
                                </button>
                            </div>
                        </div>
                    <div class="col-xs-2">


                        <select id="presenta" class="form-control" type="text" placeholder="Presentacion" />
                            <option value='0' selected>Presentacion</option>";
                            <?php 
                            while ($reg2=mysql_fetch_array($paquete1, MYSQL_NUM)) 
                            {?> 
                            <option value="<?php echo $reg2[1]; ?>"> <?php echo $reg2[1]; ?> </option>" 
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <input autocomplete="off" id="cantidad" class="form-control" type="text" placeholder="Cantidad" />
                    </div>
                    <div class="col-xs-2">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">C/.</span>
                          <input autocomplete="off" id="precio" class="form-control" type="text" placeholder="Precio" />
                        </div>
                    </div>
                    <div class="col-xs-1">
                            <div class="form-group">
                                <input type="text" id="descuento" class="form-control"  placeholder="Desc" value="0"/>
                            </div>
                        </div>
                    <div class="col-xs-1">
                        <button class="btn btn-primary form-control" id="btn-agregar" type="button">
                             <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </div>

                </div>            
            </div>
            <hr />

            <ul id="facturador-detalle" class="list-group"></ul>
            
            <button class="btn btn-primary btn-block btn-lg" type="submit">Generar comprobante</button>
        </div>
</div>    
</form>

<script id="facturador-detalle-template" type="text/x-jsrender" src="">
    {{for items}}
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-5">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-danger form-control" onclick="facturador.retirar({{:id}});">
                            <i class="glyphicon glyphicon-minus"></i>
                        </button>
                    </span>
                    <input name="producto_id" type="hidden" value="{{:producto_id}}" />
                    <input disabled name="producto" class="form-control" type="text" placeholder="Nombre del producto" value="{{:producto}}" />
                </div>
            </div>
            <div class="col-xs-1">
                <input name="cantidad" class="form-control" type="text" placeholder="Cantidad" readonly value="{{:cantidad}}" />
            </div>
            <div class="col-xs-2">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">C/.</span>
                  <input name="precio" class="form-control" type="text" placeholder="Precio" readonly value="{{:precio}}" />
                </div>
            </div>
            <div class="col-xs-1">
                <input  name="descuento" class="form-control" type="text" placeholder="Desc" readonly value="{{:descuento}}" />
            </div>
            <div class="col-xs-2">
                <div class="input-group">
                    <span class="input-group-addon">C/.</span>
                    <input name="precio"  class="form-control" type="text" readonly value="{{:total}}" />  
                    <!-- <span class="input-group-btn">
                        <button type="button" class="btn btn-success form-control" onclick="facturador.actualizar({{:id}}, this);" class="btn-retirar">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </button>
                    </span> -->
                </div>
            </div>

        </div>
    </li>
    {{else}}
    <li class="text-center list-group-item">No se han agregado productos al detalle</li>
    {{/for}}

    <li class="list-group-item">
        <div class="row text-right">
            <div class="col-xs-10 text-right">
                Sub Total
            </div>
            <div class="col-xs-2">
                <b>{{:total}}</b>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row text-right">
            <div class="col-xs-10 text-right">
                Descuento
            </div>
            <div class="col-xs-2">
                <b>{{:descuento*cantidad}}</b>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row text-right">
            <div class="col-xs-10 text-right">
                Total
            </div>
            <div class="col-xs-2">
                <b>{{:total}}</b>
            </div>
        </div>
    </li>
</script>

<script src="assets/scripts/comprobante.js"></script>