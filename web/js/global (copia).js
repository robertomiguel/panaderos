function $id(id){return document.getElementById(id);}

function validarcuit(cuil) {
  var c = cuil.replace(/-/g,'');
    if (c.length==11){
      if (validaCuit(c)){
        $.get("/crearboleta/empnombre", { cuil: c, idbol: idb},
  function(data){
var respuesta = data.split("|");
var nombre = respuesta[0];
var info = respuesta[1];
if (info==0){
  empId = respuesta[2];
  $('#verNombre').html(nombre);
  $('#salario').focus();
}
if (info==1){
msg('El empleado: '+ nombre +'<br> ya existe en esta boleta.','CUIL: '+$('#cuil').val());
  $('#cuil').attr('value','');
  $('#verNombre').html('ingrese un CUIL');
  $('#cuil').focus();
}
if (info==2){
  $('#verNombre').html(nombre);
  empId=-1;
}
        });

      } else {$('#verNombre').html('CUIL no válido');}
    }  else {$('#verNombre').html('ingrese un CUIL');empId=0;}
}
function validaCuit(cuit) {
        if (typeof (cuit) == 'undefined')
            return true;
        cuit = cuit.toString().replace(/[-_]/g, "");
        if (cuit == '')
            return true; //No estamos validando si el campo esta vacio, eso queda para el "required"
        if (cuit.length != 11)
            return false;
        else {
            var mult = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
            var total = 0;
            for (var i = 0; i < mult.length; i++) {
                total += parseInt(cuit[i]) * mult[i];
            }
            var mod = total % 11;
            var digito = mod == 0 ? 0 : mod == 1 ? 9 : 11 - mod;
        }
      return digito == parseInt(cuit[10]);
  }
function cambiarVencimiento(v){
$.get("/crearboleta/nuevovencimiento", { fecha: v, idbol: $id('blt').value},
  function(data){
      window.location.href = window.location.href;
  });

}

function cambiarVencimientofondo(v){
$.get("/crearboleta/nuevovencimientofondo", { fecha: v, idbol: $id('bltf').value},
  function(data){
var mensaje = data.split("|");
$('#atrasofondo').html(mensaje[1]);
//msg(mensaje[0],'Vencimiento');
//$('#fechadepagofondo').attr('value',mensaje[0]);
      window.location.href = window.location.href;
  });
}

function msg(mensajeTexto,titulo) {
//alert('hola');
var $dialog = $('<div></div>')
  .html(mensajeTexto)
  .dialog({
	autoOpen: false,
	title: titulo,
	modal: true,
	width: 460,
	buttons: { "Aceptar": function() { $(this).dialog("close"); } }
	});
$dialog.dialog('open');
}

function agregaremp(idbol) {
idb = idbol;empId=0;
$.get("/crearboleta/formEmpSin",
  function(data){
 $dialog = $('<div></div>')
  .html(data)
  .dialog({
	autoOpen: false,
	title: 'Agregar Empleado',
	modal: true,
	width: 460,
	resizable: false,
	buttons: [
    {
        text: "Agregar",
        click: function() { grabar(); }
    },
//    {
//        text: "Ayuda",
//        click: function() {msg('Texto de la ayuda','Ayuda'); }
//    },
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    }
] 
	});
$dialog.dialog('open');
$("#"+idb).attr("onClick","reopen();");
  });
}

function reopen(){
$("#cuil").attr("value","");
$('#verNombre').html("Ingresar CUIL para ver el nombre");
$("#salario").attr("value","");
$dialog.dialog('open');
}

function grabar(){
if (empId>0){
var salari = $('#salari').val();
if (salari<0){msg('El Salario no puede ser menos que cero.','Aviso');return;}
//  msg("se graba empid: " + empId + " en id_bol: " + idb + " $" + salario,'Agregar');
  $.get("/crearboleta/grabarempsin", { idbol: idb, idemp: empId, salario: salari},
	function(data){
	if(data="ok"){window.location.href = window.location.href;}
	msg(data);
	});
return;}
else if (empId==0){msg("Ingresar un CUIL válido antes de agregar un empleado.",'Aviso');return;}
else if (empId==-1){msg("El CUIL no está registrado.",'Aviso');return;}
//$dialog.dialog("close");
}

function cambiarmaza(){
$mazabox = $('<div></div>')
  .html('<center>Declarar totalidad de salarios<br><input type="text" id="nuevamaza"></center>')
  .dialog({
	autoOpen: false,
	title: 'Maza Salarial',
	modal: true,
	width: 460,
	resizable: false,
	buttons: [
    {
        text: "Aceptar",
        click: function() { grabarmaza(); }
    },
//    {
//        text: "Ayuda",
//        click: function() {msg('Texto de la ayuda','Ayuda'); }
//    },
    {
        text: "Cancelar",
        click: function() { $(this).dialog("close"); }
    }
] 
	});
$mazabox.dialog('open');
//$('#nuevamaza').attr('value','hola');
$("#btnmaza").attr("onClick","reopenmaza();");
reopenmaza();
}

function reopenmaza(){
$.get("/crearboleta/vermaza", { idbol: $id('bltf').value},
  function(data){
$('#nuevamaza').attr('value',data);
  });
$mazabox.dialog('open');
}

function grabarmaza(){
$.get("/crearboleta/nuevamaza", { idbols: $id('blt').value, idbol: $id('bltf').value, valor: $id('nuevamaza').value},
  function(data){
window.location.href = window.location.href;
  });
$mazabox.dialog('close');
}
