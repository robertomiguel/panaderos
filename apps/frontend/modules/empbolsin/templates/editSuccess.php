<h1>Editar Empleado</h1>
<br>
<center>
<div class="login">
<table>
<tr>
<td>CUIL: <?php echo $empleado->getEmpleado()->getCuil(); ?></td>
<tr>
<tr>
<td><?php echo $empleado->getEmpleado()->getNombre(); ?></td>
<tr>
<?php include_partial('form', array('form' => $form)) ?>
</div>
<br>
<div class="logo">
<img src ="/images/pancitologo.jpg">
</div>
</center>
<div class="pie">
<hr>
<p>Mendoza 654 - C.P. (2000) - Rosario - Argentina - TEL/FAX +54 (0341)-4213647
</p>
<br>
</div>
</center>

