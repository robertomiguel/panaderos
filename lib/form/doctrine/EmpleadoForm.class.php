<?php

/**
 * Empleado form.
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EmpleadoForm extends BaseEmpleadoForm
{
  public function configure()
  {
    $this->setDefault('created_at', date("Y-m-d G:i"));
    $this->setDefault('updated_at', date("Y-m-d G:i"));
  }
}
