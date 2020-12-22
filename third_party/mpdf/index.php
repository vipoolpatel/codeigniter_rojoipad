<?php


//require_once  APPPATH.'third_party/vendor/autoload.php';
		//require_once APPPATH.'third_party/mpdf60/mpdf.php';
		require_once 'mpdf/mpdf.php';

		//$mpdf = new \Mpdf\Mpdf(['format' => array(80, 222),'margin_top' => 5,'margin_left' => 4,'margin_right' => 4,'margin_bottom' => 4]);

		$mpdf=new mPDF('c','A6','','',5,5,15,25,10,10); 


	

		$html =  "<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Wel come</h1>
</body>
</html>";

		$mpdf->WriteHTML($html);
		$mpdf->Output($filename,"I");exit;