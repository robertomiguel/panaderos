<?php

/**
 * Empleador form.
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EmpleadorForm extends BaseEmpleadorForm
{
  public function configure()
  {
    unSet($this['baja']);
    unSet($this['sf_guard_user_id']);
    $this->setDefault('created_at', date("Y-m-d G:i"));
    $this->setDefault('updated_at', date("Y-m-d G:i"));

$this->widgetSchema->setLabels(array(
	'cuit' => 'CUIT (sin guiones)<br>Usuario (max11 char)',
	'nombre' => 'Razon Social',
        'localidad_id'  => 'CP / Localidad'));

//----------------- autocompletado localidad
  $this->widgetSchema['localidad_id']->setOption(
     'renderer_class',
     'sfWidgetFormDoctrineJQueryAutocompleter'
  );
 
  $this->widgetSchema['localidad_id']->setOption(
    'renderer_options', 
    array(
	  'model' => 'Localidad',
	  'url'   => '/Al3aJ5d2DSR2ASc2sd4gpSd/buscarLocalidad',
	)
  );

  }
}
