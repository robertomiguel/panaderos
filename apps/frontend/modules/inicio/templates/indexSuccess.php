<style media="screen">
  .logos {
    width: 100%;
  }
  .logos img {
    position: absolute;
    left: 25%;
  }

  @media screen and (max-width: 500px) {
    .logos {
      position: absolute;
      top: 180px;
      width: auto;
    }
    .logos img {
      position: relative;
      width: 80%;
      left: 0;
    }
  }
</style>
<div class="iniciar">
  <div>Gestión de Pagos</div>
  <br>
  <a href="<?php echo url_for('crearboleta/index') ?>">Iniciar Sesión</a>
  <br><br><br>
  <a href="/images/autoridades.pdf" target="_blank">Listado Autoridades</a>
</div>

<div class="logos">
  <img src="/images/panlogo2.jpg">
</div>

<div class="pie">
 <hr>
  <p>Mendoza 654 - C.P. (2000) - Rosario - Argentina - TEL/FAX +54 (0341)-4213647</p>
 <br>
</div>
