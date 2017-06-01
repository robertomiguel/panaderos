<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>

<link rel="stylesheet" type="text/css" href="/css/jquery-ui-1.8.16.custom.css" media="screen" />

<script src="/js/global.js"></script>
<script src="/js/jquery.ui.datepicker-es.js"></script>
<script src="/js/jquery.tablesorter.min.js"></script>
<script src="/js/jquery.tablescroll.js"></script>
<script>
$(document).ready(function(){
$dialogpass = $('<div></div>')
  .html("<center>Cambiar Contraseña<br>\
<br>Clave actual:<br><input type='password' id='pactual'>\
<br>Nueva Clave:<br><input type='password' id='pnuevo'>\
<br>Confirmar:<br><input type='password' id='pconfirmar'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Cambiar contraseña",
	modal: true,
	width: 460,
	buttons: [
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    },
    {
        text: "Cambiar",
        click: function() {
	$.get("/empleador/nuevopass", { pactual: $('#pactual').val(), pnuevo: $('#pnuevo').val(), pconfirmar: $('#pconfirmar').val()},
	function(data){
alert(data);
if (data=="Contraseña cambiada"){
$dialogpass.dialog("close");
	window.location.href = window.location.href;}
	});
}}]
});
});
function cambiapass(){
$dialogpass.dialog('open');
}
</script>

  <body>
<div class="fechaServer">
<?php
setlocale(LC_TIME, "es_ES");
echo utf8_encode(strftime("%A %e de %B del %Y"));
//$id = $this->getUser()->getGuardUser()->getEmpleador()->getId();
if ($sf_user->isAuthenticated()) {
  echo ' - Usuario: <b>'.$sf_user->getUsername().'</b>';
  echo ' - Empleador: <b>'.Formatos::textoCool($sf_user->getGuardUser()->getEmpleador()->getNombre()).'</b>';
  echo ' - <a href="'.url_for('@sf_guard_signout').'">Desconectar</a>';
  echo ' - <a href="javascript:cambiapass()">cambiar contraseña</a>';
if($sf_user->getUsername()=='admin'){
include('../apps/frontend/modules/Al3aJ5d2DSR2ASc2sd4gpSd/templates/menu.php');
}}
?>
</div>

<div class="fondo">
 <div class="fondolista">
   <?php echo $sf_content ?>
 </div>
</div>
 </body>
</html>
