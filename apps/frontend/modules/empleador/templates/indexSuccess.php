<h1>Empleadors List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Localidad</th>
      <th>Cuit</th>
      <th>Nombre</th>
      <th>Domicilio</th>
      <th>Baja</th>
      <th>Sf guard user</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($empleadors as $empleador): ?>
    <tr>
      <td><a href="<?php echo url_for('empleador/show?id='.$empleador->getId()) ?>"><?php echo $empleador->getId() ?></a></td>
      <td><?php echo $empleador->getLocalidadId() ?></td>
      <td><?php echo $empleador->getCuit() ?></td>
      <td><?php echo $empleador->getNombre() ?></td>
      <td><?php echo $empleador->getDomicilio() ?></td>
      <td><?php echo $empleador->getBaja() ?></td>
      <td><?php echo $empleador->getSfGuardUserId() ?></td>
      <td><?php echo $empleador->getCreatedAt() ?></td>
      <td><?php echo $empleador->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('empleador/new') ?>">New</a>
