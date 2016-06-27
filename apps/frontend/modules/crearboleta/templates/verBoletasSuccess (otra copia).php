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
$DiasRecargo = Formatos::restarfecha(Formatos::primervencimiento($boletafondo->getPeriodo()),Formatos::fecha($boletafondo->getVencimiento()));
?>
<script>
$(document).ready(function(){$("#ordenar").tablesorter();}); 

jQuery(document).ready(function($){
 $('#ordenar').tableScroll({height:400});
 $('#fechadepago').datepicker({regional:'es',minDate: '<?php
$tmp = Formatos::primervencimiento($boletasindical->getPeriodo());
$primervencimiento = substr($tmp,6,4).substr($tmp,3,2).substr($tmp,0,2);
if (date('Ymd') < $primervencimiento) {echo $tmp;} else {echo date("d/m/Y");}?>',
   maxDate: '+1y',showOn: 'both',buttonText: 'Cambiar',autoSize: true,
//   changeYear: true
   beforeShowDay: function (day) {var day = day.getDay();
if (day == 6 || day == 0) {return [false, "somecssclass"]
} else {return [true, "someothercssclass"]}} });

 $('#fechadepagofondo').datepicker({regional:'es',minDate: '<?php
$tmp = Formatos::primervencimiento($boletafondo->getPeriodo());
$primervencimiento = substr($tmp,6,4).substr($tmp,3,2).substr($tmp,0,2);
if (date('Ymd') < $primervencimiento) {echo $tmp;} else {echo date("d/m/Y");}?>',
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
<div  class="boleta1 tablaRecuadro">
<div class="tituloTabla">Fondo Convencional Ordinario</div>
Primer Vencimiento <?php echo Formatos::primervencimiento($boletafondo->getPeriodo()) ?><br>
Masa salarial <span id="maza">0,00</span> <input type="button" id="btnmaza" value="Modificar" onClick="cambiarmaza()"><br>
Nuevo Vencimiento <input type="text" id="fechadepagofondo" onChange="cambiarVencimientofondo(this.value)"
value="<?php echo Formatos::fecha($boletafondo->getVencimiento())?>" readonly><br>
Cuota 3% <b><span id="mazacuota">0,00</span></b><br>
Días de recargo: <span id="atrasofondo"><?php echo $DiasRecargo ?></span>
<br><a href="/crearboleta/printboletafondo/id/<?php echo $idbolf ?>">>Click aquí para IMPRIMIR/DESCARGAR<</a>
</div>
<br>
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
{echo   "<td align='center'><a href=".url_for('empbolsin/edit')."/id/".$empleado->getId() .'"><img src="/images/editar.png"></td>';
}
?>
  </tr>
 <?php 
$total = $total + $empleado->getSalario();
$cep = $cep+$sepelio;
$cuotaSindi = $cuotaSindi+$cuota;
endforeach;
if ($total>$boletafondo->getMaza()){
$boletafondo->setMaza($total);
$boletafondo->save();
}
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
$TotalEmp = count($empbolsin);
$Total = Formatos::moneda($total);
$TotalSep = Formatos::moneda($cep);
$TotalSin = Formatos::moneda($cuotaSindi);
$Total1 = Formatos::moneda($cuotaSindi+$cep);
$Fecha1 = Formatos::primervencimiento($boletasindical->getPeriodo());
$FechaVence = Formatos::fecha($boletasindical->getVencimiento());
$DiasRecargo = Formatos::restarfecha(Formatos::primervencimiento($boletasindical->getPeriodo()),Formatos::fecha($boletasindical->getVencimiento()));
$Recargo = Formatos::moneda((($Total1)*(36/365))/100);
$TotalFinal = Formatos::moneda($cuotaSindi+$cep);
$bolid = $boletasindical->getId();

$sinpagar = <<<ETIQUETA
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
   <td colspan="2" class="subtop" align="center">{$Total1}</td>
  </tr>
  <tr>
   <td align="right" colspan="3">Primer Vencimiento {$Fecha1}
   </td>
   <td align="center" colspan="2">{$Total1}</td>
  </tr>
<tr>
   <td align="right" colspan="3">Nuevo Vencimiento
<input type="text" id="fechadepago" onChange="cambiarVencimiento(this.value)"
value="{$FechaVence}" readonly>
 Días de Recargo: <span id="atraso">{$DiasRecargo}</span></td>
   <td align="center"></td><td align="center"></td>
  </tr>
  <tr>
   <td align="right" colspan="3"><b>TOTAL</b></td>
   <th align="center" colspan="2">{$TotalFinal}</th>
   <td></td>
  </tr>
<tr>
<td colspan="4" align="right"><a href="/crearboleta/printboleta/id/{$bolid}">>Click aquí para IMPRIMIR/DESCARGAR<</a><td></tr>
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
   <td colspan="2" class="subtop" align="center">{$Total1}</td>
  </tr>
   <tr>
   <td align="right" colspan="3">Vencimiento</td>
   <td colspan="2" align="center">{$Fecha1}</td>
  </tr>
   <tr>
   <td align="right" colspan="3">Recargo</td>
   <td colspan="2" align="center">{$Recargo}</td>
  </tr>
  <tr>
   <td align="right" colspan="3"><b>PAGADO</b></td>
   <th align="center" colspan="2">{$FechaPagado}</th>
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
</center>
<?php
echo 'sindical<br>';
$totales = Sindical::pagar($idbol);
echo 'masa: '.$totales['masa'].'<br>';
echo 'cuota: '.$totales['cuota'].'<br>';
echo 'sepelio: '.$totales['sepelio'].'<br>';
echo 'total: '.$totales['total'].'<br>';
echo 'dias: '.$totales['dias'].'<br>';
echo 'tasa: '.$totales['tasa'].'<br>';
echo 'recargo: '.$totales['recargo'].'<br>';
echo 'pagar: '.$totales['pagar'];
echo '<br>fondo<br>';
$totales = Fondo::pagar($idbolf);
echo 'masa: '.$totales['masa'].'<br>';
echo 'cuota: '.$totales['cuota'].'<br>';
echo 'dias: '.$totales['dias'].'<br>';
echo 'tasa: '.$totales['tasa'].'<br>';
echo 'recargo: '.$totales['recargo'].'<br>';
echo 'pagar: '.$totales['pagar'];

?>
