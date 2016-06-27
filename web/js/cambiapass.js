$dialogpass = $('<div></div>')
  .html("<center>Cambiar Contraseña<br>\
<br>Clave actual: <input type='password' id='pactual'>\
<br>Nueva Clave: <input type='password' id='pnuevo'>\
<br>Confirmar: <input type='password' id='pconfirmar'>\
<br></center>")
  .dialog({
	autoOpen: false,
	title: "Cambiar contraseña",
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
	$.get("/empleador/nuevopass", { pactual: $('#pactual').val(), pnuevo: $('#pnuevo').val(), pconfirmar: $('#pconfirmar').val()},
	function(data){
alert(data);
if (data=="Contraseña cambiada"){
$dialogpass.dialog("close");
	window.location.href = window.location.href;}
	});
}}]
});

function cambiapass(){
$dialogpass.dialog('open');
}
