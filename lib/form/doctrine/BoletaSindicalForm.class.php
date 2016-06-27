<?php

/**
 * BoletaSindical form.
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BoletaSindicalForm extends BaseBoletaSindicalForm
{
  public function configure()
  {
    unSet($this['boletasindical_id']);
    unSet($this['empleador_id']);
    unSet($this['created_at']);
    unSet($this['updated_at']);
  }
}
