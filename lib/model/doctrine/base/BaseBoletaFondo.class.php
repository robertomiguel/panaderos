<?php

/**
 * BaseBoletaFondo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empleador_id
 * @property date $periodo
 * @property date $vencimiento
 * @property date $pago
 * @property decimal $maza
 * @property Empleador $Empleador
 * @property Doctrine_Collection $BolFon
 * 
 * @method integer             getEmpleadorId()  Returns the current record's "empleador_id" value
 * @method date                getPeriodo()      Returns the current record's "periodo" value
 * @method date                getVencimiento()  Returns the current record's "vencimiento" value
 * @method date                getPago()         Returns the current record's "pago" value
 * @method decimal             getMaza()         Returns the current record's "maza" value
 * @method Empleador           getEmpleador()    Returns the current record's "Empleador" value
 * @method Doctrine_Collection getBolFon()       Returns the current record's "BolFon" collection
 * @method BoletaFondo         setEmpleadorId()  Sets the current record's "empleador_id" value
 * @method BoletaFondo         setPeriodo()      Sets the current record's "periodo" value
 * @method BoletaFondo         setVencimiento()  Sets the current record's "vencimiento" value
 * @method BoletaFondo         setPago()         Sets the current record's "pago" value
 * @method BoletaFondo         setMaza()         Sets the current record's "maza" value
 * @method BoletaFondo         setEmpleador()    Sets the current record's "Empleador" value
 * @method BoletaFondo         setBolFon()       Sets the current record's "BolFon" collection
 * 
 * @package    panaderos
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBoletaFondo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('boleta_fondo');
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
        $this->hasColumn('maza', 'decimal', 8, array(
             'type' => 'decimal',
             'notnull' => true,
             'default' => 0,
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Empleador', array(
             'local' => 'empleador_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('EmpBolFon as BolFon', array(
             'local' => 'id',
             'foreign' => 'boletafondo_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}