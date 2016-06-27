<?php
/*
  codigoBarras: genera el codigo de barras
*/
class CodigoBarra
{
  static public function genera($valor)
  {
    //si es nulo devuelvo n-a
    if (empty ($valor))
    {
      return 'n-a'  ;
    }

    //si la cantidad de valores es impar devuelvo n-a
    if (strlen($valor) % 2 != 0)
    {
      return 'n-a'  ;
    }

    //si no es numerica devuelvo n-a
    if (!preg_match("/^[[:digit:]]+$/", $valor))
    {
      return 'n-a'  ;
    }

    //marcas de principio y fin del codigo
    $inicio = chr(33);
    $fin = chr(34);

    //agrega a la cadena la marca de inicio
    $cadena = $inicio;

    //se recorre la cadena de a pares y se van asignando los valores
    for ($i = 0; $i < strlen($valor); $i += 2)
    {
      $v = substr($valor, $i, 2);
      switch ($v)
      {
        case ($v >= 0 and $v <=91):
          $c = chr($v + 35);
          break;
        case 92:
          $c = utf8_encode(chr(196));
          break;
        case 93:
          $c = utf8_encode(chr(197));
          break;
        case 94:
          $c = utf8_encode(chr(199));
          break;
        case 95:
          $c = utf8_encode(chr(201));
          break;
        case 96:
          $c = utf8_encode(chr(209));
          break;
        case 97:
          $c = utf8_encode(chr(214));
          break;
        case 98:
          $c = utf8_encode(chr(220));
          break;
        case 99:
          $c = utf8_encode(chr(225));
          break;
      }
      
      $cadena = $cadena . $c;
    }
    //agrega a la cadena la marca de fin
    $cadena = $cadena . $fin;

    return $cadena;
  }
}