<?php

class nuevoperiodoTask extends sfBaseTask
{
  public function configure()
  {
    $this->namespace = 'nuevo';
    $this->name      = 'periodo';
    $this->briefDescription    = 'Crea un nuevo período';
		
    $this->addArgument('periodo', sfCommandArgument::REQUIRED, 'periodo (AAAA-MM)');
  }
 
  public function execute($arguments = array(), $options = array())
  {
//hace andar las consultas a la DB
$databaseManager = new sfDatabaseManager($this->configuration);

  $mes = substr($arguments['periodo'],5,2)*1;
  $anio = substr($arguments['periodo'],0,4)*1;
$nuevoperiodo = "$anio-$mes-01";//$arguments['periodo'];
  $mes = substr($nuevoperiodo,5,2)*1;
  $anio = substr($nuevoperiodo,0,4)*1;
  $mes++;
   if ($mes==13){$mes=1;$anio++;}
  $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
$vencimiento = "$anio-$mes-15"; //dia 15 del mes siguiente
  $mes = substr($nuevoperiodo,5,2)*1;
  $anio = substr($nuevoperiodo,0,4)*1;
  $mes--;
   if ($mes==0){$mes=12;$anio--;}
  $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
$periodoanteriorMin = "$anio-$mes-01"; //periodo que se copia

echo date('H:i:s d-m-Y');
$empleadores = Doctrine_Query::create()
  ->from('Empleador e')
  ->leftjoin('e.BoletaSindical b')
  ->where('b.periodo =?' , $periodoanteriorMin)
  ->execute();
echo "\nEmpleadores: ".count($empleadores)."\nCreando Período: ".substr($nuevoperiodo,0,7)."...\n";
$i=0;

foreach($empleadores as $empleador):

$yatiene = Doctrine_Query::create()
   ->select('id')
   ->from('boletasindical')
   ->Where('Empleador_id =?' , $empleador->getId())
   ->andWhere('periodo =?' , $nuevoperiodo)
//   ->andWhere('periodo <=?' , $periodoanteriorMax)
   ->execute();
if (count($yatiene)==0)
{
$i++;
$boleta=Doctrine_Query::create()
   ->select('id')
   ->from('boletasindical')
   ->Where('Empleador_id =?' , $empleador->getId())
   ->andWhere('periodo =?' , $periodoanteriorMin)
   ->execute();

$nuevaBolSin = new BoletaSindical();
$nuevaBolSin->setEmpleadorId($empleador->getId());
$nuevaBolSin->setPeriodo($nuevoperiodo);
$nuevaBolSin->setVencimiento($vencimiento);
$nuevaBolSin->save();
$nuevaBolId = $nuevaBolSin->getId();

$empleados = Doctrine::getTable('EmpBolSin')->verEmpleados($boleta[0]['id']);
foreach($empleados as $empleado):
$a = new EmpBolSin();
$a->setEmpleadoId($empleado->getEmpleadoId());
$a->setBoletasindicalId($nuevaBolId);
$a->setSalario($empleado->getSalario());
$a->setSepelio($empleado->getSepelio());
$a->save();

endforeach;

$nuevaBolFon = new BoletaFondo();
$nuevaBolFon->setEmpleadorId($empleador->getId());
$nuevaBolFon->setPeriodo($nuevoperiodo);
$nuevaBolFon->setVencimiento($vencimiento);
$nuevaBolFon->save();
}

endforeach;
/*
//================ agregar período

  $mes = substr($boleta[0]['ultimo'],5,2)*1;
  $anio = substr($boleta[0]['ultimo'],0,4)*1;
  $mes++;
   if ($mes==13){$mes=1;$anio++;}
  $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
  $siguienteP = "$anio".'-'."$mes".'-01';

  $mes++;
   if ($mes==13){$mes="01";$anio++;}

*/
  echo "\n Creados: $i\nFin: ".date('H:i:s d-m-Y').".\n";
  }
}
