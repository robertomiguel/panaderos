<?php

/**
 * EmpBolSin form.
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EmpBolSinForm extends BaseEmpBolSinForm
{
  public function configure()
  {
//$this->widgetSchema['plan_id'] = new sfWidgetFormInputHidden();
unSet($this['empleado_id']);
unSet($this['salario']);
unSet($this['boletasindical_id']);
unSet($this['created_at']);
unSet($this['updated_at']);
  }
}
