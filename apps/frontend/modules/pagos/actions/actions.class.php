<?php

/**
 * pagos actions.
 *
 * @package    panaderos
 * @subpackage pagos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pagosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
$dir = '/home/roberto/panaderos/pagados/';
$directorio=opendir($dir);
$aarchivos = array();
while ($archivo = readdir($directorio)) { 
//if ($archivo != "." && $archivo != ".."){
if (filetype($dir.$archivo)=='file'){
//$aarchivos['nombre'] = date("Y/m/d H:i - ",filemtime($dir.$archivo)).$archivo . ' - '.filesize($dir.$archivo).' bytes';}
$aarchivos[] = array(
	'nombre'=>$archivo,
	'fecha'=>date("Y/m/d H:i",filemtime($dir.$archivo)),
	'bytes'=>filesize($dir.$archivo));}
}  
closedir($dir);
	$this->archivos = $aarchivos;
  }

public function executeDescarga(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}

    if ($_POST["action"] == "upload") {
        // obtenemos los datos del archivo
//        $tamano = $_FILES["archivo"]['size'];
//        $tipo = $_FILES["archivo"]['type'];
        $archivo = $_FILES["archivo"]['name'];
//        $prefijo = substr(md5(uniqid(rand())),0,6);
       
        if ($archivo != "") {
            // guardamos el archivo a la carpeta files
            $destino =  "/home/roberto/panaderos/pagados/".$archivo;
  copy($_FILES['archivo']['tmp_name'],$destino);          
        }
    }
//$this->getResponse()->setContent("ok!");
//return sfView::NONE;
$this->redirect('/pagos');
  }

public function executeBorrar(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $archivo = $request->getParameter('archivo');
unlink('/home/roberto/panaderos/pagados/'.$archivo);
//$this->getResponse()->setContent("ok!");
return sfView::NONE;
  }

public function executeVerzip(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
    $archivo = '/home/roberto/panaderos/pagados/'.$request->getParameter('zip');

$zip = zip_open($archivo);
$archivos = "";
 if ($zip) {
   while ($entrada = zip_read($zip)) {
    $archivos = $archivos.zip_entry_name($entrada).' '.zip_entry_filesize($entrada)."b\n";
   }
    zip_close($zip);
 } 

$this->getResponse()->setContent("$archivos");
return sfView::NONE;
  }

public function executeParsear(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
$dir = '/home/roberto/panaderos/pagados/temp/';
$directorio=opendir($dir);
while ($archivo = readdir($directorio)) { 
if (filetype($dir.$archivo)=='file'){
unlink($dir.$archivo);}
}  
closedir($dir);

    $archivo = '/home/roberto/panaderos/pagados/'.$request->getParameter('zip');
$zip = new ZipArchive;
 if ($zip->open($archivo) === TRUE) {
     $zip->extractTo('/home/roberto/panaderos/pagados/temp/');
     $zip->close();
 }
$this->redirect('/pagos/verparseo');
}

public function executeVerparseo(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser()->getUsername();
if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
$dir = '/home/roberto/panaderos/pagados/temp/';
$directorio=opendir($dir);
$aarchivos = array();
while ($archivo = readdir($directorio)) { 
if (filetype($dir.$archivo)=='file'){
$aarchivos = $archivo;}
}  
closedir($dir);
  $this->archivo = $aarchivos;
$a = file('/home/roberto/panaderos/pagados/temp/'.$aarchivos);
array_shift($a);
array_pop($a);
$this->datos = $a;
//$lineas = count($datos);
//for($i=0; $i < $lineas; $i++){ echo $archivo[$i]; }

  }

  public function executePagar(sfWebRequest $request)
  {
  $user = $this->getUser()->getGuardUser()->getUsername();
  if ($user<>"admin"){$this->redirect('@sf_guard_signout');}
	$eid = $request->getParameter('eid');
	$periodo = $request->getParameter('periodo');
	$diadepago = $request->getParameter('diadepago');
	$vencimiento = $request->getParameter('vencimiento');
	$tipo = $request->getParameter('tipo');

if ($tipo=='0'){
$r = Doctrine_Query::create()
   ->update('BoletaSindical')
   ->set('pago', '?', "$diadepago")
   ->set('vencimiento', '?', "$vencimiento")
   ->where('empleador_id = ?', $eid)
   ->andWhere('periodo = ?', "$periodo")
   ->execute();
}
if ($tipo=='1'){
$r = Doctrine_Query::create()
   ->update('BoletaFondo')
   ->set('pago', '?', "$diadepago")
   ->set('vencimiento', '?', "$vencimiento")
   ->where('empleador_id = ?', $eid)
   ->andWhere('periodo = ?', "$periodo")
   ->execute();
}
if ($r) {$r='ACTUALIZADO';} else {$r='NO COINCIDE o YA EXISTE ESTA FECHA DE PAGADO EN ESTA BOLETA';}
if ($tipo==1) {$tipo='Fondo';} else {$tipo='Sindical';}
$respuesta = <<<ETIQUETA
Tipo:{$tipo}
Empleador ID:{$eid}
Período:{$periodo}
Vencimiento:{$vencimiento}
Pagado:{$diadepago}
Respuesta:{$r}
ETIQUETA;
$this->getResponse()->setContent("$respuesta");
return sfView::NONE;
}

  public function executeSindical(sfWebRequest $request)
  {
 /*   $this->empleadores = Doctrine_Core::getTable('empleador')
      ->createQuery('a')->limit(100)
      ->execute();
*/
	 $this->pager = new sfDoctrinePager('TableName', '30');
	 $this->pager->setQuery(Doctrine_Query::create()
//       ->select("*")
       ->from("empleador"));
	 $this->pager->setPage($request->getParameter('page', 1));
	 $this->pager->init();
 

 }

}
