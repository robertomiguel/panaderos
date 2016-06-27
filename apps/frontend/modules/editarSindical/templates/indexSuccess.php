<script>
$(document).ready(function(){$("#ordenar").tablesorter();}); 
</script>
<h1>Boletas Sindical período: <?php echo $periodo ?></h1>
Período: <a href="<?php echo url_for('editarSindical/index') ?>">(2011-09) </a>
<a href="<?php echo '/editarSindical/index'.'/periodo/2011-10' ?>">(2011-10) </a>
<a href="<?php echo '/editarSindical/index'.'/periodo/2011-11' ?>">(2011-11) </a>
<table id="ordenar">
  <thead>
    <tr>
      <th>IdBol</th>
      <th>IdEmp</th>
      <th>Empleador</th>
      <th>Periodo</th>
      <th>Vencimiento</th>
      <th>Pago</th>
      <th>Total</th>
      <th>Cuota</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($boleta_sindicals as $boleta_sindical): ?>
    <tr>
      <td><a href="<?php echo url_for('editarSindical/edit?id='.$boleta_sindical->getId()) ?>"><?php echo $boleta_sindical->getId() ?></a></td>
      <td><?php echo $boleta_sindical->getEmpleadorId() ?></td>
      <td><?php echo $boleta_sindical->getEmpleador()->getNombre() ?></td>
      <td><?php echo $boleta_sindical->getPeriodo() ?></td>
      <td><?php echo $boleta_sindical->getVencimiento() ?></td>
      <td><?php echo $boleta_sindical->getPago() ?></td>
      <td><?php $total=Sindical::sumar($boleta_sindical->getId());echo $total; ?></a></td>
      <td><?php echo ($total*5)/100; ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('editarSindical/new') ?>">New</a>
