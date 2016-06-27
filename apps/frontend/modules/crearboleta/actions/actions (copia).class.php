<?php

/**
 * crearboleta actions.
 *
 * @package    panaderos
 * @subpackage crearboleta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class crearboletaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $this->uid = $id;
//Módulo admin: Al3aJ5d2DSR2ASc2sd4gpSd
if ($id==0){$this->redirect('/Al3aJ5d2DSR2ASc2sd4gpSd');}
    $this->boletasindical = Doctrine::getTable('empleador')->verSindical($id);
    $this->boletafondo = Doctrine::getTable('empleador')->verFondo($id);
  }

  public function executeVerBoletas(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaSindical')->find("$id")->getEmpleadorId();
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){
if ($usuario<>$uid){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}
} else {$usuario = $request->getParameter('eid');}
    $this->idbol = $id;
    $this->empbolsin = Doctrine::getTable('EmpBolSin')->verEmpleados($id);
    $this->boletasindical = Doctrine::getTable('boletasindical')->find("$id");
    $periodo = Doctrine::getTable('boletasindical')->find("$id")->getPeriodo();
    $respuesta = Doctrine_Query::create()
   ->select('id')
   ->from('BoletaFondo')
   ->Where('empleador_id =?' , $usuario)
   ->andWhere('LEFT(periodo,7) =?' , substr($periodo,0,7))
   ->execute();
    $this->idbolf = $respuesta[0]['id'];
    $this->boletafondo = Doctrine::getTable('boletafondo')->find($respuesta[0]['id']);
    $fondo = Doctrine::getTable('boletafondo')->find($respuesta[0]['id']);
    $this->total=0;
    $this->cep=0;
    $this->cuotaSindi=0;

$totales = Sindical::pagar($id);
if ($totales['masa']>$fondo->getMaza()){
$fondo->setMaza($totales['masa']);
$fondo->save();
}

 }
  public function executeNuevovencimiento(sfWebRequest $request)
  {
    $idbol = $request->getParameter('idbol');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaSindical')->find("$idbol")->getEmpleadorId();
    $pagado = Doctrine::getTable('BoletaSindical')->find("$idbol")->getPago();
if ($usuario<>$uid || $pagado<>null){
     $this->getResponse()->setContent("ACCION ILEGAL REPORTADA");
     return sfView::NONE;
    }
    $fecha = $request->getParameter('fecha');
$boleta = Doctrine::getTable('BoletaSindical')->find("$idbol");
    $dia = substr($fecha,0,2);
    $mes = substr($fecha,3,2);
    $anio = substr($fecha,6,4);
    $fecha = $anio.'-'.$mes.'-'.$dia;
$tmp = Formatos::primervencimiento($boleta->getPeriodo());
//01-11-2011
$actual = substr($tmp,6,4).substr($tmp,3,2).substr($tmp,0,2);
$nueva = $anio.$mes.$dia;
if ($actual<=$nueva){
$boleta->setVencimiento($fecha);
$boleta->save();
}
    $this->getResponse()->setContent(
    Formatos::fecha($boleta->getVencimiento())."|".
    Formatos::restarfecha(Formatos::primervencimiento($boleta->getPeriodo()),Formatos::fecha($boleta->getVencimiento())));
    return sfView::NONE;
  }

  public function executeNuevovencimientofondo(sfWebRequest $request)
  {
    $idbol = $request->getParameter('idbol');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaFondo')->find("$idbol")->getEmpleadorId();
    $pagado = Doctrine::getTable('BoletaFondo')->find("$idbol")->getPago();
if ($usuario<>$uid || $pagado<>null){
     $this->getResponse()->setContent("ACCION ILEGAL");
     return sfView::NONE;
    }
    $fecha = $request->getParameter('fecha');
$boleta = Doctrine::getTable('BoletaFondo')->find("$idbol");
    $dia = substr($fecha,0,2);
    $mes = substr($fecha,3,2);
    $anio = substr($fecha,6,4);
    $fecha = $anio.'-'.$mes.'-'.$dia;
$tmp = Formatos::primervencimiento($boleta->getPeriodo());
//01-11-2011
$actual = substr($tmp,6,4).substr($tmp,3,2).substr($tmp,0,2);
$nueva = $anio.$mes.$dia;
if ($actual<=$nueva){
$boleta->setVencimiento($fecha);
$boleta->save();
}
    $this->getResponse()->setContent(
    Formatos::fecha($boleta->getVencimiento())."|".
    Formatos::restarfecha(Formatos::primervencimiento($boleta->getPeriodo()),Formatos::fecha($boleta->getVencimiento())));
    return sfView::NONE;
  }

  public function executeVermaza(sfWebRequest $request)
  {
    $idbol = $request->getParameter('idbol');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaFondo')->find("$idbol")->getEmpleadorId();
    $pagado = Doctrine::getTable('BoletaFondo')->find("$idbol")->getPago();
if ($usuario<>$uid || $pagado<>null){
     $this->getResponse()->setContent("ACCION ILEGAL");
     return sfView::NONE;
    }
    $maza = Doctrine::getTable('BoletaFondo')->find("$idbol")->getMaza();
    $this->getResponse()->setContent($maza);
    return sfView::NONE;
  }

  public function executeNuevamaza(sfWebRequest $request)
  {
    $idbol = $request->getParameter('idbol');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaFondo')->find("$idbol")->getEmpleadorId();
    $pagado = Doctrine::getTable('BoletaFondo')->find("$idbol")->getPago();
if ($usuario<>$uid || $pagado<>null){
     $this->getResponse()->setContent("ACCION ILEGAL");
     return sfView::NONE;
    }
    $valor = $request->getParameter('valor');
    $totalsal = $this->sumarsalario($request->getParameter('idbols'));
    $bolfondo = Doctrine::getTable('BoletaFondo')->find("$idbol");
    if($valor<>$totalsal){
    if($valor<$totalsal){
      $bolfondo->setMaza($totalsal);
      $bolfondo->save();
      } else {
    $bolfondo->setMaza($valor);
    $bolfondo->save();}
    }
    //$this->getResponse()->setContent(Formatos::moneda($bolfondo->getMaza()));
    return sfView::NONE;
  }

  private function sumarsalario($idbol){
    $totalsal = 0;
    $empbolsin = Doctrine::getTable('EmpBolSin')->verEmpleados($idbol);
  foreach($empbolsin as $empleado):
    $totalsal=$totalsal+$empleado->getSalario();
  endforeach;
  return $totalsal;
}
  public function executeEmpnombre(sfWebRequest $request){
//    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $cuil = $request->getParameter('cuil');
    $idbol = $request->getParameter('idbol');
    $uid = Doctrine::getTable('BoletaSindical')->find("$idbol")->getEmpleadorId();
if ($usuario<>$uid){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}

$nombre = Doctrine_Query::create()->select('id,nombre')->from('Empleado')->Where('Cuil =?' , "$cuil")->execute();

   if (count($nombre)>=1){
    $empId = $nombre[0]['id'];
$existe = Formatos::buscarEmp($idbol,$empId);
    $respuesta = $nombre[0]['nombre'];
   } else {$respuesta = 'El CUIL es válido pero no se encuentra.|2';}

$this->getResponse()->setContent($respuesta."|$existe|$empId");
    return sfView::NONE;
  }
//================== GRABAR EMPLEADO EN BOLETA SINDICAL

  public function executeGrabarempsin(sfWebRequest $request){
//idbol, idemp, salario
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $idbol = $request->getParameter('idbol');
    $uid = Doctrine::getTable('BoletaSindical')->find("$idbol")->getEmpleadorId();
    $pagado = Doctrine::getTable('BoletaSindical')->find("$idbol")->getPago();
if ($usuario<>$uid || $pagado<>null){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}
    $salario = $request->getParameter('salario');
    $empleadoid = $request->getParameter('idemp');
$a = new EmpBolSin();
$a->setEmpleadoId($empleadoid);
$a->setBoletasindicalId($idbol);
$a->setSalario($salario);
$a->setSepelio(true);
$a->save();
    $this->getResponse()->setContent($respuesta."ok");
    return sfView::NONE;
}
  public function executeFormEmpSin(sfWebRequest $request)
  {
$html=<<<ETIQUETA
<div class="nuevoempleado">
<table>
<tr>
   <th width="160px"><br>CUIL</th>
   <td><br><input type="text" id="cuil" onKeyUp="validarcuit($('#cuil').val())"></td>
</tr>
<tr>
   <th width="auto"><br>Nombre</th>
   <td><br><p id="verNombre">ingrese un CUIL</p></td>
</tr>
<tr>
   <th width="110px"><br>Salario</th>
   <td><br><input type="text" id="salario"></td>
</tr>
</table>
</div>
ETIQUETA;

    $this->getResponse()->setContent($html);
    return sfView::NONE;
  }

  public function executePrintboleta(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $idbol = $request->getParameter('id');
    $boleta = Doctrine::getTable('BoletaSindical')->find("$idbol");
    $empId = $boleta->getEmpleadorId();
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){
if ($usuario<>$empId){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}
}
	$cuit = Formatos::guiones($boleta->getEmpleador()->getCuit());
	$nombre = $boleta->getEmpleador()->getNombre();
	$domicilio = $boleta->getEmpleador()->getDomicilio();
	$cp = $boleta->getEmpleador()->getLocalidad()->getCp();
	$ciudad = $boleta->getEmpleador()->getLocalidad()->getNombre();

	$periodo = Formatos::periodo($boleta->getPeriodo());
	$fvence = Formatos::fecha($boleta->getVencimiento());

$totales = Sindical::pagar($idbol);
	$totsal = Formatos::moneda($totales['masa']);
	$empleados = $totales['empleados'];
	$sin = Formatos::moneda($totales['cuota']);
	$sep = Formatos::moneda($totales['sepelio']);
	$totdep = Formatos::moneda($totales['pagar']);
	$dias = $totales['dias'];
	$tasa = Formatos::porcien($totales['tasa']);
	$recargo = Formatos::moneda($totales['recargo']);
//------------------------- GENERAR CODIGO --------------------------
$v = str_replace('-','',$boleta->getPeriodo());
	$empPeridodo = str_pad($empId, 14, "0", STR_PAD_LEFT).substr($v,2,4);
$v = str_replace('-','',$boleta->getVencimiento());
	$vence = substr($v,2,6);
$v = str_replace('.','',number_format($totales['pagar'],2,"","."));
	$importe = str_pad($v, 8, "0", STR_PAD_LEFT);
	$codigoTmp = "00004531".$empPeridodo."1".$vence.$importe;
	$verifica = DigitoVerificador::banco($codigoTmp);
	$codigo = CodigoBarra::genera("00004531".$empPeridodo."1".$vence.$importe.$verifica);

	$pdf = new TCPDF();
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->AddPage();

$tabla = <<<ETIQUETA
<style>
.titulo { border: 0.5pt solid black}
.titulo1 {font-family: times;font-size:12pt}
.titulo2 {font-family: times;font-size:8pt}
.parte2 {font-family: times;font-size:12pt;text-align:center}
.parte2 td {border: 0.5pt solid black}
.parte3 {border: 0.5pt solid black}
.parte3 td {border-right: 0.5pt solid black}
.ocho {font-family: times;font-size:8pt;text-align:center}
.guita {font-family: times;font-size:200%;text-align:right}
</style>
<table class="titulo">
<tr>
<td align="center" class="titulo1">
SOCIEDAD DE OBREROS PANADEROS ROSARIO
</td>
</tr>
<tr>
<td align="center" class="titulo2">
PERSONERIA GREMIAL NRO. 167<br>
ADHERIDA A F.A.U.P.P.A. - ADHERIDA A C.G.T.<br>
MENDOZA 654 - TEL/FAX (0341) 4213647
</td>
</tr>
</table>
<br>
<table class="parte2">
<tr><td>C.U.I.T.</td><td>{$cuit}</td></tr>
<tr><td>FECHA DE VENCIMIENTO</td><td>{$fvence}</td></tr>
<tr><td>PERIODO / AÑO</td><td>{$periodo}</td></tr>
</table>
<br>
<table class="parte3">
<tr>
<td width="80%" rowspan="2">{$nombre}</td>
<td width="20%"></td>
</tr>
<tr>
<td class="ocho">PARA DEPOSITAR EN</td>
</tr>
<tr>
<td rowspan="2">{$domicilio}</td>
<td class="ocho">CUALQUIER SUCURSAL</td>
</tr>
<tr>
<td class="ocho">DEL NUEVO BANCO DE</td>
</tr>
<tr>
<td rowspan="2">({$cp}) - {$ciudad}</td>
<td class="ocho">SANTA FE S.A.</td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
</table>
<br>
       <table cellspacing="0" cellpadding="1" border="0.5">
        <tr align="center">
          <td width="40%">CANTIDAD TRABAJADORES</td>
          <td width="10%">{$empleados}</td>
          <td width="20%">TOTAL SALARIOS</td>
          <td width="30%">{$totsal}</td>
        </tr>
        <tr>
          <td colspan="3" width="70%">CUOTA SINDICAL LEY 23.551 3%<br /><span style="font-size: 80%;">CUENTA NRO. 22074/04</span></td>
          <td width="30%" class="guita">{$sin}</td>
        </tr>
        <tr>
          <td colspan="3" width="70%">SERVICIO DE SEPELIO 2%<br /><span style="font-size: 80%;">CUENTA NRO. 67512/01</span></td>
          <td width="30%" class="guita">{$sep}</td>
        </tr>
ETIQUETA;

$interes = <<<ETIQUETA
        <tr>
          <td colspan="3" width="70%">Pago fuera de término<br><span style="font-size: 80%;">Días de recargo {$dias} - Tasa: %{$tasa}</span></td>
          <td width="30%" class="guita">{$recargo}</td>
        </tr>
ETIQUETA;

$final = <<<ETIQUETA
        <tr>
          <td colspan="3" align="center" width="70%" style="font-size: 200%;" align="right">TOTAL :</td>
          <td width="30%" class="guita">{$totdep}</td>
        </tr>
      </table>
ETIQUETA;

if($dias>0){
$pagina = $tabla.$interes.$final;
} else {$pagina = $tabla.$final;}

	$pdf->writeHTML($pagina, true, false, false, false, '');
			
	//mando codigo de barras
	    $pdf->SetFont('v300002_', '', 36);
	    $pdf->Cell(0, 0, $codigo, '', 1, 'C');

			//genero el archivo 
		  $pdf->Output("sindical_$cuit"."_periodo_"."$periodo.pdf", 'D');
//			$this->redirect('@homepage');
return;
}

  public function executePrintboletafondo(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $idbol = $request->getParameter('id');
    $boleta = Doctrine::getTable('BoletaFondo')->find("$idbol");
    $empId = $boleta->getEmpleadorId();
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){
if ($usuario<>$empId){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}}
	$cuit = Formatos::guiones($boleta->getEmpleador()->getCuit());
	$nombre = $boleta->getEmpleador()->getNombre();
	$domicilio = $boleta->getEmpleador()->getDomicilio();
	$cp = $boleta->getEmpleador()->getLocalidad()->getCp();
	$ciudad = $boleta->getEmpleador()->getLocalidad()->getNombre();

	$periodo = Formatos::periodo($boleta->getPeriodo());
	$fvence = Formatos::fecha($boleta->getVencimiento());

$totales = Fondo::pagar($idbol);
        $masa = Formatos::moneda($totales['masa']);
	$cuota = Formatos::moneda($totales['cuota']);
	$dias = $totales['dias'];
	$tasa = Formatos::porcien($totales['tasa']);
	$recargo = Formatos::moneda($totales['recargo']);
	$pagar =  Formatos::moneda($totales['pagar']);

//------------------------- GENERAR CODIGO --------------------------
//;
$v = str_replace('-','',$boleta->getPeriodo());
	$empPeridodo = '1'.str_pad($empId, 13, "0", STR_PAD_LEFT).substr($v,2,4);
$v = str_replace('-','',$boleta->getVencimiento());
	$vence = substr($v,2,6);
$v = str_replace('.','',number_format($totales['pagar'],2,"","."));
	$importe = str_pad($v, 8, "0", STR_PAD_LEFT);
	$codigoTmp = "00004531".$empPeridodo."1".$vence.$importe;
	$verifica = DigitoVerificador::banco($codigoTmp);
	$codigo = CodigoBarra::genera("00004531".$empPeridodo."1".$vence.$importe.$verifica);

$pdf = new TCPDF();
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->AddPage();
$tabla = <<<ETIQUETA
<style>
.titulo { border: 0.5pt solid black}
.titulo1 {font-family: times;font-size:12pt}
.titulo2 {font-family: times;font-size:8pt}
.parte2 {font-family: times;font-size:12pt;text-align:center}
.parte2 td {border: 0.5pt solid black}
.parte3 {border: 0.5pt solid black}
.parte3 td {border-right: 0.5pt solid black}
.ocho {font-family: times;font-size:8pt;text-align:center}
.guita {font-family: times;font-size:200%;text-align:right}
</style>
<table class="titulo">
<tr>
<td align="center" class="titulo1">
SOCIEDAD DE OBREROS PANADEROS ROSARIO
</td>
</tr>
<tr>
<td align="center" class="titulo2">
PERSONERIA GREMIAL NRO. 167<br>
ADHERIDA A F.A.U.P.P.A. - ADHERIDA A C.G.T.<br>
MENDOZA 654 - TEL/FAX (0341) 4213647
</td>
</tr>
</table>
<br>
<table class="parte2">
<tr><td>C.U.I.T.</td><td>{$cuit}</td></tr>
<tr><td>FECHA DE VENCIMIENTO</td><td>{$fvence}</td></tr>
<tr><td>PERIODO / AÑO</td><td>{$periodo}</td></tr>
</table>
<br>
<table class="parte3">
<tr>
<td width="80%" rowspan="2">{$nombre}</td>
<td width="20%"></td>
</tr>
<tr>
<td class="ocho">PARA DEPOSITAR EN</td>
</tr>
<tr>
<td rowspan="2">{$domicilio}</td>
<td class="ocho">CUALQUIER SUCURSAL</td>
</tr>
<tr>
<td class="ocho">DEL NUEVO BANCO DE</td>
</tr>
<tr>
<td rowspan="2">({$cp}) - {$ciudad}</td>
<td class="ocho">SANTA FE S.A.</td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
</table>
<br>
       <table cellspacing="0" cellpadding="1" border="0.5">
        <tr align="center">
          <td width="70%" align="right">TOTAL DE REMUNERACIONES :</td>
          <td width="30%">{$masa}</td>
        </tr>
        <tr>
          <td colspan="3" width="70%">FONDO CONVENCIONAL ORDINARIO C.C.T. 615/2010 ART. 7 3%<br /><span style="font-size: 80%;">SOCIEDAD OBREROS PANADEROS ROSARIO CUENTA NRO. 67525/03</span></td>
          <td width="30%" class="guita">{$cuota}</td>
        </tr>
ETIQUETA;

$interes = <<<ETIQUETA
        <tr>
          <td colspan="3" width="70%">Pago fuera de término<br><span style="font-size: 80%;">Días de recargo {$dias} - Tasa: %{$tasa}</span></td>
          <td width="30%" class="guita">{$recargo}</td>
        </tr>
ETIQUETA;

$final = <<<ETIQUETA
        <tr>
          <td colspan="3" align="center" width="70%" style="font-size: 200%;"  align="right">TOTAL :</td>
          <td width="30%" class="guita">{$pagar}</td>
        </tr>
      </table>
ETIQUETA;

if($dias>0){
$pagina = $tabla.$interes.$final;
} else {$pagina = $tabla.$final;}

	$pdf->writeHTML($pagina, true, false, false, false, '');
			
	//mando codigo de barras
	    $pdf->SetFont('v300002_', '', 36);
	    $pdf->Cell(0, 0, $codigo, '', 1, 'C');

			//genero el archivo 
		  $pdf->Output("fondo_$cuit"."_periodo_"."$periodo.pdf", 'D');
			
//			$this->redirect('@homepage');
return;
}


}
