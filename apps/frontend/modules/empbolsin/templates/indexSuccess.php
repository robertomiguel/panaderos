<h1>Empbolsins List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Empleado</th>
      <th>Boletasindical</th>
      <th>Salario</th>
      <th>Sepelio</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($empbolsins as $empbolsin): ?>
    <tr>
      <td><a href="<?php echo url_for('empbolsin/show?id='.$empbolsin->getId()) ?>"><?php echo $empbolsin->getId() ?></a></td>
      <td><?php echo $empbolsin->getEmpleadoId() ?></td>
      <td><?php echo $empbolsin->getBoletasindicalId() ?></td>
      <td><?php echo $empbolsin->getSalario() ?></td>
      <td><?php echo $empbolsin->getSepelio() ?></td>
      <td><?php echo $empbolsin->getCreatedAt() ?></td>
      <td><?php echo $empbolsin->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('empbolsin/new') ?>">New</a>
