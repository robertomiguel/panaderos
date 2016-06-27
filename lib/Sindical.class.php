<?php
class Sindical
{
  static public function sumar($idbol)
  {
	$totalsal = 0;
	$empbolsin = Doctrine::getTable('EmpBolSin')->verEmpleados($idbol);
	foreach($empbolsin as $empleado):
	$totalsal=$totalsal+$empleado->getSalario();
	endforeach;
	return $totalsal;
  }

  static public function pagar($idbol)
  {
	$pagar = 0;
	$sepelio = 0;
	$cuota = 0;
	$totalcuota= 0;
	$totalsepelio = 0;
	$masa = 0;
	$tasa = 0;
	$totalrecargo = 0;
	$empbolsin = Doctrine::getTable('EmpBolSin')->verEmpleados($idbol);
	$boleta = Doctrine::getTable('BoletaSindical')->find("$idbol");
	foreach($empbolsin as $empleado):
	$cuota = ($empleado->getSalario()*3)/100;
	$totalcuota=$totalcuota+$cuota;
	$pagar=$pagar+$cuota;
	if ($empleado->getSepelio()){
		$sepelio = ($empleado->getSalario()*2)/100;
		$pagar=$pagar+$sepelio;
		$totalsepelio = $totalsepelio+$sepelio;
	}
	$masa=$masa+$empleado->getSalario();
	endforeach;
	$DiasRecargo = Formatos::restarfecha(Formatos::primervencimiento($boleta->getPeriodo()),Formatos::fecha($boleta->getVencimiento()));
	if ($DiasRecargo>0) {
		$tasa = (36 / 365)*$DiasRecargo;
		$recargo = ($pagar * $tasa) / 100;
		$pagar = $pagar + $recargo;
		$totalrecargo = $totalrecargo + $recargo;
	}
	$total = array("total"=>$totalsepelio+$totalcuota,"tasa" => $tasa, "dias" => $DiasRecargo, "pagar" => $pagar,
			"empleados"=>count($empbolsin),"recargo"=>$totalrecargo,"masa"=>$masa,"cuota"=>$totalcuota,"sepelio"=>$totalsepelio);
	return $total;
  }

  static public function vista($id)
  {
$baja = Doctrine_Core::getTable('empleador')->find($id)->getBaja();

$ultimo = Doctrine_Query::create()
	->select('pago, periodo')
	->from('BoletaSindical')
	->where('empleador_id =?',"$id")
	->andWhere('not pago is null')
	->orderBy('periodo DESC')
	->limit(1)
	->execute();

$bolSinPagar= Doctrine_Query::create()
	->select('id')
	->from('BoletaSindical')
	->where('empleador_id =?',"$id")
	->andWhere('pago is null')
	->execute();
$deuda = 0;
foreach ($bolSinPagar as $impaga){
$pagar = Sindical::pagar($impaga->getId());
$deuda = $deuda + $pagar['pagar'];
}

	$total = array(
		"periodo"=>$ultimo[0]['periodo'],
		"pago"=>$ultimo[0]['pago'],
		"cuotas"=>count($bolSinPagar),
		"deudatotal"=>$deuda,
		"baja"=>$baja,
		);

return $total;
  }


} 

