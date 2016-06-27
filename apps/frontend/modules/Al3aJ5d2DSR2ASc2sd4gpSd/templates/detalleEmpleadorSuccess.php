<script>
$(document).ready(function(){$("#ordenar").tablesorter();}); 

function versindical(id) {
 $.get("/Al3aJ5d2DSR2ASc2sd4gpSd/verDetalleSin", {idbol: id},
 function(data){alert(data);});
}
function verfondo(id) {
 $.get("/Al3aJ5d2DSR2ASc2sd4gpSd/verDetalleFon", {idbol: id},
 function(data){alert(data);});
}
$dialogpagarsin = $('<div></div>')
  .html("<center>DATOS DE LA BOLETA PAGADA<br><br>Fecha de vencimiento\
<br><input type='text' id='fvencesin' value='<?php echo date('d/m/Y') ?>'>\
<br><br>Fecha de pago\
<br><input type='text' id='fpagosin' value='<?php echo date('d/m/Y') ?>'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Pagar sindical",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "Sin pagar",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/sinpagarsin", { sid: idsindical},
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}},
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Pagada",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/pagarsin", { sid: idsindical, fpago: $('#fpagosin').val(), fvence: $('#fvencesin').val()},
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}}]
});
 $('#fpagosin').datepicker({
regional:'es',
minDate: '01/09/2011',
maxDate: '01/01/2020',
showOn: 'button',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});
 $('#fvencesin').datepicker({
regional:'es',
minDate: '01/09/2011',
maxDate: '01/01/2020',
showOn: 'button',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});
function pagarsin(sid,fs){
idsindical = sid;
$('#fvencesin').attr("value",fs);
$dialogpagarsin.dialog('open');
}

$dialogpagarfon = $('<div></div>')
  .html("<center>DATOS DE LA BOLETA PAGADA<br><br>Fecha de vencimiento<br>\
<br><input type='text' id='fvencefon' value='<?php echo date('d/m/Y') ?>'>\
<br><br>Fecha de pago\
<br><input type='text' id='fpagofon' value='<?php echo date('d/m/Y') ?>'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Pagar fondo",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "Sin pagar",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/sinpagarfon", { fid: idfondo},
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}},
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Pagada",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/pagarfon", { fid: idfondo, fpago: $('#fpagofon').val(), fvence: $('#fvencefon').val()},
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}}]
});
 $('#fpagofon').datepicker({
regional:'es',
minDate: '01/09/2011',
maxDate: '01/01/2020',
showOn: 'button',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});
 $('#fvencefon').datepicker({
regional:'es',
minDate: '01/09/2011',
maxDate: '01/01/2020',
showOn: 'button',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});
function pagarfon(fid,ff){
idfondo = fid;
$('#fvencefon').attr("value",ff);
$dialogpagarfon.dialog('open');
}

</script>
<h1>Administración: Detalle Empleador</h1>
<br>
<a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/index') ?>">Empleadores</a>
<table>
<tr>
<th>ID</th><td><?php echo $empleador->getId() ?></td>
<th>Cuit</th><td><?php echo Formatos::guiones($empleador->getCuit()) ?></td>
<th>Nombre</th><td><?php echo $empleador->getNombre() ?></td>
</tr>
</table>

<center>
<table class="tablaRecuadro" id="tablaPeriodo">
<tr>
<td  width="450px">
<table id="ordenar">
 <thead>
   <caption>Sindical</caption>
   <th>Editar</th>
   <th>Período</th>
   <th>Vencimiento</th>
   <th>Pagada</th>
   <th>Cuota</th>
 </thead>
 <tbody>
    <?php
foreach($boletasindical as $boleta):
$totales = Sindical::pagar($boleta->getId());
?>
<tr>
<td><a href="<?php echo '/crearboleta/verBoletasAdmin/id/'.$boleta->getId().'/eid/'.$boleta->getEmpleadorId() ?>">Editar</a></td>
<td><?php echo Formatos::periodo($boleta->getPeriodo()) ?></td>
<td><a href="<?php echo url_for('editarSindical/edit').'/id/'.$boleta->getId() ?>"><?php echo Formatos::fecha($boleta->getVencimiento()) ?></td>
<td><?php echo Formatos::fecha($boleta->getPago()) ?></td>
<td><a href="javascript:versindical('<?php echo $boleta->getId() ?>')"><?php echo Formatos::moneda($totales['pagar']) ?></a></td>
<td><a href="javascript:pagarsin(<?php echo $boleta->getId() ?>,'<?php echo Formatos::fecha($boleta->getVencimiento()) ?>')">pagar</a></td>
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
<th>Cuota</th>
</thead>
<tbody>
<?php foreach($boletafondo as $boletaFon):
$totales = Fondo::pagar($boletaFon->getId());
?>
<tr>
<td><?php echo Formatos::fecha($boletaFon->getVencimiento()) ?></td>
<td><?php echo Formatos::fecha($boletaFon->getPago()) ?></td>
<td><a href="javascript:verfondo('<?php echo $boletaFon->getId() ?>')"><?php echo Formatos::moneda($totales['pagar']) ?></a></td>
<td><a href="javascript:pagarfon(<?php echo $boletaFon->getId() ?>,'<?php echo Formatos::fecha($boletaFon->getVencimiento()) ?>')">pagar</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</td>
</tr>

</table>
</center>
