<?php

/**
 * empbolsin actions.
 *
 * @package    panaderos
 * @subpackage empbolsin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class empbolsinActions extends sfActions
{
/*
  public function executeIndex(sfWebRequest $request)
  {
    $this->empbolsins = Doctrine_Core::getTable('empbolsin')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->empbolsin = Doctrine_Core::getTable('empbolsin')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->empbolsin);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new empbolsinForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new empbolsinForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
*/
  public function executeEdit(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $usuario = $this->getUser()->getGuardUser()->getEmpleador()->getId();
    $uid = Doctrine::getTable('empbolsin')->find("$id")->getBoletaSindical()->getEmpleadorId();
    $pagado = Doctrine::getTable('empbolsin')->find("$id")->getBoletaSindical()->getPago();
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){
if ($usuario<>$uid || $pagado<>null){
   $this->getResponse()->setContent("ACCION ILEGAL REPORTADA");
    return sfView::NONE;
}
}
    $this->forward404Unless($empbolsin = Doctrine_Core::getTable('empbolsin')->find(array($request->getParameter('id'))), sprintf('Object empbolsin does not exist (%s).', $request->getParameter('id')));
    $this->empleado = Doctrine_Core::getTable('empbolsin')->find($request->getParameter('id'));
    $this->form = new empbolsinForm($empbolsin);
 }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($empbolsin = Doctrine_Core::getTable('empbolsin')->find(array($request->getParameter('id'))), sprintf('Object empbolsin does not exist (%s).', $request->getParameter('id')));
    $this->form = new empbolsinForm($empbolsin);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($empbolsin = Doctrine_Core::getTable('empbolsin')->find(array($request->getParameter('id'))), sprintf('Object empbolsin does not exist (%s).', $request->getParameter('id')));
    $empbolsin->delete();

//    $this->redirect('empbolsin/index');
     $this->redirect('crearboleta/verBoletas/id?id='.$empbolsin->getboletasindicalId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $empbolsin = $form->save();

 //     $this->redirect('empbolsin/edit?id='.$empbolsin->getId());
     $this->redirect('crearboleta/verBoletas/id?id='.$empbolsin->getboletasindicalId());
    }
  }
}
