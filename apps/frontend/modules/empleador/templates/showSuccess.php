<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $empleador->getId() ?></td>
    </tr>
    <tr>
      <th>Localidad:</th>
      <td><?php echo $empleador->getLocalidad()->getNombre() ?></td>
    </tr>
    <tr>
      <th>Cuit:</th>
      <td><?php echo $empleador->getCuit() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $empleador->getNombre() ?></td>
    </tr>
    <tr>
      <th>Domicilio:</th>
      <td><?php echo $empleador->getDomicilio() ?></td>
    </tr>
    <tr>
      <th>Baja:</th>
      <td><?php echo $empleador->getBaja() ?></td>
    </tr>
    <tr>
      <th>Sf guard user:</th>
      <td><?php echo $empleador->getSfGuardUserId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $empleador->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $empleador->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('empleador/edit?id='.$empleador->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('empleador/index') ?>">List</a>
