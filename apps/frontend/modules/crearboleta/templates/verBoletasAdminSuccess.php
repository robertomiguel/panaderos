<?php
$vence = str_replace('-','',$boletafondo->getVencimiento());
$pagado = $boletafondo->getPago();
if ($vence<date('Ymd')&& $pagado==null){
$boletafondo->setVencimiento(date('Y-m-d'));
$boletafondo->save();
}

$vence = str_replace('-','',$boletasindical->getVencimiento());
$pagado = $boletasindical->getPago();
if ($vence<date('Ymd')&& $pagado==null){
$boletasindical->setVencimiento(date('Y-m-d'));
$boletasindical->save();
}
?>
<script>
$dialogempleado = $('<div></div>')
  .html("<center>Actualizar Salario\
<br><br>Nuevo salario: $<input type='text' id='salario' value=''></center>")
  .dialog({
	autoOpen: false,
	title: "Empleado",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Cambiar",
        click: function() {
	$.get("/empleado/cambiarsalario", { idbolf: <?php echo $idbolf ?>, idbol: <?php echo $idbol ?>, ide: ide2, salario: $("#salario").val()},
	function(data){
	window.location.href = window.location.href;
//alert(data);
	});
}}]
});
function editarempleado(ide){
ide2 = ide;
$dialogempleado.dialog('open');
	$.get("/empleado/versalario", { idbol: <?php echo $idbol ?>, ide: ide},
	function(data){$("#salario").val(data);	});
}



$(document).ready(function(){$("#ordenar").tablesorter();}); 

jQuery(document).ready(function($){
 $('#ordenar').tableScroll({height:400});
 $('#fechadepago').datepicker({regional:'es',minDate: '01/01/2009',
   maxDate: '+1y',showOn: 'both',buttonText: 'Cambiar',autoSize: true,
//   changeYear: true
   beforeShowDay: function (day) {var day = day.getDay();
if (day == 6 || day == 0) {return [false, "somecssclass"]
} else {return [true, "someothercssclass"]}} });

 $('#fechadepagofondo').datepicker({regional:'es',minDate: '01/01/2009',
   maxDate: '+1y',showOn: 'both',buttonText: 'Cambiar',autoSize: true,
//   changeYear: true
   beforeShowDay: function (day) {var day = day.getDay();
if (day == 6 || day == 0) {return [false, "somecssclass"]
} else {return [true, "someothercssclass"]}} });

});
</script>
<h1>Período: <?php echo Formatos::periodo($boletasindical->getPeriodo()); ?></h1>
<input type="hidden" id="blt" value="<?php echo $idbol ?>">
<input type="hidden" id="bltf" value="<?php echo $idbolf ?>">
<center>
<div class="menuTemplate">
<input class="boton" type="button" value="Seleccionar Períodos" onClick="javascript:window.location.href ='/crearboleta'">
</div>

<div class="menuTemplate">
<?php
if ($pagado==null){
echo "<input class='boton' type='button' id='".$idbol."' value='Agregar Empleado' onClick='agregaremp(this.id);'>";
}
?>
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
<?php
if ($pagado<>null){echo "<td></td>";} else
{
echo "<td title='Modificar salario' align='center'><a href='javascript:editarempleado(".$empleado->getId().")'><img src='/images/guita.png'></td>";
echo   "<td title='Borrar / Quitar Sepelio' align='center'><a href=".url_for('empbolsin/edit')."/id/".$empleado->getId() .'"><img src="/images/editar.png"></td>';
}
?>
  </tr>
 <?php 
endforeach;
?>
<script>
jQuery(document).ready(function($){
$('#maza').html('<?php echo Formatos::moneda($boletafondo->getMaza()); ?>');
$('#mazacuota').html('<?php echo Formatos::moneda(($boletafondo->getMaza()*3)/100); ?>');
});
</script>
 </tbody>
</table>
<?php
$totales = Sindical::pagar($idbol);
$TotalEmp = $totales['empleados'];
$masa = Formatos::moneda($totales['masa']);
$Total = Formatos::moneda($totales['total']);
$TotalSep = Formatos::moneda($totales['sepelio']);
$TotalSin = Formatos::moneda($totales['cuota']);
$Fecha1 = Formatos::primervencimiento($boletasindical->getPeriodo());
$FechaVence = Formatos::fecha($boletasindical->getVencimiento());
$DiasRecargo = $totales['dias'];
$recargo = Formatos::moneda($totales['recargo']);
$tasa = Formatos::porcien($totales['tasa']);
$TotalFinal = Formatos::moneda($totales['pagar']);

$sinpagar = <<<ETIQUETA
<table>
  <tr class="raya">
   <td width="130px"></td>
   <td width="auto" align="center">Empleados {$TotalEmp}</td>
   <td width="100px" align="right">{$masa}</td>
   <td width="100px" align="right">{$TotalSep}</td>
   <td width="100px" align="right">{$TotalSin}</td>
  </tr>
   <tr>
   <td align="right" colspan="3">Total</td>
   <td colspan="2" class="subtop" align="center">{$Total}</td>
  </tr>
  <tr>
   <td align="right" colspan="3">Primer Vencimiento {$Fecha1}
   </td>
   <td align="center" colspan="2">{$Total}</td>
</tr>
<tr>
   <td align="right" colspan="3">Nuevo Vencimiento</td><td colspan="2">
<input type="text" id="fechadepago" onChange="cambiarVencimiento(this.value)"
value="{$FechaVence}" readonly></td>
</tr>
<tr>
<td align="right" colspan="3">Días de Recargo: {$DiasRecargo} - Tasa: %{$tasa}</td>
   <td align="center" colspan="2">{$recargo}</td>

  </tr>
  <tr>
   <td align="right" colspan="3"><b>TOTAL</b></td>
   <th align="center" colspan="2">{$TotalFinal}</th>
   <td></td>
  </tr>
<tr>
<td colspan="4" align="right"><a href="/crearboleta/printboleta/id/{$idbol}">><img src="/images/imprimir.gif"> Click aquí para IMPRIMIR/DESCARGAR<</a><td></tr>
 </table>
ETIQUETA;

$FechaPagado = Formatos::fecha($pagado);
$pagado = <<<ETIQUETA
<table>
  <tr class="raya">
   <td width="130px"></td>
   <td width="auto" align="center">Empleados {$TotalEmp}</td>
   <td width="100px" align="right">{$Total}</td>
   <td width="100px" align="right">{$TotalSep}</td>
   <td width="100px" align="right">{$TotalSin}</td>
  </tr>
   <tr>
   <td align="right" colspan="3">Total</td>
   <td colspan="2" class="subtop" align="center">{$Total}</td>
  </tr>
   <tr>
   <td align="right" colspan="3">Primer Vencimiento</td>
   <td colspan="2" align="center">{$Fecha1}</td>
  </tr>
<tr>
<td align="right" colspan="3">Días de Recargo: {$DiasRecargo} - Tasa: %{$tasa}</td>
   <td align="center" colspan="2">{$recargo}</td>

  </tr>
  <tr>
   <td align="right" colspan="3">Vencimiento Seleccionado</td>
   <td align="center" colspan="2">{$FechaVence}</td>
   <td></td>
  </tr>

  <tr>
   <td align="right" colspan="3">Pagado el día</td>
   <td align="center" colspan="2">{$FechaPagado}</td>
   <td></td>
  </tr>
  <tr>
   <td align="right" colspan="3"><b>TOTAL</b></td>
   <th align="center" colspan="2">{$TotalFinal}</th>
   <td></td>
  </tr>
</table>
ETIQUETA;

if ($boletasindical->getPago()==null) {echo $sinpagar;} else {echo $pagado;}

?>
</center>
</div>
<br>
<div  class="boleta1 tablaRecuadro">
<div class="tituloTabla">Fondo Convencional Ordinario</div>
<?php
$totales = Fondo::pagar($idbolf);
$masa = Formatos::moneda($totales['masa']);
$cuota = Formatos::moneda($totales['cuota']);
$dias = $totales['dias'];
$tasa = Formatos::porcien($totales['tasa']);
$recargo = Formatos::moneda($totales['recargo']);
$pagar = Formatos::moneda($totales['pagar']);
$vence1 = Formatos::primervencimiento($boletafondo->getPeriodo());
$vence = Formatos::fecha($boletafondo->getVencimiento());
$pago =  Formatos::fecha($boletafondo->getPago());

$sinpagar = <<<ETIQUETA
<tr><td align="right">Primer Vencimiento</td><td align="center">{$vence1}</td></tr>
<tr><td align="right">Nuevo Vencimiento</td><td align="center"><input type="text" id="fechadepagofondo" onChange="cambiarVencimientofondo(this.value)"
value="{$vence}" readonly></td></tr>
<tr><td align="right">Masa salarial</td><td align="center">{$masa} <input type="button" id="btnmaza" value="Modificar" onClick="cambiarmaza()"></td></tr>
<tr><td align="right">Cuota 3%</td><td align="center">{$cuota}</td></tr>
<tr><td align="right">Días de recargo</td><td align="center">{$dias}</td></tr>
<tr><td align="right">Tasa</td><td align="center">%{$tasa}</td></tr>
<tr><td align="right">Recargo</td><td align="center">{$recargo}</td></tr>
<tr><td align="right"><b>TOTAL</b></td><th align="center">{$pagar}</th></tr>
<tr><td colspan="2" align="center"><a href="/crearboleta/printboletafondo/id/{$idbolf}">><img src="/images/imprimir.gif"> Click aquí para IMPRIMIR/DESCARGAR<</a></td><td></td></tr>
ETIQUETA;

$pagado = <<<ETIQUETA
<tr><td align="right">Primer Vencimiento</td><td align="center">{$vence1}</td></tr>
<tr><td align="right">Masa salarial</td><td align="center">{$masa} </td></tr>
<tr><td align="right">Cuota 3%</td><td align="center">{$cuota}</td></tr>
<tr><td align="right">Días de recargo</td><td align="center">{$dias}</td></tr>
<tr><td align="right">Tasa</td><td align="center">%{$tasa}</td></tr>
<tr><td align="right">Recargo</td><td align="center">{$recargo}</td></tr>
<tr><td align="right">Vencimiento Seleccionado</td><td align="center">{$vence}</td></tr>
<tr><td align="right">Pagado el día</td><td align="center">{$pago}</td></tr>
<tr><td align="right"><b>TOTAL</b></td><th align="center">{$pagar}</th></tr>
ETIQUETA;

?>
<table style="width:500px">
<?php
if ($boletafondo->getPago()==null) {echo $sinpagar;} else {echo $pagado;}
?>
</table>
</div>
<br><br>
</center>
