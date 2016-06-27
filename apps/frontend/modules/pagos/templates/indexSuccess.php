<script>
jQuery(document).ready(function($)
{
$("#ordenar").tablesorter( {sortList: [[0,1]]} );
$('#ordenar').tableScroll({height:600});
});

function borrar(f){
var r = confirm('Borrar archivo: "'+f+'"');
if(r){	$.get("/pagos/borrar", { archivo: f},
	function(data){
	window.location.href = window.location.href;
	});}
}

function parsear(f){
var r = confirm('Parsear archivo: "'+f+'"');
if(r){	$.get("/pagos/parsear", { zip: f},
	function(data){
	window.location.href = "/pagos/verparseo";
	});}
}

function verzip(z){
	$.get("/pagos/verzip", { zip: z},
	function(data){
	alert(data);
//	window.location.href = window.location.href;
	});
}
</script>
<h1>Gestión de cobranza</h1>
<br>
    <form action="/pagos/descarga" method="post" enctype="multipart/form-data">
      <input name="archivo" type="file" size="35" />
      <input name="enviar" type="submit" value="enviar" />
      <input name="action" type="hidden" value="upload" />     
    </form>
<br>
<table id="ordenar">
<thead>
<th>Nombre</th><th>Tamaño<br>Bytes</th><th>Fecha</th><th>Procesar</th><th>Eliminar</th>
</thead>
<tbody>
    <?php foreach ($archivos as $archivo): ?>
<tr>
<td><a href="<?php echo 'javascript:verzip(\''.$archivo['nombre'].'\')'; ?>"><?php echo $archivo['nombre']; ?></a></td>
<td align="right"><?php echo $archivo['bytes']; ?></td>
<td align="center"><?php echo $archivo['fecha']; ?></td>
<td align="center"><a href="<?php echo 'javascript:parsear(\''.$archivo['nombre'].'\')'; ?>">parsear</a></td>
<td align="center"><a href="<?php echo 'javascript:borrar(\''.$archivo['nombre'].'\')'; ?>"><img src="/images/borrar.png"></a></td>
</tr>
    <?php endforeach; ?>
</tbody>
</table>
