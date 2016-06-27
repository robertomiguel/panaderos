<?php

/**
 * Pagado form base class.
 *
 * @method Pagado getObject() Returns the current form's model object
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePagadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'empleador_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empleador'), 'add_empty' => false)),
      'tipo'         => new sfWidgetFormInputCheckbox(),
      'periodo'      => new sfWidgetFormDate(),
      'vencimiento'  => new sfWidgetFormDate(),
      'diadepago'    => new sfWidgetFormDate(),
      'pago'         => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empleador_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empleador'))),
      'tipo'         => new sfValidatorBoolean(array('required' => false)),
      'periodo'      => new sfValidatorDate(array('required' => false)),
      'vencimiento'  => new sfValidatorDate(array('required' => false)),
      'diadepago'    => new sfValidatorDate(array('required' => false)),
      'pago'         => new sfValidatorNumber(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pagado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pagado';
  }

}
