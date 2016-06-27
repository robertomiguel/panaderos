<?php

/**
 * empleador actions.
 *
 * @package    panaderos
 * @subpackage empleador
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class empleadorActions extends sfActions
{
/*  public function executeIndex(sfWebRequest $request)
  {
    $this->empleadors = Doctrine_Core::getTable('Empleador')
      ->createQuery('a')
      ->execute();
  }
*/
  public function executeShow(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->empleador = Doctrine_Core::getTable('Empleador')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->empleador);
  }

  public function executeNew(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->form = new EmpleadorForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new EmpleadorForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($empleador = Doctrine_Core::getTable('Empleador')->find(array($request->getParameter('id'))), sprintf('Object empleador does not exist (%s).', $request->getParameter('id')));
    $this->form = new EmpleadorForm($empleador);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($empleador = Doctrine_Core::getTable('Empleador')->find(array($request->getParameter('id'))), sprintf('Object empleador does not exist (%s).', $request->getParameter('id')));
    $this->form = new EmpleadorForm($empleador);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $request->checkCSRFProtection();

    $this->forward404Unless($empleador = Doctrine_Core::getTable('Empleador')->find(array($request->getParameter('id'))), sprintf('Object empleador does not exist (%s).', $request->getParameter('id')));
    $empleador->delete();

    $this->redirect('empleador/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $empleador = $form->save();

$user = new sfGuardUser();
$user->setUsername($empleador->getCuit());
$user->setEmailAddress($empleador->getCuit().'@a.com');
$user->setPassword("rosario");
$user->save();
$empleador->setSfGuardUserId($user->getId());
$empleador->save();

      $this->redirect('empleador/show?id='.$empleador->getId());
    }
  }

  public function executeNuevopass(sfWebRequest $request)
  {
/*    $id = $request->getParameter('id');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('BoletaSindical')->find("$id")->getEmpleadorId();
if ($usuario<>$uid){
   $this->getResponse()->setContent("ACCION ILEGAL");
    return sfView::NONE;
}*/


    $pactual = $request->getParameter('pactual');
    $pnuevo = $request->getParameter('pnuevo');
    $pconfirmar = $request->getParameter('pconfirmar');
//    $id = $this->getUser()->getGuardUser()->getId();
if ($pnuevo==""||$pactual==""||$pconfirmar==""){$this->getResponse()->setContent('Completar todos los campos'); return sfView::NONE;}

$p1=$this->getUser()->getGuardUser()->checkPassword($pactual);

if (!$p1) {$this->getResponse()->setContent('Clave actual incorrecta'); return sfView::NONE;}
if ($pnuevo==$pactual){$this->getResponse()->setContent('La nueva contraseña no puede ser igual a la actual'); return sfView::NONE;}
if ($pnuevo<>$pconfirmar){$this->getResponse()->setContent('La nueva contraseña no coincide'); return sfView::NONE;}
$p=$this->getUser()->setPassword($pnuevo);
$this->getResponse()->setContent("Contraseña cambiada"); return sfView::NONE;
  }
}
