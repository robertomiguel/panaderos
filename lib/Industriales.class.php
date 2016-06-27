<?php
class Industriales
{
  static public function vista($id)
  {
$baja = Doctrine_Core::getTable('empleador')->find($id)->getBaja();

$ultimo = Doctrine_Query::create()
	->select('pago, periodo')
	->from('BoletaFondo')
	->where('empleador_id =?',"$id")
	->andWhere('not pago is null')
	->orderBy('periodo DESC')
	->limit(1)
	->execute();

$deuda = Doctrine_Query::create()
	->select('sum(maza) as total')
	->from('BoletaFondo')
	->where('empleador_id =?',"$id")
	->andWhere('pago is null')
	->execute();

$cuotas = Doctrine_Query::create()
	->select('id')
	->from('BoletaFondo')
	->where('empleador_id =?',"$id")
	->andWhere('pago is null')
	->execute();

	$total = array(
		"periodo"=>$ultimo[0]['periodo'],
		"pago"=>$ultimo[0]['pago'],
		"cuotas"=>count($cuotas),
		"deudatotal"=>($deuda[0]['total']*3)/100,
		"baja"=>$baja,
		);

return $total;
  }

} 

