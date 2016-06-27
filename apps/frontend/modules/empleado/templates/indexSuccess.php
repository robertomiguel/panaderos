<h1>Lista de Empleados</h1>
  <a href="<?php echo url_for('empleado/new') ?>">Nuevo empleado</a>
 - <a href="<?php echo url_for('Al3aJ5d2DSR2ASc2sd4gpSd/index') ?>">Empleadores</a>
<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Cuil</th>
      <th>Nombre</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($empleados as $empleado): ?>
    <tr>
      <td><a href="<?php echo url_for('empleado/edit?id='.$empleado->getId()) ?>"><?php echo $empleado->getId() ?></a></td>
      <td><?php echo $empleado->getCuil() ?></td>
      <td><?php echo $empleado->getNombre() ?></td>
      <td><?php echo $empleado->getCreatedAt() ?></td>
      <td><?php echo $empleado->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
