<?php

/**
 * Al3aJ5d2DSR2ASc2sd4gpSd actions.
 *
 * @package    panaderos
 * @subpackage Al3aJ5d2DSR2ASc2sd4gpSd
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Al3aJ5d2DSR2ASc2sd4gpSdActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getEmpleador()->getId();
if ($id<>0){$this->redirect('@sf_guard_signout');}
    $this->empleadores = Doctrine_Core::getTable('empleador')
      ->createQuery('a')
      ->execute();
  }

  public function executeDetalleEmpleador(sfWebRequest $request)
  {
//    $this->forward('default', 'module');
    $id = $request->getParameter('id');
    $this->boletasindical = Doctrine::getTable('empleador')->verSindical($id);
    $this->boletafondo = Doctrine::getTable('empleador')->verFondo($id);
    $this->empleador = Doctrine_Core::getTable('empleador')->find($id);
  }

//------------ autocompletado
public function executeBuscarLocalidad(sfWebRequest $request)
{
    $this->getResponse()->setContentType('application/json');
 
    $localidad = Doctrine::getTable('localidad')
                    ->retrieveForSelect(
                            $request->getParameter('q'),
                            $request->getParameter('limit')
    );
 
  return $this->renderText(json_encode($localidad));
}

  public function executeCrearperiodos(sfWebRequest $request)
  {
    $crearperiodo = $request->getParameter('fperiodo');

	$mes = substr($crearperiodo,3,2)*1;
	$anio = substr($crearperiodo,6,4)*1;
	$anio1 = $anio;	$mes1 = $mes+1;
	if ($mes1==13){$mes1=1;$anio1++;}
	$mes1 = str_pad($mes1, 2, "0", STR_PAD_LEFT);
$vencimiento = $anio1."-".$mes1."-15";
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
$crearperiodo = $anio."-".$mes."-01";
	$mes--;
	if ($mes==0){$mes=12;$anio--;}
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
$copiarperiodo = $anio."-".$mes."-01";

$empleadores = Doctrine_Query::create()->from('empleador')->execute();
$s=0;$f=0;$as=0;
foreach($empleadores as $empleador):
$tienePeriodoSindical = Doctrine_Query::create()
   ->select('id')->from('boletasindical')->Where('empleador_id =?' , $empleador->getId())
   ->andWhere('LEFT(periodo,7) =?' , substr($crearperiodo,0,7))->execute();

if (count($tienePeriodoSindical)==0){$s++; //si NO tiene periodo a crear

$nuevaBolSin = new BoletaSindical();
$nuevaBolSin->setEmpleadorId($empleador->getId());
$nuevaBolSin->setPeriodo($crearperiodo);
$nuevaBolSin->setVencimiento($vencimiento);
$nuevaBolSin->save();
$nuevaBolId = $nuevaBolSin->getId(); //se crea uno nuevo y se recupera la ID

$boletaAnterior=Doctrine_Query::create() //se busca si tiene boleta anterior
   ->select('id')
   ->from('boletasindical')
   ->Where('Empleador_id =?' , $empleador->getId())
   ->andWhere('LEFT(periodo,7) =?' , substr($copiarperiodo,0,7))
   ->execute();
// se cargan empleados de la boleta anterior
if (count($boletaAnterior)<>0){
$empleados = Doctrine::getTable('EmpBolSin')->verEmpleados($boletaAnterior[0]['id']);

foreach($empleados as $empleado): //se copian los empleados.. si hay, si no pasa de largo
$a = new EmpBolSin();
$a->setEmpleadoId($empleado->getEmpleadoId());
$a->setBoletasindicalId($nuevaBolId);
$a->setSalario($empleado->getSalario());
$a->setSepelio($empleado->getSepelio());
$a->save();
endforeach;}

}

// crear boleta fondo
$tienePeriodoFondo = Doctrine_Query::create()
   ->select('id')->from('boletafondo')->Where('empleador_id =?' , $empleador->getId())
   ->andWhere('LEFT(periodo,7) =?' , substr($crearperiodo,0,7))->execute();

if (count($tienePeriodoFondo)==0){$f++;
$boletaAnterior=Doctrine_Query::create() //se busca si tiene boleta anterior
   ->select('maza')
   ->from('boletafondo')
   ->Where('Empleador_id =?' , $empleador->getId())
   ->andWhere('LEFT(periodo,7) =?' , substr($copiarperiodo,0,7))
   ->execute();
if (count($boletaAnterior)<>0){
$masa = $boletaAnterior[0]['maza'];
} else {$masa=0;}

$nuevaBolFon = new BoletaFondo();
$nuevaBolFon->setEmpleadorId($empleador->getId());
$nuevaBolFon->setPeriodo($crearperiodo);
$nuevaBolFon->setVencimiento($vencimiento);
$nuevaBolFon->setMaza($masa);
$nuevaBolFon->save();


}
endforeach;

    $this->getResponse()->setContent("$s-$as $f crea:$crearperiodo, copia de:$copiarperiodo, vence:$vencimiento");
    return sfView::NONE;
}

  public function executeActualizarmasa(sfWebRequest $request)
  {
$bolsindicales = Doctrine_Query::create()->from('BoletaSindical')->execute();
foreach($bolsindicales as $bolsindical):
$masa = Sindical::sumar($bolsindical->getId());
 Doctrine_Query::create()
   ->update('boletafondo')
   ->set('maza', '?', "$masa")
   ->where('empleador_id = ?', $bolsindical->getEmpleadorId())
   ->andWhere('LEFT(periodo,7) =?' , substr($bolsindical->getPeriodo(),0,7))
   ->andWhere('maza < ?',"$masa")
   ->execute();
endforeach;
    $this->getResponse()->setContent("ok");
    return sfView::NONE;
}
  public function executeVerDetalleSin(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $idbol = $request->getParameter('idbol');
$totales = Sindical::pagar($idbol);

$empleados = $totales['empleados'];
$masa = Formatos::moneda($totales['masa']);
$total = Formatos::moneda($totales['total']);
$sepelio = Formatos::moneda($totales['sepelio']);
$sindical = Formatos::moneda($totales['cuota']);
$dias = $totales['dias'];
$recargo = Formatos::moneda($totales['recargo']);
$tasa = Formatos::porcien($totales['tasa']);
$pagar = Formatos::moneda($totales['pagar']);

$detalle = <<<ETIQUETA
Empleados: {$empleados}
Masa: {$masa}
Sindical 3%: {$sindical}
Sepelio 2%: {$sepelio}
Sub total: {$total}
Días de recargo: {$dias}
Recargo: {$recargo}
Tasa: %{$tasa}
TOTAL: {$pagar}
ETIQUETA;
    $this->getResponse()->setContent($detalle);
    return sfView::NONE;

  }
  public function executeVerDetalleFon(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $idbol = $request->getParameter('idbol');
$totales = Fondo::pagar($idbol);

$masa = Formatos::moneda($totales['masa']);
$cuota = Formatos::moneda($totales['cuota']);
$dias = $totales['dias'];
$recargo = Formatos::moneda($totales['recargo']);
$tasa = Formatos::porcien($totales['tasa']);
$pagar = Formatos::moneda($totales['pagar']);

$detalle = <<<ETIQUETA
Masa: {$masa}
Cuota %3: {$cuota}
Días de recargo: {$dias}
Recargo: {$recargo}
Tasa: %{$tasa}
TOTAL: {$pagar}
ETIQUETA;
    $this->getResponse()->setContent($detalle);
    return sfView::NONE;

  }
  public function executeNuevopass(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $pactual = $request->getParameter('pactual');
    $pnuevo = $request->getParameter('pnuevo');
    $pconfirmar = $request->getParameter('pconfirmar');
//    $id = $this->getUser()->getGuardUser()->getId();
$p1=$this->getUser()->getGuardUser()->checkPassword($pactual);

if (!$p1) {$this->getResponse()->setContent('Clave actual incorrecta'); return sfView::NONE;}
if ($pnuevo==$pactual){$this->getResponse()->setContent('La nueva contraseña no puede ser igual a la actual'); return sfView::NONE;}
if ($pnuevo<>$pconfirmar){$this->getResponse()->setContent('La nueva contraseña no coincide'); return sfView::NONE;}
$p=$this->getUser()->setPassword($pnuevo);
$this->getResponse()->setContent("Contraseña cambiada"); return sfView::NONE;
  }

  public function executeRestaurapass(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $pnuevo = $request->getParameter('pnuevo');
    $id = $request->getParameter('eid');
    $empleador = Doctrine_Core::getTable('empleador')->find($id)->getCuit();
$busca = Doctrine_Query::create()
   ->select('id')
   ->from('sfGuardUser')
   ->Where('username =?' , "$empleador")
   ->execute();
$eid = $busca[0]['id'];

    $usuario = Doctrine_Core::getTable('sfGuardUser')->find($eid);
//    $id = $this->getUser()->getGuardUser()->getId();

$usuario->setPassword($pnuevo);
$usuario->save();
$this->getResponse()->setContent("Contraseña cambiada: UserId=$eid User=$empleador pass=[$pnuevo]"); return sfView::NONE;
  }

  public function executePagarsin(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $fpago = $request->getParameter('fpago');
    $fvence = $request->getParameter('fvence');
    $sid = $request->getParameter('sid');
//10-10-2011
$fvence = substr($fvence,6,4).'-'.substr($fvence,3,2).'-'.substr($fvence,0,2);
$fpago = substr($fpago,6,4).'-'.substr($fpago,3,2).'-'.substr($fpago,0,2);
    $boleta = Doctrine_Core::getTable('boletasindical')->find($sid);
    $boleta->setVencimiento($fvence);
    $boleta->setPago($fpago);
    $boleta->save();
$this->getResponse()->setContent("Pagada: $fpago"); return sfView::NONE;
  }

  public function executePagarfon(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $fpago = $request->getParameter('fpago');
    $fvence = $request->getParameter('fvence');
    $fid = $request->getParameter('fid');
$fvence = substr($fvence,6,4).'-'.substr($fvence,3,2).'-'.substr($fvence,0,2);
$fpago = substr($fpago,6,4).'-'.substr($fpago,3,2).'-'.substr($fpago,0,2);
    $boleta = Doctrine_Core::getTable('boletafondo')->find($fid);
    $boleta->setVencimiento($fvence);
    $boleta->setPago($fpago);
    $boleta->save();
$this->getResponse()->setContent("Pagada: $fpago"); return sfView::NONE;
  }

  public function executeSinpagarsin(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $sid = $request->getParameter('sid');
    $boleta = Doctrine_Core::getTable('boletasindical')->find($sid);
    $boleta->setPago(null);
    $boleta->save();
$this->getResponse()->setContent("sin pagar"); return sfView::NONE;
  }

  public function executeSinpagarfon(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $fid = $request->getParameter('fid');
    $boleta = Doctrine_Core::getTable('boletafondo')->find($fid);
    $boleta->setPago(null);
    $boleta->save();
$this->getResponse()->setContent("sin pagar"); return sfView::NONE;
  }

  public function executeLogin(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $id = $request->getParameter('lid');
if (!$request->getParameter('accion')) {
 Doctrine_Query::create()
   ->update('sfGuardUser')
   ->set('is_active', '?', "0")
   ->where('id = ?', $id)
   ->execute();
} else {
 Doctrine_Query::create()
   ->update('sfGuardUser')
   ->set('is_active', '?', "1")
   ->where('id = ?', $id)
   ->execute();

}
return sfView::NONE;
  }

  public function executeBaja(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $id = $request->getParameter('uid');
    $lid = $request->getParameter('lid');

    $fecha = substr($request->getParameter('fbaja'),6,4).'-'.substr($request->getParameter('fbaja'),3,2).'-'.substr($request->getParameter('fbaja'),0,2);

 Doctrine_Query::create()
   ->update('Empleador')
   ->set('baja', '?', "$fecha")
   ->where('id = ?', $id)
   ->execute();

 Doctrine_Query::create()
   ->update('sfGuardUser')
   ->set('is_active', '?', "0")
   ->where('id = ?', $lid)
   ->execute();

$this->getResponse()->setContent("ok!");
return sfView::NONE;
  }
 
 public function executeQuitarbaja(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $id = $request->getParameter('uid');

 Doctrine_Query::create()
   ->update('Empleador')
   ->set('baja','null')
   ->where('id = ?', $id)
   ->execute();

$this->getResponse()->setContent("ok!");
return sfView::NONE;
  }

}
