<?php 
	header('Content-Type: text/html; charset=utf-8');
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=Client Shop vendor_".date('Y-m-d').".xls ");
	header("Content-Transfer-Encoding: binary ");
	echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
		xmlns:x="urn:schemas-microsoft-com:office:excel"
		xmlns="http://www.w3.org/TR/REC-html40">
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<style id="Classeur1_16681_Styles"></style>
		<style type="text/css">
			.shulist{mso-style-parent:style0;color:windowtext;text-align:left;border:.5pt solid windowtext;mso-protection:unlocked visible;white-space:normal;mso-rotate:90;text-align:center;}
		</style>
		</head>
		<body>
		<div id="Classeur1_16681" align=center x:publishsource="Excel">
			<table x:str border=0 cellpadding=0 cellspacing=0 style="font-family: Calibri, Helvetica, SimSun, sans-serif;border-collapse: collapse;">
				<tr>
					<th height="50" style="font-size:20px;border:.5pt solid windowtext;" colspan="12" align="center" class="xl2216681 nowrap">Client Shop vendor List</th>
				</tr>
				<tr>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" height="30" align="center" class="xl2216681 nowrap">N/A</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Company Name</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Company Title</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Company Email</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Company Address</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Company Tel.</th>
			
					
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Realname</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Nickname</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Phone</th>		
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Email</th>
					
			
					
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Last Edited Time</th>
					<th style="min-height:30px;border:.5pt solid windowtext;background:#111d35;" align="center" class="xl2216681 nowrap">Author</th>
				</tr>';
				//选择数据--开始
				if(!empty($userlist)){for($i=0;$i<count($userlist);$i++){
					
					echo '<tr>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.($i+1).'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="left" class="xl2216681 nowrap">'.$userlist[$i]['company_name'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="left" class="xl2216681 nowrap">'.$userlist[$i]['company_title'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="left" class="xl2216681 nowrap">'.$userlist[$i]['company_email'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="left" class="xl2216681 nowrap">'.$userlist[$i]['company_address'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="left" class="xl2216681 nowrap">'.$userlist[$i]['company_phone'].'</td>';
					
					
					
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.$userlist[$i]['user_realname'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.$userlist[$i]['user_nickname'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.$userlist[$i]['user_phone'].'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.$userlist[$i]['user_email'].'</td>';
					
					
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.date('Y-m-d H:i:s', $userlist[$i]['edited']).'</td>';
					echo '<td style="min-height:30px;border:.5pt solid windowtext;background:#EFEFEF;" align="center" class="xl2216681 nowrap">'.$userlist[$i]['edited_author'].'</td>';
					echo '</tr>';
				}}
				//选择数据--结束
		echo '</table>
		</div>
		</body>
		</html>';
