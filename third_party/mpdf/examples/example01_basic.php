<?php


$html = '
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        
        
        font-size:16px;
        line-height:24px;
        font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:10px;
    }
    
    .invoice-box table tr.heading td{
        border-bottom:1px solid #000;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Next Step Webs, Inc.<br>
                                12345 Sunny Road<br>
                                Sunnyville, TX 12345
                            </td>
                            
                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Next Step Webs, Inc.<br>
                                12345 Sunny Road<br>
                                Sunnyville, TX 123456
                            </td>
                            
                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

    <div style="border-top:1px solid #000;"></div>
    </div>
    <div style="width:100%;padding:0px 30px;">
        <table cellpadding="0" cellspacing="0" style="text-align:left;" style="width:100%;">
        	<tr>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        		<td style="font-weight:bold;border-bottom:1px solid #000;">abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        	<tr style="text-align:left;">
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        		<td>abcabc</td>
        	</tr>
        </table>
    </div>
    <div style="border-top:1px solid #000;margin:30px;"></div>
    <div style="width:60%;text-align:justify;margin:0px 30px;float:left;padding:0px 15px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s</div>
    <div style="width:25%;padding:0px 15px;float:left;">Lorem Ipsum has been the industrys standard dummy text ever since the 1500s</div>
    <br />
    
    <div style="width:70%;margin:auto;"><center>Lorem Ipsum has been the industrys standard dummy text ever since the 1500s</center></div>
</body>
</html>
';

//==============================================================
//==============================================================
//==============================================================

include("../mpdf.php");
$mpdf=new mPDF('c'); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>