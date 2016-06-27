<script>
</script>
<h1>Registro de boletas pagadas en el banco</h1>
Total de registros: <b>"<?php echo count($pagados) ?>"</b><br>
<table id="ordenar" style="position:relative;left:30px">
<thead>
<th>F<br>S</th>
<th>ID</th>
<th>Empleador</th>
<th>Período</th>
<th>Vencimiento</th>
<th>Fecha de<br>Pago</th>
<th>Importe<br>Boleta</th>
<thead>
<tbody>
<?php foreach ($pagados as $pagado):?>
<tr>
<td><?php echo $pagado->getTipo() ?></td>
<td><?php echo $pagado->getEmpleadorId() ?></td>
<td><a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/detalleEmpleador').'/id/'.$pagado->getEmpleadorId() ?>"><?php echo $pagado->getEmpleador()->getNombre() ?></a></td>
<td><?php echo $pagado->getPeriodo() ?></td>
<td><?php echo $pagado->getVencimiento() ?></td>
<td><?php echo $pagado->getDiadepago() ?></td>
<td><?php echo $pagado->getPago() ?></td>

</tr>
<?php endforeach; ?>
</tbody>
</table>
