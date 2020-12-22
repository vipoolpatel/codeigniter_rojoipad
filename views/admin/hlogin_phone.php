<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo base_url()?>themes/default/images/rojo.ico?date=<?php echo CACHE_USETIME()?>" type="image/x-icon" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="format-detection" content="telephone=no" /> 
<link rel="stylesheet" href="<?php echo CDN_URL();?>themes/default/admin.css?date=<?php echo CACHE_USETIME()?>" />
<title>Rojo Clothing</title>
<script type="text/javascript">
<!--
function getauthimg(authur) {
	document.getElementById('authimg').src = authur+"?"+Math.random(1);
	document.getElementById('authimg1').src = document.getElementById('authimg').src;
}
//-->
</script>
</head>

<body>

<div class="main" style="-webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(80%, transparent), to(rgba(255, 255, 255, 0.5)));">
	<table width="100%" cellpadding="0" cellspacing="0" border=0 style="margin-top:20%; ">
		<tr>
			<td width="100%" valign="middle" align="center">
				<div style="float:right;text-align:center;width:100%;">
					<a href="<?php echo base_url().'index.php/admin/index'?>" style="display:block;margin:auto;text-align:center;width:100%;">
						<img height="16" src="<?php echo CDN_URL().'themes/default/images/newlogo.png'?>" style="margin-left:-25%"/>
					</a>
				</div>	
				<div style="float:left;width:100%;">
					<div style="float:right;margin:5px 160px 0px 0px;">
						
					</div>
				</div>
			</td>
			</tr>
			<tr style="margin-top:100px;display:block;">
			<td width="80%" valign="middle" align="left" style="background:#000000;">
				<ul class="loginmain_right" >
					<li class="login_line">
						<form name="loginform" action="<?php echo base_url().'index.php/admin/tologin'?>" method="post" >
							<table cellpadding="0" cellspacing="0" border=0 style="color:white; font-weight:bolder; margin-left:20px;">
								<tr>
									<td height="35" align="right">Username&nbsp;&nbsp;</td>
									<td><input name="aname" type="text" value="<?php echo set_value('aname')?>"/></td>
									<td>
										<p class="logmsg" align="left">&nbsp;&nbsp;&nbsp;<?php if(isset($aname_error)) echo $aname_error;?></p>
									</td>
								</tr>
								<tr>
									<td height="35" align="right">Password&nbsp;&nbsp;</td>
									<td><input name="apass" type="password"/></td>
									<td>
										<p class="logmsg" align="left">&nbsp;&nbsp;&nbsp;<?php if(isset($apass_error)) echo $apass_error;?></p>
									</td>
								</tr>
								<input name="ishaveyanzhengma" type="hidden" value="<?php if(isset($ishaveyanzhengma) && $ishaveyanzhengma == 1){echo 1;}else{echo 0;}?>"/>
								<?php if(isset($ishaveyanzhengma) && $ishaveyanzhengma == 1){?>
									<tr>
										<td height="35">Verification Code&nbsp;&nbsp;</td>
										<td>
											
											<div style="float:left;">
												<?php $authurl = base_url()."authimg.php"; ?>
												<img class="houtai_login_code_img" src="<?php echo $authurl ?>" onclick="this.src=this.src+'?'+Math.random();" />
											</div>
											<div style="float:left;margin:0px 0px 0px 10px;">
												<input type="text" name="code" id="code" value="" size="4"/>
											</div>
											<div style="float:left;margin:0px 0px 0px 10px;color:red;">
												<?php if(isset($code_error)){echo $code_error;}?>
											</div>
										</td>
									</tr>
								<?php }?>
								<tr>
									<td align="left">
										
									</td>
									<td>
										<input style="float:left;border:0;width:60px;height:30px;background:#111d35;color:white;font-weight:bold;" type="submit" value="<?php echo lang('cy_login')?> "  />
										<div style="float:left;color:red;margin-top:7px;">&nbsp;&nbsp;&nbsp;<?php if(isset($error)) echo $error;?></div>
									</td>
								</tr>
							</table>
						</form>	
					</li>
				</ul>
			</td>
		</tr>
	</table>
</div>

</body>
</html>