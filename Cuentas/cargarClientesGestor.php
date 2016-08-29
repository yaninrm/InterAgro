<?php
include("conexion.php");
$idGest=$_POST['idGest'];
$consulta="SELECT * FROM cliente where agente like '%{$idGest}%'";
$res=$conex->query($consulta);

while($clientes=$res->fetch_assoc()){
?>
	<option value="<?php echo $clientes['id']; ?>"><?php echo $clientes['Nombre']; ?></option>
<?php
}
mysqli_close($conex);
?>