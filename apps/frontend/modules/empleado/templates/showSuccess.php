<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $empleado->getId() ?></td>
    </tr>
    <tr>
      <th>Cuil:</th>
      <td><?php echo $empleado->getCuil() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $empleado->getNombre() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $empleado->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $empleado->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('empleado/edit?id='.$empleado->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('empleado/index') ?>">List</a>
