<?php

/**
 * industriales actions.
 *
 * @package    panaderos
 * @subpackage industriales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class industrialesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->empleadores = Doctrine_Core::getTable('empleador')
      ->createQuery('a')
      ->execute();
  }
  public function executeSoloalta(sfWebRequest $request)
  {
    $this->empleadores = Doctrine_Core::getTable('empleador')
      ->createQuery('a')->where('baja is null')
      ->execute();
  }
  public function executeSolobaja(sfWebRequest $request)
  {
    $this->empleadores = Doctrine_Core::getTable('empleador')
      ->createQuery('a')->where('not baja is null')
      ->execute();
  }

  public function executeDetalle(sfWebRequest $request)
  {
    $id = $request->getParameter('eid');
	$this->fondo = Doctrine_Query::create()
	->from('BoletaFondo')
	->Where('empleador_id =?' , $id)
	->orderBy('periodo DESC')
	->execute();
    $this->empleador = Doctrine_Core::getTable('Empleador')->find(array($id));

  }

  public function executeNuevoindustrial(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}

    $iusuario = $request->getParameter('iusuario');
    $ipass = $request->getParameter('ipass');
$user = new sfGuardUser();
$user->setUsername($iusuario);
$user->setEmailAddress($iusuario.'@a.com');
$user->setPassword($ipass);
$user->save();
$user->addGroupByName('industriales');

    $this->getResponse()->setContent("Ok!! usuario:$iusuario - pass:$ipass");
    return sfView::NONE;
  }

}
