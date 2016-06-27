<script>
$dialogbaja = $('<div></div>')
  .html("<center>Baja lógica del empleador<br>\
<br>Fecha de la baja: <input type='text' id='fbaja' value='<?php echo date('d/m/Y') ?>'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Crear Períodos",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Alta",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/quitarbaja", { uid: uid},
	function(data){
alert(data);
	window.location.href = window.location.href;

	});
}
    },
    {
        text: "Baja",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/baja", { lid: lid, uid: uid, fbaja: $('#fbaja').val()},
	function(data){
alert(data);
	window.location.href = window.location.href;

	});
}}]
});

$dialoglogin = $('<div></div>')
  .html("<center>¿Permitir login del usuario?<br></center>")
  .dialog({
	autoOpen: false,
	title: "Control de acceso",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "NO",
        click: function() { $.get("/Al3aJ5d2DSR2ASc2sd4gpSd/login", { lid: lid, accion: "0"},
	function(data){
	window.location.href = window.location.href;
	}); }
    },
    {
        text: "SI",
        click: function() {
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/login", { lid: lid, accion: "1"},
	function(data){
	window.location.href = window.location.href;
	});
}}]
});

$dialogrestaura = $('<div></div>')
  .html("<center>Nueva contraseña<br>\
<br><input type='text' id='npass' value='rosario'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Contraseña de empleador",
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
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/restaurapass", { eid: empleadorId, pnuevo: $('#npass').val()},
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}}]
});

 $('#fbaja').datepicker({
regional:'es',
minDate: '01/01/2009',
maxDate: '01/01/2020',
showOn: 'button',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});

function baja(id,idl){
uid = id;
lid = idl;
$dialogbaja.dialog('open');
}
function login(id){
lid = id;
$dialoglogin.dialog('open');
}

function cambiapass(){
$dialogpass.dialog('open');
}
</script>

<h1>Administración</h1>
<div class="menuTemplate">
<center>Total de empleadores: <?php echo count($empleadores) ?></center>
</div>
<div style="position:absolute;left:25px" class="zoom">
<table id="ordenar">
<thead>
<th>ID</th><th>CUIT</th><th>NOMBRE</th><th>Fecha<br>Baja</th><th>Ult. Login</th><th>pass</th><th>Login</th><th>Borrar<br>Restaurar</th>
</thead>
<tbody>
<?php foreach($empleadores as $empleador):?>

<tr>
<td><?php echo $empleador->getId() ?></td>
<td><a href="<?php echo '/empleador/show/id/'.$empleador->getId() ?>"><?php echo Formatos::guiones($empleador->getCuit()) ?></td>
<td><a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/detalleEmpleador').'/id/'.$empleador->getId() ?>"><?php echo $empleador->getNombre() ?></td>
<td align="center"><?php echo Formatos::fecha($empleador->getBaja()) ?></td>

<td title="<?php echo $empleador->getUser()->getLastLogin() ?>" align="center"><?php echo Formatos::tiempo($empleador->getUser()->getLastLogin()) ?></td>

<td align="center"><a href="javascript:restaurapass(<?php echo $empleador->getId() ?>)"><img src="/images/key.gif"></a></td>
<td align="center"><a href="javascript:login(<?php echo $empleador->getSfGuardUserId() ?>)"><img src="<?php
if ( Login::check( $empleador->getSfGuardUserId() ) ) {
 echo '/images/si.png';} else {echo '/images/no.png';}
?>"></a></td>
<td align="center"><a href="javascript:baja(<?php echo $empleador->getId().','.$empleador->getSfGuardUserId() ?>)"><img src="/images/borrar.png"></a></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<div class="piensa"><div>
