<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $empbolsin->getId() ?></td>
    </tr>
    <tr>
      <th>Empleado:</th>
      <td><?php echo $empbolsin->getEmpleadoId() ?></td>
    </tr>
    <tr>
      <th>Boletasindical:</th>
      <td><?php echo $empbolsin->getBoletasindicalId() ?></td>
    </tr>
    <tr>
      <th>Salario:</th>
      <td><?php echo $empbolsin->getSalario() ?></td>
    </tr>
    <tr>
      <th>Sepelio:</th>
      <td><?php echo $empbolsin->getSepelio() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $empbolsin->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $empbolsin->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('empbolsin/edit?id='.$empbolsin->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('empbolsin/index') ?>">List</a>
