<?php
$c=mysql_connect("127.0.0.1","root","");
mysql_select_db("facturador");

$orden1="SELECT * FROM cliente"; 
$paquete1=mysql_query($orden1);

?>
<h1 class="page-header">
    <a class="btn btn-primary pull-right btn-lg" href="?c=Comprobante&a=crud">Nuevo comprobante</a>
    Comprobantes
</h1>
<div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select id="cliente" class="form-control">
                                <?php 
                                while ($row=mysql_fetch_array($paquete1)) { ?>
                                    <option value="<?php echo $row[0];?>"> <?php echo utf8_encode($row[1]);?> </option>
                                <?php } ?>   
                            </select>
                            <!--<input name="cliente_id" type="hidden" value="<?php //echo $comprobante->Cliente->id; ?>" />
                            <input autocomplete="off" id="cliente" class="form-control" type="text" placeholder="Ingrese el nombre del cliente" />
-->
                        </div>

                    </div>
                    <div class="col-xs-2">
                        <!--type="button" href="Cliente/index.php"-->
                            <div class="form-group">
                                <label type="hidden"></label>
                                <button class="btn btn-primary form-control" id="btnCli" type="button">
                                <i>BUSCAR</i>
                                </button>
                            </div>
                    </div>
</div>

<div id="list"></div>

<script>
    $(document).ready(function(){
        $('#btnCli').click(function(){
           //alert($('#cliente').val());
            $("#list").anexGrid({
            class: 'table-striped table-bordered',
            columnas: [
                { leyenda: 'Cliente', style: 'width:200px;', columna: 'Cliente_id', ordenable: true },
                { leyenda: 'Factura', style: 'width:60px;', columna: 'id', ordenable: true },
                { leyenda: 'Tipo Pago', style: 'width:60px;', columna: 'Tipo_Pago', ordenable: true },
                { leyenda: 'Moneda', style: 'width:60px;', columna: 'Moneda', ordenable: true },
                { leyenda: 'Fecha', style: 'width:60px;', columna: 'fecha', ordenable: true  },
                { leyenda: 'Fecha Vence', style: 'width:60px;', columna: 'fechaVence', ordenable: true  },
                { leyenda: 'Sub Total', style: 'width:60px;', columna: 'Total', ordenable: true  },
                { leyenda: 'Total', style: 'width:60px;', columna: 'Total', ordenable: true  },
                { leyenda: 'Estado', style: 'width:60px;', columna: 'estado', ordenable: true  },
            ],
            modelo: [
                { formato: function(tr, obj, valor){
                    return anexGrid_link({
                        href: '?c=comprobante&a=ver&id=' + obj.id,
                        contenido: obj.Cliente.Nombre
                        
                    });
                }},
                { propiedad: 'id', class: 'text-right', },
                { propiedad: 'Tipo_Pago', class: 'text-right', },
                { propiedad: 'Moneda', class: 'text-right', },
                { propiedad: 'fecha', class: 'text-right', },
                { propiedad: 'fechaVence', class: 'text-right', },
                { propiedad: 'SubTotal', class: 'text-right', },
                { propiedad: 'Total', class: 'text-right', },
                { propiedad: 'estado', class: 'text-right', },
            ],
            url:'?c=comprobante&a=ListarCliente&idC='+$('#cliente').val(),
            limite: 10,
            columna: 'id',
            columna_orden: 'DESC',
            paginable: true
        });
        });
    });
</script>
<script>
    $(document).ready(function(){
        $("#list").anexGrid({
            class: 'table-striped table-bordered',
            columnas: [
                { leyenda: 'Cliente', style: 'width:200px;', columna: 'Cliente_id', ordenable: true },
                { leyenda: 'Factura', style: 'width:60px;', columna: 'id', ordenable: true },
                { leyenda: 'Tipo Pago', style: 'width:60px;', columna: 'Tipo_Pago', ordenable: true },
                { leyenda: 'Moneda', style: 'width:60px;', columna: 'Moneda', ordenable: true },
                { leyenda: 'Fecha', style: 'width:60px;', columna: 'fecha', ordenable: true  },
                { leyenda: 'Fecha Vence', style: 'width:60px;', columna: 'fechaVence', ordenable: true  },
                { leyenda: 'Sub Total', style: 'width:60px;', columna: 'Total', ordenable: true  },
                { leyenda: 'Total', style: 'width:60px;', columna: 'Total', ordenable: true  },
                { leyenda: 'Estado', style: 'width:60px;', columna: 'estado', ordenable: true  },
            ],
            modelo: [
                { formato: function(tr, obj, valor){
                    return anexGrid_link({
                        href: '?c=comprobante&a=ver&id=' + obj.id,
                        contenido: obj.Cliente.Nombre
                    });
                }},
                { propiedad: 'id', class: 'text-right', },
                { propiedad: 'Tipo_Pago', class: 'text-right', },
                { propiedad: 'Moneda', class: 'text-right', },
                { propiedad: 'fecha', class: 'text-right', },
                { propiedad: 'fechaVence', class: 'text-right', },
                { propiedad: 'SubTotal', class: 'text-right', },
                { propiedad: 'Total', class: 'text-right', },
                { propiedad: 'estado', class: 'text-right', },
            ],
            url:'?c=Comprobante&a=Listar',
            limite: 10,
            columna: 'id',
            columna_orden: 'DESC',
            paginable: true
        });
        
    })
    
    
</script>
<script src="assets/scripts/comprobante.js"></script>