<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  get('/Al3aJ5d2DSR2ASc2sd4gpSd/index')->

  with('request')->begin()->
    isParameter('module', 'Al3aJ5d2DSR2ASc2sd4gpSd')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;
