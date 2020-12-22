<?php




define('_MPDF_PATH','../');
include("../mpdf.php");


$html = '
<body style="">
<h1 style="font-size: 70px; text-align:center; color: #16ac8f;">Certificate</h1><hr>
<h1 style="font-size: 40px; text-align:center; color: #3595d6;">Academic Certificate</h1>
<p style="font-size: 17px;">
This is a certificate given to <b>Krunal Raol</b> for Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pretium tortor vitae laoreet vestibulum. Nam ut consectetur nisi. Integer tincidunt est a nisl tincidunt ornare. In sed lectus elit. Cras gravida mattis tortor non interdum. Nam nibh sapien, dictum sed suscipit et, mattis sit amet felis. Mauris vel arcu fermentum, suscipit arcu vehicula, interdum ex.
</p>
<p style="font-size: 17px;">
Praesent a felis lacus. Aenean efficitur nisi blandit urna lobortis interdum. Phasellus condimentum lacus erat, ut dictum eros efficitur in. Aliquam id lectus odio. Curabitur suscipit metus a nulla porttitor, eget porta sapien sollicitudin. Vestibulum mattis pellentesque nunc et feugiat. Aliquam erat volutpat. Maecenas tristique, purus id hendrerit rutrum, tortor magna gravida tortor, finibus tempus metus erat bibendum risus. Sed cursus, nunc quis ultricies condimentum, est mauris tempor mauris, eget vehicula elit lacus elementum diam. Cras non felis quis risus tincidunt pellentesque id eget odio. Etiam placerat risus magna, nec scelerisque felis cursus at. In quam ante, mattis ut lorem in, maximus faucibus felis. Nunc urna erat, ultrices nec turpis in, eleifend hendrerit sapien. Aenean convallis, ipsum quis luctus vulputate, nisi arcu tristique leo, sed eleifend lacus eros eu mauris.
</p>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div style="width:150px">
<hr>
<p>Principals sign</p>
</div>
<div style="width:150px; float:right; margin-top: -80px;">
<hr>
<p>Teachers sign</p>
</div>
</body>
';

//==============================================================
//==============================================================
//==============================================================

$mpdf=new mPDF('c'); 

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML();	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->SetColumns(0);

$mpdf->WriteHTML($html);

$mpdf->Output();
exit;


?>