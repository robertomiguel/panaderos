<?php
class Login
{
  static public function check($id)
  {

$estado =  Doctrine_Query::create()
	->select('is_active')
	->from('SfGuardUser')
	->where('id =?',"$id")
	->execute();
if ($estado[0]['is_active']) {
return true;} else {return false;}
  }

} 

