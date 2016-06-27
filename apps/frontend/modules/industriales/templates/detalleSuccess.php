<h1>Asociación de industriales panaderos<br>Fondo convencional ordinario</h1>
<br>
<div style="left:5px" class="tablaRecuadro"  align="center">
<table  style="width:500px">
  <tbody>
    <tr>
      <th>Cuit:</th>
      <td><?php echo Formatos::guiones($empleador->getCuit()) ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $empleador->getNombre() ?></td>
    </tr>
    <tr>
      <th>Localidad:</th>
      <td><?php echo $empleador->getLocalidad()->getNombre() ?></td>
    </tr>
    <tr>
      <th>Domicilio:</th>
      <td><?php echo $empleador->getDomicilio() ?></td>
    </tr>
  </tbody>
</table>
</div>
<br>
<div style="position:absolute;left:30px" class="tablaRecuadro">
<table id="ordenar" style="width:900px">
<thead>
<th>Período</th>
<th>Pagado</th>
<th>Total</th>
</thead>
<tbody align="center">
<?php foreach($fondo as $periodo):?>
<tr>
<td><?php echo Formatos::fecha($periodo->getPeriodo()); ?></td>
<td><?php echo Formatos::fecha($periodo->getPago()); ?></td>
<td><?php echo Formatos::moneda(($periodo->getMaza()*3)/100); ?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<br>
<center><a href="javascript:history.back()">VOLVER</a></center>
</div>

