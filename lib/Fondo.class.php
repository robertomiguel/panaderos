<?php
class Fondo
{
  static public function pagar($idbol)
  {

	$tasa = 0;
	$recargo = 0;
	$boleta = Doctrine::getTable('BoletaFondo')->find("$idbol");
	$masa=$boleta->getMaza();
	$cuota=($masa*3)/100;
	$DiasRecargo = Formatos::restarfecha(Formatos::primervencimiento($boleta->getPeriodo()),Formatos::fecha($boleta->getVencimiento()));
	if ($DiasRecargo>0) {
		$tasa = (36 / 365)*$DiasRecargo;
		$recargo = ($cuota * $tasa) / 100;
		$pagar = $cuota + $recargo;
	} else {$pagar=$cuota;}
	$total = array(
		"masa"=>$masa,
		"cuota"=>$cuota,
		"dias"=>$DiasRecargo,
		"tasa"=>$tasa,
		"recargo"=>$recargo,
		"pagar"=>$pagar
		);
	return $total;
  }

} 

