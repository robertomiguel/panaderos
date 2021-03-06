<?php

/**
 * LocalidadTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LocalidadTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object LocalidadTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Localidad');
    }
//--- autocompletado
public function retrieveForSelect($q, $limit)
  {

$qq = Doctrine_Query::create()
       ->select("l.id, concat(l.cp,' ',l.nombre) as todo" )
       ->from("localidad l")
       ->where('l.cp =?', $q)
       ->orWhere('l.nombre LIKE ?', "%$q%")
       ->limit($limit)->execute();
 
    return $qq->toKeyValueArray('id','todo');

}

}