<?php

/**
 * BoletaFondo form base class.
 *
 * @method BoletaFondo getObject() Returns the current form's model object
 *
 * @package    panaderos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBoletaFondoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'empleador_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empleador'), 'add_empty' => false)),
      'periodo'      => new sfWidgetFormDate(),
      'vencimiento'  => new sfWidgetFormDate(),
      'pago'         => new sfWidgetFormDate(),
      'maza'         => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empleador_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empleador'))),
      'periodo'      => new sfValidatorDate(array('required' => false)),
      'vencimiento'  => new sfValidatorDate(array('required' => false)),
      'pago'         => new sfValidatorDate(array('required' => false)),
      'maza'         => new sfValidatorNumber(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('boleta_fondo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BoletaFondo';
  }

}
