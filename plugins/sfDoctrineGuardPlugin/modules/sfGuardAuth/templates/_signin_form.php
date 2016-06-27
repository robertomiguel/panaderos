<?php use_helper('I18N') ?>
<br>
<center>
<div class="login">
<center>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
         <center><input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
</center>
          
          <?php $routes = $sf_context->getRouting()->getRoutes() ?>
          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
            <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
          <?php endif; ?>

          <?php if (isset($routes['sf_guard_register'])): ?>
            &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
          <?php endif; ?>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
</center>
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

