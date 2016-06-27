<?php

/**
 * empleado actions.
 *
 * @package    panaderos
 * @subpackage empleado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class empleadoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->empleados = Doctrine_Core::getTable('empleado')
      ->createQuery('a')->orderBy('id DESC')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->empleado = Doctrine_Core::getTable('empleado')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->empleado);
  }

  public function executeNew(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->form = new empleadoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new empleadoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($empleado = Doctrine_Core::getTable('empleado')->find(array($request->getParameter('id'))), sprintf('Object empleado does not exist (%s).', $request->getParameter('id')));
    $this->form = new empleadoForm($empleado);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($empleado = Doctrine_Core::getTable('empleado')->find(array($request->getParameter('id'))), sprintf('Object empleado does not exist (%s).', $request->getParameter('id')));
    $this->form = new empleadoForm($empleado);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $request->checkCSRFProtection();

    $this->forward404Unless($empleado = Doctrine_Core::getTable('empleado')->find(array($request->getParameter('id'))), sprintf('Object empleado does not exist (%s).', $request->getParameter('id')));
    $empleado->delete();

    $this->redirect('empleado/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $empleado = $form->save();

      $this->redirect('empleado/edit?id='.$empleado->getId());
    }
  }

  public function executeVersalario(sfWebRequest $request)
  {
     $idbol = $request->getParameter('idbol');
     $ide = $request->getParameter('ide');
$salario = Doctrine_Query::create()
   ->from("empbolsin")
   ->where("boletasindical_id = ?", "$idbol")
   ->andWhere("id = ?", "$ide")
   ->execute();
   $this->getResponse()->setContent($salario[0]['salario']);
    return sfView::NONE;
  }

  public function executeCambiarsalario(sfWebRequest $request)
  {
     $idbol = $request->getParameter('idbol');
     $idbolf = $request->getParameter('idbolf');
     $ide = $request->getParameter('ide');
     $salario = $request->getParameter('salario');
$actual = Doctrine_Query::create()
   ->from("empbolsin")
   ->where("boletasindical_id = ?", "$idbol")
   ->andWhere("id = ?", "$ide")
   ->execute();
$dif = $salario - $actual[0]['salario'];

 Doctrine_Query::create()
   ->update('empbolsin')
   ->set("salario","'$salario'")
   ->where("boletasindical_id = ?", "$idbol")
   ->andWhere("id = ?", "$ide")
   ->execute();

 Doctrine_Query::create()
   ->update('boletafondo')
   ->set("maza","maza + '$dif'")
//   ->set("maza = maza+'$dif'")
   ->where("id = ?", "$idbolf")
   ->execute();

//   $this->getResponse()->setContent("$salario");
    return sfView::NONE;
  }

}
