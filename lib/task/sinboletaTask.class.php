<?php

class sinboletaTask extends sfBaseTask
{
  public function configure()
  {
    $this->namespace = 'sin';
    $this->name      = 'boleta';
    $this->briefDescription    = 'Crea un nuevo período';
  }
 
  public function execute($arguments = array(), $options = array())
  {
//hace andar las consultas a la DB
$databaseManager = new sfDatabaseManager($this->configuration);

echo date('H:i:s d-m-Y')." Buscando turros...\n";
$empleadores = Doctrine_Query::create()
  ->from('Empleador e')
  ->leftjoin('e.BoletaSindical b')
  ->andWhere('b.periodo is null')
  ->execute();

foreach($empleadores as $empleador):
echo $empleador->getId()." - ".$empleador->getCuit()." - ".$empleador->getNombre()."\n";
endforeach;
echo "Total de turros: ".count($empleadores)."\n";
  }
}
