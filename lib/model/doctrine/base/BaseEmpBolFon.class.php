<?php

/**
 * BaseEmpBolFon
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empleado_id
 * @property integer $boletafondo_id
 * @property decimal $salario
 * @property Empleado $Empleado
 * @property BoletaFondo $BoletaFondo
 * 
 * @method integer     getEmpleadoId()     Returns the current record's "empleado_id" value
 * @method integer     getBoletafondoId()  Returns the current record's "boletafondo_id" value
 * @method decimal     getSalario()        Returns the current record's "salario" value
 * @method Empleado    getEmpleado()       Returns the current record's "Empleado" value
 * @method BoletaFondo getBoletaFondo()    Returns the current record's "BoletaFondo" value
 * @method EmpBolFon   setEmpleadoId()     Sets the current record's "empleado_id" value
 * @method EmpBolFon   setBoletafondoId()  Sets the current record's "boletafondo_id" value
 * @method EmpBolFon   setSalario()        Sets the current record's "salario" value
 * @method EmpBolFon   setEmpleado()       Sets the current record's "Empleado" value
 * @method EmpBolFon   setBoletaFondo()    Sets the current record's "BoletaFondo" value
 * 
 * @package    panaderos
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpBolFon extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('emp_bol_fon');
        $this->hasColumn('empleado_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('boletafondo_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('salario', 'decimal', 8, array(
             'type' => 'decimal',
             'notnull' => true,
             'default' => 0,
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Empleado', array(
             'local' => 'empleado_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('BoletaFondo', array(
             'local' => 'boletafondo_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}