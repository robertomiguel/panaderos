// ====================================================== Validación de INPUT
function permite(elEvento, permitidos) {
  // Variables que definen los caracteres permitidos
  var numeros = "0123456789,";
  var cuil = "0123456789-";
  var caracteres = " aábcdeéfghiíjklmnñoópqrstuúvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
  var alfa = " aábcdeéfghiíjklmnñoópqrstuúvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
  var telefono = "0123456789-()";
  var fecha = "0123456789/";
  var guita = "0123456789.";
  // Seleccionar los caracteres a partir del parámetro de la función
  switch(permitidos) {
    case 'cuil':
      permitidos = cuil;
      break;
    case 'num':
      permitidos = numeros;
      break;
    case 'car':
      permitidos = caracteres;
      break;
    case 'alfa':
      permitidos = alfa;
      break;
    case 'tel':
      permitidos = telefono;
      break;
    case 'fecha':
      permitidos = fecha;
      break;
    case 'guita':
      permitidos = guita;
      break;
  }
  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
   if(codigoCaracter == 9) { return; } // acepta el tabulador
   if(codigoCaracter == 8) { return; } // acepta el backspace
   var caracter = String.fromCharCode(codigoCaracter);
   if(codigoCaracter == 37 || codigoCaracter == 39) { return; } // acepta teclas cursor
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  return permitidos.indexOf(caracter) != -1;
}
