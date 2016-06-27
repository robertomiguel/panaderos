<?php

/**
 * editarSindical actions.
 *
 * @package    panaderos
 * @subpackage editarSindical
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class editarSindicalActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
   $periodo = $request->getParameter('periodo');
   if($periodo==""){$periodo="2011-09";}
   $this->periodo = $periodo;
    $this->boleta_sindicals = Doctrine_Core::getTable('BoletaSindical')
	->createQuery('a')
	->where('LEFT(periodo,7) =?' , substr($periodo,0,7))
	->orderBy('empleador_id')
	->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}

    $this->boleta_sindical = Doctrine_Core::getTable('BoletaSindical')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->boleta_sindical);
  }

  public function executeNew(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->form = new BoletaSindicalForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BoletaSindicalForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($boleta_sindical = Doctrine_Core::getTable('BoletaSindical')->find(array($request->getParameter('id'))), sprintf('Object boleta_sindical does not exist (%s).', $request->getParameter('id')));
    $this->form = new BoletaSindicalForm($boleta_sindical);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($boleta_sindical = Doctrine_Core::getTable('BoletaSindical')->find(array($request->getParameter('id'))), sprintf('Object boleta_sindical does not exist (%s).', $request->getParameter('id')));
    $this->form = new BoletaSindicalForm($boleta_sindical);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $request->checkCSRFProtection();

    $this->forward404Unless($boleta_sindical = Doctrine_Core::getTable('BoletaSindical')->find(array($request->getParameter('id'))), sprintf('Object boleta_sindical does not exist (%s).', $request->getParameter('id')));
    $boleta_sindical->delete();

    $this->redirect('editarSindical/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $boleta_sindical = $form->save();

      $this->redirect('editarSindical/edit?id='.$boleta_sindical->getId());
    }
  }
}
