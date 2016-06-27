<?php

/**
 * BaseBoletaSindical
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empleador_id
 * @property date $periodo
 * @property date $vencimiento
 * @property date $pago
 * @property Empleador $Empleador
 * @property Doctrine_Collection $BolSin
 * 
 * @method integer             getEmpleadorId()  Returns the current record's "empleador_id" value
 * @method date                getPeriodo()      Returns the current record's "periodo" value
 * @method date                getVencimiento()  Returns the current record's "vencimiento" value
 * @method date                getPago()         Returns the current record's "pago" value
 * @method Empleador           getEmpleador()    Returns the current record's "Empleador" value
 * @method Doctrine_Collection getBolSin()       Returns the current record's "BolSin" collection
 * @method BoletaSindical      setEmpleadorId()  Sets the current record's "empleador_id" value
 * @method BoletaSindical      setPeriodo()      Sets the current record's "periodo" value
 * @method BoletaSindical      setVencimiento()  Sets the current record's "vencimiento" value
 * @method BoletaSindical      setPago()         Sets the current record's "pago" value
 * @method BoletaSindical      setEmpleador()    Sets the current record's "Empleador" value
 * @method BoletaSindical      setBolSin()       Sets the current record's "BolSin" collection
 * 
 * @package    panaderos
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBoletaSindical extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('boleta_sindical');
        $this->hasColumn('empleador_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('periodo', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('vencimiento', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('pago', 'date', null, array(
             'type' => 'date',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Empleador', array(
             'local' => 'empleador_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('EmpBolSin as BolSin', array(
             'local' => 'id',
             'foreign' => 'boletasindical_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}