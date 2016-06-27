<?php
/* Calcula el digito verificador de la CUIT
 * Calcula el digito verificador para el banco */

class DigitoVerificador
{
  static public function banco($valor)
  {
    //arreglo con la serie
    $arrSerie = array(1, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9, 3, 5, 7, 9);

    //si es vacia se devuelve n-a
    if (empty($valor))
    {
      return 'n-a';
    }

    //si la cantidad de valores es impar devuelvo n-a
    if (strlen($valor) != 41)
    {
      return 'largo distinto de 41';//return 'n-a';
    }

    //si no es entero devuelvo n-a
    if (!preg_match("/^[[:digit:]]+$/", $valor))
    {
      return 'n-a'  ;
    }

    //convierto la cadena en un array
    $arrEntrada = str_split($valor);

    //recorro y multiplico los valores por la serie
    foreach ($arrEntrada as $i => $entrada)
    {
      $arrEntrada[$i] = $entrada * $arrSerie[$i];
    }

    //sumo los valores de los productos divido por 2 y tomo la parte entera
    $resultado = intval(array_sum($arrEntrada) / 2);

    //resultado le aplico modulo 10
    $digito = $resultado % 10;

    return $digito;  //devuelve el digito verificador
  }

  static public function cuit($valor)
  {
    //arreglo con la serie
    $arrSerie = array(2, 3, 4, 5, 6, 7, 2, 3, 4, 5);

    //si es vacia se devuelve n-a
    if (empty ($valor))
    {
      return 'n-a'  ;
    }

    //si la cantidad de valores es impar devuelvo n-a
    if (strlen($valor) != 10)
    {
      return 'n-a'  ;
    }

    //si no es entero devuelvo n-a
    if (!preg_match("/^[[:digit:]]+$/", $valor))
    {
      return 'n-a'  ;
    }

    //convierto la cadena en un array y lo doy vuelta
    $arrEntrada = array_reverse(str_split($valor));

    //recorro y multiplico los valores por la serie
    foreach ($arrEntrada as $i => $entrada)
    {
      $arrEntrada[$i] = $entrada * $arrSerie[$i];
    }

    //suman los resultados de los productos se aplica modulo 11 y a 11 se le resta dicho resultado
    $resultado = 11 - array_sum($arrEntrada) % 11;

    switch($resultado) {
      case 11:
        $digito = 0;
        break;
      case 10:
        $digito = 9;
        break;
      default:
        $digito = $resultado;
    }
    return $digito; //devuelve el digito verificador
  }
} 

