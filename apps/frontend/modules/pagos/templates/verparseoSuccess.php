<script>
</script>
<h1>Gestión de cobranza</h1>
Datos del archivo: <b>"<?php echo $archivo; ?>"</b><br>
<table id="ordenar" style="position:relative;left:30px" class="marcador">
<thead>
<th>F<br>S</th>
<th>ID</th>
<th>Empleador</th>
<th>Período</th>
<th>Vencimiento</th>
<th>Fecha de<br>Pago</th>
<th>Importe<br>Boleta</th>
<th>pagar</th>
<thead>
<tbody>
<?php foreach ($datos as $l):
$linea = substr($l,172,58);
?>
<tr>
<td><?php $tipo=substr($linea,0,1); if ($tipo){echo 'F';}else{echo 'S';} ?></td>
<td><?php $eid=substr($linea,1,13)*1; echo $eid; ?></td>
<td><a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/detalleEmpleador').'/id/'.$eid ?>"><?php
$registro = Doctrine_Core::getTable('Empleador')->find($eid);
if($registro){
$nombre = $registro->getNombre();
} else {$nombre='<b>CLIENTE ID NO EXISTE</b>';}
echo $nombre; ?></a></td>
<td align="center"><?php $periodo='20'.substr($linea,14,2).'-'.substr($linea,16,2).'-01'; echo Formatos::fecha($periodo); ?></td>
<td align="center"><?php $vencimiento='20'.substr($linea,19,2).'-'.substr($linea,21,2).'-'.substr($linea,23,2); echo Formatos::fecha($vencimiento); ?></td>
<td align="center"><?php $diadepago='20'.substr($linea,52,2).'-'.substr($linea,54,2).'-'.substr($linea,56,2);echo Formatos::fecha($diadepago); ?></td>
<td align="right"><?php $pago=substr($linea,25,6)*1 .'.'.substr($linea,31,2); echo $pago; ?></td>
<td align="center"><a href="javascript:pagar(<?php echo '\''.$periodo.'\','.$eid.','.$tipo.',\''.$diadepago.'\',\''.$vencimiento.'\'' ?>)">pagar</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
function pagar(periodo,eid,tipo,diadepago,venc){
	$.get("/pagos/pagar", { periodo: periodo,eid: eid,tipo: tipo,diadepago: diadepago,vencimiento: venc },
	function(data){
	alert(data);
	});
}
</script>
