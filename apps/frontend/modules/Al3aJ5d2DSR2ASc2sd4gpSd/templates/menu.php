<link rel="stylesheet" type="text/css" href="/css/menu.css" media="screen" />
<script>
$dialogperiodos = $('<div></div>')
  .html("<center>Crea nuevo período para TODOS<br>\
<br>Generar período: <input type='text' id='fperiodo' value='<?php echo date('01/m/Y') ?>'>\
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
        text: "Crear",
        click: function() {
$(".piensa").css("display","block"); 
	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/crearperiodos", { fperiodo: $('#fperiodo').val()},
	function(data){
alert(data);
	window.location.href = window.location.href;

	});
}}]
});

$dialogindustrial = $('<div></div>')
  .html("<center>Nuevo usuario industriales<br>\
<br>Usuario: <input type='text' id='inombre' value=''>\
<br>Contraseña: <input type='text' id='ipass' value='panaderos2012'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Usuario indrustriales",
	modal: true,
	width: 560,
	buttons: [
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Agregrar",
        click: function() {
	$.get("/industriales/nuevoindustrial", { iusuario: $('#inombre').val(), ipass: $('#ipass').val()},
	function(data){
alert(data);
//	window.location.href = window.location.href;
$dialogindustrial.dialog('close');

	});
}}]
});

//$dialogliquidar.dialog('open');
 $('#fperiodo').datepicker({
regional:'es',
minDate: '01/09/2011',
maxDate: '01/01/2020',
showOn: 'both',
buttonText: 'Seleccionar',
autoSize: true,
changeYear: true,
changeMonth: true
});

function crearperiodo(){
$dialogperiodos.dialog('open');
}
function nuevoindustrial(){
$dialogindustrial.dialog('open');
}
function checkmasa(){
$(".piensa").css("display","block");
$(".piensa").html("Pensando... <img src='/images/loader.gif'>");

	$.get("/Al3aJ5d2DSR2ASc2sd4gpSd/actualizarmasa",
	function(data){
alert(data);
	window.location.href = window.location.href;
	});
}
//<td onclick="javascript:alert('a')"><a href="javascript:crearperiodo()"><img src="/images/c2.gif"></a><br>Crear Períodos</td>
function nuevoempleador(){
window.location.href = "<?php echo url_for('empleador/new') ?>";
}
function empleados(){
window.location.href = "<?php echo url_for('empleado/index') ?>";
}
function industriales(){
window.location.href = "/industriales/index";
}
function restaurapass(eid){
$dialogrestaura.dialog('open');
empleadorId = eid;
}
function pagos(){
window.location.href = "/pagos/index";
}
function empleadores(){
window.location.href = "/Al3aJ5d2DSR2ASc2sd4gpSd/index";
}
function sindical(){
window.location.href = "/pagos/sindical";
}

</script>

<div class="menu">
<table>
<tr>
<td onclick="crearperiodo()"><img src="/images/c2.gif"><br>Crear Períodos</td>
<td onclick="nuevoempleador()"><img src="/images/c2.gif"><br>Nuevo Empleador</td>
<td onclick="checkmasa()" ><img id="x" src="/images/c2.gif"><br>Actualiza Masa</td>
<th rowspan="3" width="10px">M<br>E<br>N<br>U</th>
</tr>
<tr>
<td onclick="empleados()"><img src="/images/c2.gif"><br>Empleados</td>
<td onclick="sindical()"><img src="/images/c2.gif"><br>Pagados<br>Sindical</td>
<td onclick="pagos()"><img src="/images/c2.gif"><br>Gestión<br>de pagos</td>
</tr>
<tr>
<td onclick="industriales()"><img src="/images/c2.gif"><br>Industriales</td>
<td onclick="nuevoindustrial()"><img src="/images/c2.gif"><br>Nuevo Industrial</td>
<td onclick="empleadores()"><img src="/images/c2.gif"><br>Lista<br>Empleadores</td>
</tr>
</table>
</div>
