<?php
$vence = str_replace('-','',$boletasindical->getVencimiento());
$pagado = $boletasindical->getPago();
if ($vence<date('Ymd'&& $pagado<>null)){
$boletasindical->setVencimiento(date('Y-m-d'));
$boletasindical->save();
}
?>
<script>
$(document).ready(function(){$("#ordenar").tablesorter();}); 

jQuery(document).ready(function($)
{
	$('#ordenar').tableScroll({height:400});

        $('#fechadepago').datepicker({
   regional:'es',
   minDate: '<?php echo date("d/m/Y") ?>',
   maxDate: '+1y',
   showOn: 'both',
   buttonText: 'Seleccionar',
   autoSize: true,
//   changeYear: true
   beforeShowDay: function (day) {
                  var day = day.getDay();
                  if (day == 6 || day == 0) {
                  return [false, "somecssclass"]
                  } else {
                 return [true, "someothercssclass"]
                 }
                 }          
 });
 });

</script>

<h1>Período: <?php echo Formatos::periodo($boletasindical->getPeriodo()); ?></h1>
<input type="hidden" id="blt" value="<?php echo $idbol ?>">
<center>
<div class="menuTemplate">
<input class="boton" type="button" value="Seleccionar Períodos" onClick="javascript:window.location.href ='/crearboleta'">
<input class="boton" type="button" id="<?php echo $idbol ?>" value="Agregar Empleado" onClick="agregaremp(this.id);">
</div>
<div  class="boleta1 tablaRecuadro">
<div class="tituloTabla">Sindical</div>
<center>
<table id="ordenar">
<thead>
   <th width="130px">CUIL</th>
   <th width="auto">Nombre</th>
   <th width="100px">Salario</th>
   <th width="100px">Sepelio 2%</th>
   <th width="100px">Cuota 3%</th>
   <th></th>
 </thead>
 <tbody>
 <?php foreach($empbolsin as $empleado):?>
   <tr>
   <td align="center"><?php echo Formatos::guiones($empleado->getCuil()) ?></td>
   <td><?php echo Formatos::textoCool($empleado->getNombre()) ?></td>
   <td align="right"><?php echo Formatos::moneda($empleado->getSalario()) ?></td>
   <td align="right"><?php
if ($empleado->getSepelio()){
$sepelio = ($empleado->getSalario()*2)/100;
 echo Formatos::moneda($sepelio); } else {echo 'no paga';$sepelio=0;} ?></td>

   <td align="right"><?php
$cuota = ($empleado->getSalario()*3)/100;
 echo Formatos::moneda($cuota); ?></td>

   <td align="center"><a href="<?php echo url_for('empbolsin/edit').'/id/'.$empleado->getId() ?>"><img src="/images/editar.png"></td>
  </tr>
 <?php 
$total = $total + $empleado->getSalario();
$cep = $cep+$sepelio;
$cuotaSindi = $cuotaSindi+$cuota;
endforeach; ?>
 </tbody>
</table>
<table>
  <tr class="raya">
   <td width="130px"></td>
   <td width="auto" align="center">Empleados <?php echo count($empbolsin) ?></td>
   <td width="100px" align="right"><?php echo Formatos::moneda($total) ?></td>
   <td width="100px" align="right"><?php echo Formatos::moneda($cep) ?></td>
   <td width="100px" align="right"><?php echo Formatos::moneda($cuotaSindi) ?></td>
  </tr>
   <tr>
   <td align="right" colspan="3">Total</td>
   <td colspan="2" class="subtop" align="center"><?php echo Formatos::moneda($cuotaSindi+$cep) ?></td>
  </tr>
  <tr>
   <td align="right" colspan="3">Primer Vencimiento
<?php echo Formatos::primervencimiento($boletasindical->getPeriodo());?>
   </td>
   <td align="center" colspan="2"><?php echo Formatos::moneda($cuotaSindi+$cep) ?></td>
  </tr>
<tr>
   <td align="right" colspan="3">Vencimiento actual
<input type="text" id="fechadepago" onChange="cambiarVencimiento(this.value)"
value="<?php echo Formatos::fecha($boletasindical->getVencimiento()) ?>" readonly>
 Días atrasados: <span id="atraso">
<?php
echo Formatos::restarfecha(Formatos::primervencimiento($boletasindical->getPeriodo()),Formatos::fecha($boletasindical->getVencimiento())) ?></span></td>
   <td align="center" colspan="2"><?php echo Formatos::moneda(($cuotaSindi+$cep)*(36/365)/100)?></td>
  </tr>
  <tr>
   <td align="right" colspan="3"><b>TOTAL</b></td>
   <th align="center" colspan="2"><?php echo Formatos::moneda($cuotaSindi+$cep) ?></th>
   <td></td>
  </tr>
<tr>
<td colspan="4" align="right"><a href="/crearboleta/printboleta/id/<?php echo $boletasindical->getId() ?>">imprimir demo</a><td>
</tr>
 </table>
</center>
</div>
<br>
</center>
