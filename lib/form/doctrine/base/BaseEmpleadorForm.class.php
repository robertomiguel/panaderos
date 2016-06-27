<?php

/**
 * Empleador form base class.
 *
 * @method Empleador getObject() Returns the current form's model object
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEmpleadorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'localidad_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Localidad'), 'add_empty' => false)),
      'cuit'             => new sfWidgetFormInputText(),
      'nombre'           => new sfWidgetFormInputText(),
      'domicilio'        => new sfWidgetFormInputText(),
      'baja'             => new sfWidgetFormDate(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'localidad_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Localidad'))),
      'cuit'             => new sfValidatorString(array('max_length' => 11)),
      'nombre'           => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'domicilio'        => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'baja'             => new sfValidatorDate(array('required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Empleador', 'column' => array('cuit')))
    );

    $this->widgetSchema->setNameFormat('empleador[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Empleador';
  }

}
