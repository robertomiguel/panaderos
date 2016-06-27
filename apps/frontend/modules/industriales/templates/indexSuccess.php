<script>
jQuery(document).ready(function($)
{
$("#ordenar").tablesorter( {sortList: [[5,1]]} );
$('#ordenar').tableScroll({height:600});
});

</script>
<h1>Asociación de industriales panaderos<br>Fondo convencional ordinario<br>Listado Completo</h1>
<center><b>Total de empleadores: <?php echo count($empleadores); ?></b></center>
<div>
<a href="/industriales/soloalta">Listar solo empleadores activos</a> - <a href="/industriales/solobaja">Listar solo empleadores inactivos</a>
</div>
<div style="position:absolute;left:5px" class="tablaRecuadro">
<table id="ordenar" style="width:1050px">
<thead>
<th>CUIT</th>
<th>NOMBRE</th>
<th>Fecha<br>Baja</th>
<th>Último<br>período<br>pagado</th>
<th>Fecha<br>de pago</th>
<th>Períodos<br>sin pagar</th>
<th>Total<br>deuda</th>
<th>Ver<br>detalle</th>
</thead>
<tbody>
<?php foreach($empleadores as $empleador):
$detalle = Industriales::vista($empleador->getId());
?>
<tr>
<td align="center"><?php echo Formatos::guiones($empleador->getCuit()) ?></td>
<td><?php echo $empleador->getNombre() ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['baja']); ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['periodo']); ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['pago']); ?></td>
<td align="center"><?php echo $detalle['cuotas']; ?></td>
<td align="right">$ <?php echo Formatos::monedasimple($detalle['deudatotal']); ?></td>
<td align="center"><a href="/industriales/detalle/eid/<?php echo $empleador->getId(); ?>"><img src="/images/ver.png"></a><td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<br>
</div>
