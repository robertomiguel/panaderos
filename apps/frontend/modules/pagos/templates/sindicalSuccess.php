<script>
jQuery(document).ready(function($)
{
$("#ordenar").tablesorter( {sortList: [[5,1]]} );
$('#ordenar').tableScroll({height:600});
});

</script>
<h1>Boletas sindical pagadas</h1>
<center><b>
<div>
	<<<?php echo link_to('Primero', 'pagos/sindical?page='.$pager->getFirstPage()) ?>
	<<?php echo link_to('Anterior', 'pagos/sindical?page='.$pager->getPreviousPage()) ?>
 
	<?php if ($pager->haveToPaginate()): ?>
	<?php foreach ($pager->getLinks(10) as $page): ?>

	<?php echo ($page == $pager->getPage()) ? $page : link_to($page, 'pagos/sindical?page='.$page) ?>

	<?php endforeach ?>
	<?php endif ?>
	<?php echo link_to('Siguiente>', 'pagos/sindical?page='.$pager->getNextPage()) ?>
	<?php echo link_to('Último>>', 'pagos/sindical?page='.$pager->getLastPage()) ?>
</div></b></center>
<div style="position:absolute;left:5px" class="tablaRecuadro">
<table id="ordenar" style="width:1024px">
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
<?php foreach($pager->getResults() as $empleador):
$detalle = Sindical::vista($empleador->getId());
?>
<tr>
<td align="center"><?php echo Formatos::guiones($empleador->getCuit()) ?></td>
<td><?php echo $empleador->getNombre() ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['baja']); ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['periodo']); ?></td>
<td align="center"><?php echo Formatos::fecha($detalle['pago']); ?></td>
<td align="center"><?php echo $detalle['cuotas']; ?></td>
<td align="right"><?php echo Formatos::monedasimple($detalle['deudatotal']); ?></td>
<td align="center"><a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/detalleEmpleador').'/id/'.$empleador->getId() ?>"><img src="/images/ver.png"></a><td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<br>
<br>
<br>

