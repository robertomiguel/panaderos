<?php
		public function executeGenera(sfWebRequest $request)
		{
			//recupero la boleta desde la direccion
//			$boleta = $this->getRoute()->getObject();
			
			//los saco separados por si se pasan en largo para hacer el corte
//	    $ptoCorte = 38;
    $nombre = "juan perez";
    $domicilio = "godoy 7120";
	  
	    //armo codigo de barra
//	    $codigoTmp = '00004531'.str_pad($boleta->getEmpleador()->getId(), 14, '0', STR_PAD_LEFT).$boleta->getPeriodoCorto().'1'.$boleta->getDateTimeObject('vencimiento')->format('ymd').str_pad(number_format($boleta->getTotal(), 2, '', ''), 8, '0', STR_PAD_LEFT);
//	    $codigo = $codigoTmp.DigitoVerificador::banco($codigoTmp);
	
			//cargo configuracion
//		  $config = sfTCPDFPluginConfigHandler::loadConfig();

		  // pdf object
  $pdf = new TCPDF(); //PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		  // settings
		  $pdf->SetFont('times', '', 12);
		  $pdf->SetCreator(PDF_CREATOR);
		  $pdf->SetAuthor(PDF_AUTHOR);

		  // init pdf doc
		  $pdf->setPrintHeader(false);
		  $pdf->setPrintFooter(false);

		  //encabezado
		  $pdf->AddPage();
		  $pdf->SetFont('times', '', 12);
		  $pdf->Cell(0, 0, 'SOCIEDAD DE OBREROS PANADEROS ROSARIO', 'LTR', 1, 'C');
		  $pdf->SetFont('times', '', 8);
		  $pdf->Cell(0, 0, 'PERSONERIA GREMIAL NRO. 167', 'LR', 1, 'C');
		  $pdf->Cell(0, 0, 'ADHERIDA A F.A.U.P.P.A. - ADHERIDA A C.G.T.', 'LR', 1, 'C');
		  $pdf->Cell(0, 0, 'MENDOZA 654 - TEL/FAX (0341) 4213647 ', 'LBR', 1, 'C');
		
	    //cuerpo
	    $pdf->SetFont('times', '', 12);
	    $pdf->Cell(0, 0, '', '', 1, 'C');
	    $pdf->Cell(93, 0, 'C.U.I.T.', 'LTR', 0, 'C');
	    $pdf->Cell(0, 0, "20-23674312-9", 'TR', 1, 'C');
	    $pdf->Cell(93, 0, 'FECHA DE VENCIMIENTO', 'LTR', 0, 'C');
	    $pdf->Cell(0, 0, date('d-m-Y'), 'TR', 1, 'C');
	    $pdf->Cell(93, 0, 'PERIODO / AÑO', 'LTRB', 0, 'C');
	    $pdf->Cell(0, 0, "junio 2011", 'TRB', 1, 'C');

	    $pdf->Cell(0, 0, '', '', 1, 'C');
	    $pdf->Cell(150, 0, strtoupper($nombre), 'LTR', 0, 'L');
	    $pdf->Cell(0,0, '','TR',1,'C');
	    $pdf->SetFont('times', '', 12);
            $pdf->Cell(150, 0, '', 'LR', 0, 'L');
	    $pdf->SetFont('times', '', 8);
	    $pdf->Cell(0,0, 'PARA DEPOSITAR EN','R',1,'C');
	    $pdf->SetFont('times', '', 12);

            $pdf->Cell(150, 0, strtoupper($domicilio), 'LR', 0, 'L');

	    $pdf->SetFont('times', '', 8);
	    $pdf->Cell(0,0, 'CUALQUIER SUCURSAL','R',1,'C');
	    $pdf->SetFont('times', '', 12);
	    $pdf->Cell(150, 0, '', 'LR', 0, 'L');
	    $pdf->SetFont('times', '', 8);
	    $pdf->Cell(0,0, 'DEL NUEVO BANCO DE','R',1,'C');
	    $pdf->SetFont('times', '', 12);
	    $pdf->Cell(150, 0, '('."2000".') '. "ROSARIO" . ' - SANTA FE', 'LR', 0, 'L');
	    $pdf->SetFont('times', '', 8);
	    $pdf->Cell(0,0, 'SANTA FE S.A.','R',1,'C');
	    $pdf->SetFont('times', '', 12);
	    $pdf->Cell(150, 0, '', 'LRB', 0, 'L');
	    $pdf->Cell(0,0, '','RB',1,'C');

	    $pdf->SetFont('times', '', 12);
	    $pdf->Cell(0, 0, '', '', 1, 'C');

			//valores
			$totsal = "15500";
			$sin = "250";
			$sep = "150";
			$totdep = "400";
	$empleados ="3";

$tabla = <<<ETIQUETA
       <table cellspacing="0" cellpadding="1" border="1">
        <tr align="center">
          <td width="40%">CANTIDAD TRABAJADORES</td>
          <td width="10%">{$empleados}</td>
          <td width="20%">TOTAL SALARIOS</td>
          <td width="30%">{$totsal}</td>
        </tr>
        <tr>
          <td colspan="3" width="70%">CUOTA SINDICAL LEY 23.551 3%<br /><span style="font-size: 80%;">CUENTA NRO. 22074/04</span></td>
          <td width="30%" align="right" style="font-size: 200%;background-color: rgb(192, 192, 192);">{$sin}</td>
        </tr>
        <tr>
          <td colspan="3" width="70%">SERVICIO DE SEPELIO 2%<br /><span style="font-size: 80%;">CUENTA NRO. 67512/01</span></td>
          <td width="30%" align="right" style="font-size: 200%;">{$sep}</td>
        </tr>
        <tr>
          <td colspan="3" align="center" width="70%" style="font-size: 200%;">TOTAL:</td>
          <td width="30%" align="right" style="font-size: 200%;background-color: rgb(192, 192, 192);">{$totdep}</td>
        </tr>
      </table>
ETIQUETA;
	$pdf->writeHTML($tabla, true, false, false, false, '');
			
	//mando codigo de barras
//	    $pdf->SetFont('v300002_', '', 36);
//	    $pdf->Cell(0, 0, CodigoBarra::genera($codigo), '', 1, 'C');

			//genero el archivo 
		  $pdf->Output(str_replace('-', '', Formatos::periodoCorto($boleta->getPeriodo())).'_'.$boleta->getEmpleador()->getCuit().'.pdf', 'D');
			
//			$this->redirect('@homepage');
return;
}
?>
