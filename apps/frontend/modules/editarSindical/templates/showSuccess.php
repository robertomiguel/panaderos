<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $boleta_sindical->getId() ?></td>
    </tr>
    <tr>
      <th>Empleador:</th>
      <td><?php echo $boleta_sindical->getEmpleadorId() ?></td>
    </tr>
    <tr>
      <th>Periodo:</th>
      <td><?php echo $boleta_sindical->getPeriodo() ?></td>
    </tr>
    <tr>
      <th>Vencimiento:</th>
      <td><?php echo $boleta_sindical->getVencimiento() ?></td>
    </tr>
    <tr>
      <th>Pago:</th>
      <td><?php echo $boleta_sindical->getPago() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $boleta_sindical->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $boleta_sindical->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('editarSindical/edit?id='.$boleta_sindical->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('editarSindical/index') ?>">List</a>
