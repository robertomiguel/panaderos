<h1>Resumen de Períodos</h1>
<br>
<center>
<table class="tablaRecuadro" id="tablaPeriodo">
<tr>
<td  width="450px">
<table>
 <thead>
   <caption>Sindical</caption>
   <th width="20px">Ver</th>
   <th>Período</th>
   <th>Vencimiento</th>
   <th>Pagada</th>
 </thead>
 <tbody>
    <?php
foreach($boletasindical as $boleta):?>
  <tr>
   <td><a href="<?php echo url_for('crearboleta/verBoletas').'/id/'.$boleta->getId() ?>"><img src="/images/editar.png"></a></td>
   <td><?php echo Formatos::periodo($boleta->getPeriodo()) ?></td>
   <td><?php echo Formatos::fecha($boleta->getVencimiento()) ?></td>
   <td><?php echo Formatos::fecha($boleta->getPago()) ?></td>
  </tr>
<?php
endforeach;

?>
 </tbody>
</table>
</td>

<td width="350px">
<table>
<thead>
<caption>Fondo Convencional Ordinario</caption>
<th>Vencimiento</th>
<th>Pagada</th>
</thead>
<tbody>
<?php foreach($boletafondo as $boletaFon):?>
<tr>
<td><?php echo Formatos::fecha($boletaFon->getVencimiento()) ?></td>
<td><?php echo Formatos::fecha($boletaFon->getPago()) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</td>
</tr>

</table>
</center>
