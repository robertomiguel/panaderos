<?php
function diaSemanal($menos){
  $hoy = date('w') - $menos; // 5-7  -2  7 + -2
  if($hoy<0) {$hoy = 7 + $hoy;}
  switch ($hoy) {
   case '0': $dia = 'Domingo';  break;
   case '1': $dia = 'Lunes';  break;
   case '2': $dia = 'Martes';  break;
   case '3': $dia = 'Miércoles';  break;
   case '4': $dia = 'Jueves';  break;
   case '5': $dia = 'Viernes';  break;
   case '6': $dia = 'Sábado';  break;
  }
  return $dia;  
}

class Formatos {
  static public function tiempo($Tpasado){
  if ($Tpasado==""){return 'nunca';}
  // 2013.03.26 15.42.00
$h= substr($Tpasado,11,2);
$min= substr($Tpasado,14,2);
$s= substr($Tpasado,17,2);
$d= substr($Tpasado,8,2);
$m= substr($Tpasado,5,2);
$a= substr($Tpasado,0,4);

$pasado = mktime($h,$min,$s,$m,$d,$a);

$actual = time();

$diferencia = $actual - $pasado;

$segundos = $diferencia;
$minutos = round($diferencia / 60);
$horas = floor($diferencia / 3600);
$dias = round($diferencia / 86400);
//$meses = floor($diferencia / 2628000);
//$anios = round($diferencia / 31536000);
if ($dias>=8) {return "$d-$m-$a";}
if ($horas==0) {return "hace $minutos minutos";}
if (date('d-m-Y')=="$d-$m-$a"){ return "hace $horas horas";} // hoy
$dia = date('j')-1;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "Ayer a las $h:$min";}
$dia = date('j')-2;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(2)." a las $h:$min";}
$dia = date('j')-3;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(3)." a las $h:$min";}
$dia = date('j')-4;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(4)." a las $h:$min";}
$dia = date('j')-5;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(5)." a las $h:$min";}
$dia = date('j')-6;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(6)." a las $h:$min";}
$dia = date('j')-7;
if($dia<0) {$dia = date('t', $pasado) + $dia;}
if ( $dia.date('-m-Y')=="$d-$m-$a"){ return "el ".diaSemanal(7)." a las $h:$min";}

return 'nada';
}
static public function moneda($moneda){
return '$ '.number_format($moneda,2,',','.');
}
static public function monedasimple($moneda){
return number_format($moneda,2,'.','');
}
static public function porcien($x100){
return number_format($x100,2,',','.');
}
static public function fecha($fecha){
  if ($fecha==null) {return null;}
//  2009-02-01 a 01-02-2009
  $dia = substr($fecha,8,2);
  $mes = substr($fecha,5,2);
  $anio = substr($fecha,0,4);
  $fecha = $dia."-".$mes."-".$anio;
  return $fecha;
}

static public function periodo($fecha){
  if ($fecha==null) {return null;}
//  2009-02-01 a 01-02-2009
$meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
               'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
  $mes = substr($fecha,5,2)*1;
  $anio = substr($fecha,0,4);
  $fecha = $meses[$mes].' '.$anio;
  return $fecha;
}

static public function siono($activo){
if ($activo==1) {return "SI";} else {return "NO";}
}

static public function textoCool($texto){
return ucwords(strtolower($texto));
}
static public function restarfecha($fecha1,$fecha2){
//defino fecha 1 (menor)
//15-11-2011
//2011-11-15
  $dia1 = substr($fecha1,0,2);
  $mes1 = substr($fecha1,3,2);
  $anio1 = substr($fecha1,6,4);

//defino fecha 2 (mayor)
  $dia2 = substr($fecha2,0,2);
  $mes2 = substr($fecha2,3,2);
  $anio2 = substr($fecha2,6,4);

//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$anio1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$anio2);

//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia; 
}
//sacar primer vencimiento sumando un mes a periodo
static public function primervencimiento($periodo){
//15-11-2011
//2011-11-15
  $mes = substr($periodo,5,2)*1;
  $anio = substr($periodo,0,4)*1;
  $mes++;
   if ($mes==13){$mes=1;$anio++;}
  $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
  $vence = "15/$mes/$anio";
return $vence;
}
//si vence antes del dia actual la fechadepago es el vencimiento de la boleta
static public function checkvence($periodo){
  $mes = substr($periodo,5,2)*1;
  $anio = substr($periodo,0,4)*1;
  $mes++;
   if ($mes==13){$mes=1;$anio++;}
  $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
  $vence = "$anio"."$mes"."15";
return $vence;
}
//busca el empleado en la boleta sindical
static public function buscarEmp($boleta, $empleado) {
$buscar = Doctrine_Query::create()->select('id')->from('EmpBolSin')
          ->where('boletasindical_id =?',"$boleta")
          ->andWhere('empleado_id =?' , "$empleado")->execute();
   if (count($buscar)==1){return true;}else{return false;}
}

static public function guiones($cuil){
  $p1 = substr($cuil,0,2);
  $p2 = substr($cuil,2,8);
  $p3 = substr($cuil,10,1);
return $p1.'-'.$p2.'-'.$p3;
}
}

