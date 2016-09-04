<?php
//hola
$numFact=$_POST["comprob_id"];
$cli=$_POST["cliente_id"];
$tPago = $_POST["pago"];
$idPro = $_POST["idProd"];
$Vplazo= $_POST["plazo"];
$iva=$_POST["impuestoV"];
$descuent=$_POST["descu"];
$tipoF=$_POST['tipoFact'];
$tipoC=$_POST['tipoCamb'];

date_default_timezone_set('America/Costa_Rica');

$fec=date('d-m-Y');
$fecPlazo=date('d-m-Y',strtotime("+$Vplazo day"));

$c=mysql_connect("localhost","root","");
mysql_select_db("facturador");


$fec=date('d-m-y');
             $sSQL="UPDATE comprobante Set fecha= $fec Where id='$numFact'";
            mysql_query($sSQL);

if($tPago=='Contado'){
    $sSQL="UPDATE comprobante Set Tipo_pago='Contado' Where id='$numFact'";
    mysql_query($sSQL);
}else if($tPago='Credito'){
    $sSQL="UPDATE comprobante Set Tipo_pago='Credito' Where id='$numFact'";
    mysql_query($sSQL);
}else{
    echo '<script language="javascript">alert("ERROR");</script>'; 
}

if($tipoC>0){
    $sSQL="UPDATE comprobante Set Moneda='Colones' Where id='$numFact'";
    mysql_query($sSQL);
}else if($tipoC==0){
    $sSQL="UPDATE comprobante Set Moneda='Dolares' Where id='$numFact'";
    mysql_query($sSQL);
}else{
    echo '<script language="javascript">alert("ERROR");</script>'; 
}



$orden1="SELECT Nombre,Direccion,RUC,comprobante.id
FROM cliente,comprobante
WHERE cliente.id=comprobante.Cliente_id
AND comprobante.id=$numFact";
$paquete1=mysql_query($orden1);
$reg1=mysql_fetch_array($paquete1);

$orden2="SELECT producto_id,nombre,presenta,precioUnitario,cantidad,total
FROM producto,comprobante_detalle
WHERE comprobante_detalle.Producto_id=producto.id
AND comprobante_detalle.Comprobante_id=$numFact";
$paquete2=mysql_query($orden2);


//Llamada al script fpdf
require('fpdf.php');

if($tipoF=="normal"){
//variable que guarda el nombre del archivo PDF
$archivo="factura-$numFact.pdf";




$archivo_de_salida=$archivo;

$pdf=new FPDF();  //crea el objeto
$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.


//logo de la tienda
$pdf->Image('interAgro.jpg',10,10 );


// Datos de la tienda
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(50, 10);
$pdf->MultiCell(100, //posición X
5, //posición Y
"INTER Soluciones Agropecuarias de CR S.A\n".
"Cédula jurídica 3-101-196052 \n".
"San Nicolás, Cartago, Costa Rica"."\n".
"Bodega, La Virgen, Sarapiquí, Heredia"."\n".
"Teléfono: +(506) 2761-2200, +(506) 2573-0903"."\n".
"Correo: interagrocr@gmail.com", 0, // bordes 0 = no | 1 = si
 "C", // texto justificado 
 false);

// Encabezado de la factura
$pdf->SetFont('Arial','',12);
$top_datos=40;
$pdf->SetXY(80, $top_datos);
$pdf->Cell(190, 10, "FACTURA", 0, 2, "C");
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(190,5, "Numero de factura: ".$reg1[3]."\n".
    "Fecha: ".$fec."\n".
    "Tipo de Pago: ".$tPago."\n".
    "Plazo: ". $Vplazo."\n".
    "Fecha de Vence: ".$fecPlazo."\n",
     0, "C", false);
$pdf->Ln(2);

// Datos del cliente
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20, 60);
$pdf->Cell(190, 10, "Datos del cliente:", 0, 2);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(
190, //posición X
5, //posicion Y
"Nombre: ".$reg1[0]."\n".
"Direccion: ".$reg1[1]."\n".
"Telefono: ".$reg1[2]."\n",
0, // bordes 0 = no | 1 = si
"J", // texto justificado
false);
//Salto de línea
$pdf->Ln(2);


// extracción de los datos de los productos a través de la función explode
// $e_productos = explode(",", $productos);
// $e_unidades = explode(",", $unidades);
// $e_precio_unidad = explode(",", $precio_unidad);

//Creación de la tabla de los detalles de los productos productos
$top_productos = 100;
    $pdf->SetXY(0, $top_productos);
    $pdf->Cell(40, 5, 'CANTIDAD', 0, 1, 'C');
    $pdf->SetXY(30, $top_productos);
    $pdf->Cell(40, 5, 'DESCRIPCION', 0, 1, 'C');
    $pdf->SetXY(80, $top_productos);
    $pdf->Cell(40, 5, 'PRESENTACION', 0, 1, 'C');
    $pdf->SetXY(110, $top_productos);
    $pdf->Cell(40, 5, 'PRECIO UNIDAD', 0, 1, 'C');    
    $pdf->SetXY(140, $top_productos);
    $pdf->Cell(40, 5, 'DESCUENTO', 0, 1, 'C');
    $pdf->SetXY(160, $top_productos);
    $pdf->Cell(40, 5, 'TOTAL', 0, 1, 'C');
 
$precio_subtotal = 0; // variable para almacenar el subtotal
$y = 115; // variable para la posición top desde la cual se empezarán a agregar los datos
$x=0;


while ($reg2=mysql_fetch_array($paquete2, MYSQL_NUM)) {
    if($descuent>0){
    $sSQL="UPDATE comprobante Set descuento=($descuent/100)*$reg2[4] Where id='$numFact'";
    mysql_query($sSQL);
    }
    $pdf->SetFont('Arial','',10);
    if($tipoC>0){
        $pdf->SetXY(0, $y);
        $pdf->Cell(40, 5, $reg2[4], 0, 1, 'C');
        $pdf->SetXY(30, $y);
        $pdf->Cell(30, 5, $reg2[1], 0, 1, 'C');
        $pdf->SetXY(80, $y);
        $pdf->Cell(40, 5, $reg2[2], 0, 1, 'C');
        $pdf->SetXY(110, $y);
        $pdf->Cell(40, 5, number_format($reg2[3]/$tipoC,2), 0, 1, 'C');
        $pdf->SetXY(140, $y);
        $pdf->Cell(40, 5,($descuent/100)*$reg2[5], 0, 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->Cell(40, 5, number_format($reg2[5]/$tipoC,2), 0, 1, 'C');
    }else if($tipoC==0){
        $pdf->SetXY(0, $y);
        $pdf->Cell(40, 5, $reg2[4], 0, 1, 'C');
        $pdf->SetXY(30, $y);
        $pdf->Cell(30, 5, $reg2[1], 0, 1, 'C');
        $pdf->SetXY(80, $y);
        $pdf->Cell(40, 5, $reg2[2], 0, 1, 'C');
        $pdf->SetXY(110, $y);
        $pdf->Cell(40, 5, number_format($reg2[3],2), 0, 1, 'C');
        $pdf->SetXY(140, $y);
        $pdf->Cell(40, 5,($descuent/100)*$reg2[5], 0, 1, 'C');
        $pdf->SetXY(160, $y);
        $pdf->Cell(40, 5, number_format($reg2[5],2), 0, 1, 'C');
    }else{
        echo '<script language="javascript">alert("ERROR");</script>'; 
    }  
    //Cálculo del subtotal  
    $precio_subtotal += $reg2[3] * $reg2[4];
    $x++;

    // aumento del top 5 cm
    $y = $y + 5; 
   
}






mysql_close($c);


//Cálculo del Impuesto
$add_iva = $precio_subtotal * $iva / 100;
$des=($descuent/100)*$precio_subtotal;
//Cálculo del precio total
$total_mas_iva = $precio_subtotal-$des+$add_iva;

$pdf->Ln(2);
$pdf->Ln(2);
$pdf->Ln(2);

$pdf->SetFont('Arial','',12);
if($tipoC>0){
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "Subtotal: $/  ".number_format($precio_subtotal/$tipoC,2), 0, 1, "R");
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "I.V.A: $/  ".$add_iva, 0, 1, "R");
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "Descuento: $/  ".number_format($des,2), 0, 1, "R");
    $pdf->SetFont('Arial','B',14);
    $pdf->Ln(2);
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "TOTAL: $/  ".number_format($total_mas_iva/$tipoC,2), 0, 1, "R");
}else if($tipoC==0){
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "Subtotal: C/  ".number_format($precio_subtotal,2), 0, 1, "R");
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "I.V.A: C/ ".$add_iva, 0, 1, "R");
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "Descuento: C/  ".number_format($des,2), 0, 1, "R");
    $pdf->SetFont('Arial','B',14);
    $pdf->Ln(2);
    $pdf->Ln(2);
    $pdf->Cell(190, 5, "TOTAL: C/  ".number_format($total_mas_iva,2), 0, 1, "R");
}else{
    echo '<script language="javascript">alert("ERROR");</script>'; 
}



/*$pdf->SetFont('Arial','B',12);
$top_datos=300;
$pdf->SetXY(80, $top_datos);
$pdf->Cell(190, 10, "FACTURA", 0, 2, "C");
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(190,5, "Número de factura: ".$reg1[3]."\n".
    "Fecha: ".date('d/m/y')."\n".
    "Tipo Moneda: [Colones]  [Dolares]\n".
    "Tipo de Pago:[Contado]  [Credito]\n",
     0, "C", false);
$pdf->Ln(2);*/


$pdf->SetFont('Arial','',10);
$pdf->SetXY(5, 230);
$pdf->Cell(190, 5, "Recibido por: ______________________                         Revisado por: __________________________", 0, 1, "L");
$pdf->Ln(2);
$pdf->Ln(2);
$pdf->Ln(2);
$pdf->Cell(190, 5, "Hecho por: ______________________", 0, 1, "L");
$pdf->SetXY(5, 255);
$pdf->Cell(190, 5,
"Hacer todos los cheques pagaderos a INTER Soluciones Agropecuarias de CR S.A",0,1,"L");
$pdf->Cell(190, 5,"Autorizo por administración tributaria según resolución #11-97 de la Gaceta #171 del 12 de agosto de 1997",0,1,"C");
$pdf->Ln(2);
$pdf->Ln(2);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190, 5, "GRACIAS POR SU CONFIANZA EN NOSOTROS", 0, 1, "C");
$pdf->Output();//cierra el objeto pdf

//Creacion de las cabeceras que generarán el archivo pdf
header ("Content-Type: application/download");
header ("Content-Disposition: attachment; filename=$archivo");
header("Content-Length: " . filesize("$archivo"));
$fp = fopen($archivo, "r");
fpassthru($fp);
fclose($fp);

//Eliminación del archivo en el servidor
unlink($archivo);
}else{
    $pdf=new FPDF('P','mm',array(58,150));  //crea el objeto
$pdf->AddPage();  //añadimos una página. Origen coordenadas, esquina superior izquierda, posición por defeto a 1 cm de los bordes.




// Datos de la tienda
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(0, 5);
$pdf->MultiCell(55, //posición X
5, //posición Y
"INTER Soluciones Agropecuarias de CR S.A\n".
"Cédula jurídica 3-101-196052 \n".
"San Nicolás, Cartago, Costa Rica"."\n".
"Bodega, La Virgen, Sarapiquí, Heredia"."\n".
"Teléfono: +(506) 2761-2200, +(506) 2573-0903"."\n".
"Correo: interagrocr@gmail.com", 0, // bordes 0 = no | 1 = si
 "C", false);

$pdf->SetFont('Arial','B',6);
$pdf->SetXY(0, 35);
$pdf->Cell(55,5,"FACTURA #: ".$reg1[3],0,1,'C');
$pdf->SetXY(0, 40);
$pdf->Cell(55,5,"FECHA : ".date('d/m/Y H:i:s'),0,1,'C');
$pdf->Ln(2);
$pdf->SetXY(3, 46);

$pdf->SetFont('Arial','',6);
$pdf->MultiCell(
55, //posición X
3, //posicion Y
"Nombre: ".$reg1[0]."\n".
"Direccion: ".$reg1[1]."\n".
"Telefono: ".$reg1[2]."\n",
0, // bordes 0 = no | 1 = si
"J", // texto justificado
false);
//Salto de línea
$pdf->Ln(2);
// extracción de los datos de los productos a través de la función explode
// $e_productos = explode(",", $productos);
// $e_unidades = explode(",", $unidades);
// $e_precio_unidad = explode(",", $precio_unidad);

//Creación de la tabla de los detalles de los productos productos
$pdf->SetFont('Arial','',5);
$top_productos = 60;
    $pdf->SetXY(4, $top_productos);
    $pdf->Cell(5, 5, 'CANT', 0, 1, 'L');

    $pdf->SetXY(12, $top_productos);
    $pdf->Cell(5, 5, 'DESC', 0, 1, 'L'); 

    $pdf->SetXY(40, $top_productos);
    $pdf->Cell(5, 5, 'TOTAL', 0, 1, 'L');
    
    
$pdf->SetXY(5, 65);
$pdf->Cell(5, 5, '---------------------------------------------------------------------------', 0, 1, 'L');   

$precio_subtotal = 0; // variable para almacenar el subtotal
$y = 70; // variable para la posición top desde la cual se empezarán a agregar los datos
$x=0;

while ($reg2=mysql_fetch_array($paquete2, MYSQL_NUM)) {
    if($descuent>0){
    $sSQL="UPDATE comprobante Set descuento=($descuent/100)*$reg2[4] Where id='$numFact'";
    mysql_query($sSQL);
    }
    $pdf->SetFont('Arial','',6);
    if($tipoC>0){   
        $pdf->SetXY(3, $y);
        $pdf->Cell(1, 5,$reg2[4], 0, 1);

        $pdf->SetXY(6, $y);
        $pdf->Cell(5, 5, $reg2[1], 0, 1);

        $pdf->SetXY(33, $y);
        $pdf->Cell(3, 5, $reg3[2], 0, 1);

        $pdf->SetXY(40, $y);
        $pdf->Cell(5, 5, number_format($reg2[5]/$tipoC,2), 0, 1);

 
        //Cálculo del subtotal  
        $precio_subtotal += $reg2[2] * $reg2[3];
        $x++;

        // aumento del top 5 cm
        $y = $y + 5;
    }else if($tipoC==0){
        $pdf->SetXY(3, $y);
        $pdf->Cell(5, 5,$reg2[4], 0, 1);

        $pdf->SetXY(6, $y);
        $pdf->Cell(5, 5, $reg2[1], 0, 1);

        $pdf->SetXY(33, $y);
        $pdf->Cell(2,5, $reg2[2], 0, 1);

        $pdf->SetXY(40, $y);
        $pdf->Cell(5, 5, number_format($reg2[5],2), 0, 1);
        
           
            
        
        //Cálculo del subtotal  
        $precio_subtotal += $reg2[3] * $reg2[4];
        $x++;

        // aumento del top 5 cm
        $y = $y + 5;
    }else{
        echo '<script language="javascript">alert("ERROR");</script>'; 
    }
    
}



mysql_close($c);


//Cálculo del Impuesto
//$add_iva = $precio_subtotal * $iva / 100;

//Cálculo del precio total
$add_iva = $precio_subtotal * $iva / 100;
$des=($descuent/100)*$precio_subtotal;
$total_mas_iva = $precio_subtotal-$des+$add_iva;

$pdf->Ln(2);
$pdf->Ln(2);
$pdf->Ln(2);

$pdf->SetFont('Arial','',7);

if($tipoC>0){
    $pdf->SetXY(5,$y+5);
    $pdf->MultiCell(50, 5, "Subtotal: $/".number_format($precio_subtotal/$tipoC,2)."\n".
                        "I.V.A: ".$add_iva."\n".
                        "Descuento: $/ ".number_format($des,2)."\n".
                        "TOTAL: $/".number_format($total_mas_iva/$tipoC,2), 0,"L",false);
}else if($tipoC==0){
    $pdf->SetXY(5,$y+5);
    $pdf->MultiCell(50, 5, "Subtotal: C/ ".number_format($precio_subtotal,2)."\n".
                        "I.V.A: C/ ".$add_iva."\n".
                        "Descuento: C/ ".number_format($des,2)."\n".
                        "TOTAL: C/ ".number_format($total_mas_iva,2), 0,"L",false);
}else{
    echo '<script language="javascript">alert("ERROR");</script>'; 
}


$pdf->SetFont('Arial','',6);

$pdf->Ln(2);
$pdf->Ln(2);
$pdf->Ln(2);
$pdf->SetXY(2,$y+35);
$pdf->MultiCell(55, 3,"Autorizo por administración tributaria"."\n".
                    "según resolución #11-97 de la Gaceta #171"."\n".
                    "del 12 de agosto de 1997",0,"C",false);
$pdf->Ln(2);
$pdf->Ln(2);

$pdf->SetFont('Arial','B',5);
$pdf->Cell(35, 3, "GRACIAS POR SU CONFIANZA EN NOSOTROS", 0, 1, "C");

/*$pdf->SetFont('Arial','B',12);
$top_datos=300;
$pdf->SetXY(80, $top_datos);
$pdf->Cell(190, 10, "FACTURA", 0, 2, "C");
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(190,5, "Número de factura: ".$reg1[3]."\n".
    "Fecha: ".date('d/m/y')."\n".
    "Tipo Moneda: [Colones]  [Dolares]\n".
    "Tipo de Pago:[Contado]  [Credito]\n",
     0, "C", false);
$pdf->Ln(2);*/



$pdf->Output();//cierra el objeto pdf

}
