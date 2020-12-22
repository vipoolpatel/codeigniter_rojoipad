<?php $this->load->view('admin/header')?>
<script type='text/javascript' src='<?php echo base_url()?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
<style>
.Frame_Leftmenu{display:none}
.Frame_Body {left:0;}
.gksel_normal_tablist tbody {font-size:12px;}
.Frame_Header .logo{width:30%;height:auto;margin-top:25px;}
.Frame_Header .infomation{width:45%;}
.Frame_Header .infomation .infoarea img{}
</style>	
<?php $this->load->view('admin/admin_phone')?>



<form method="post">
	<table class="gksel_normal_tabpost">
		
			<tr class="thead">
				<td align="right" width="150"><?php echo lang('dz_user_information')?></td>
				<td align="left">
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr style="display:none;">
				<td align="right" width="150"><?php echo lang('dz_user_nickname')?></td>
				<td align="left">
					<input type="text" name="user_nickname" value=""/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150">Customer Number</td>
				<td align="left">
					<input type="text" name="user_number" value=""/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_realname')?></td>
				<td align="left">
					<input type="text" name="user_realname" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_sex')?></td>
				<td align="left">
					<select name="user_sex" class="select_usersex">
						<option value="0"><?php echo lang('dz_user_sex_unknown')?></option>
						<option value="1"><?php echo lang('dz_user_sex_male')?></option>
						<option value="2"><?php echo lang('dz_user_sex_female')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
				<td align="left">
					<input type="text" name="user_phone" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo lang('dz_user_password')?></td>
				<td align="left">
					<input type="text" onfocus="this.type='password'" name="password" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
				<td align="left">
					<input type="text" name="user_email" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_profile')?></td>
				<td align="left">
					<textarea name="user_profile"></textarea>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr class="thead" style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_information')?></td>
				<td align="left">
				</td>
			</tr>
			<tr style="display: none;"><td colspan="2"></td></tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_name')?></td>
				<td align="left">
					<input type="text" name="company_name" value=""/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_title')?></td>
				<td align="left">
					<input type="text" name="company_title" value=""/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_email')?></td>
				<td align="left">
					<input type="text" name="company_email" value=""/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_address')?></td>
				<td align="left">
					<input type="text" name="company_address" value=""/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_tel')?></td>
				<td align="left">
					<input type="text" name="company_phone" value=""/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr>
				<td align="right">Upload PDF</td>
				<td>
					<div class="img_gksel_show" id="img1_gksel_show">
						<?php 
							$img1_gksel = '';
						?>
					</div>
					<div class="img_gksel_choose" id="img1_gksel_choose">Upload PDF</div>
					<div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel;?>"/></div>
					<div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;"></font></div>
				</td>
			</tr>
		
			<tr class="thead">
				<td align="right" width="150"><?php echo lang('dz_company_information')?></td>
				<td align="left">
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr>
				<td align="right"><?php echo lang('dz_company_businesslicense')?></td>
				<td>
					<div class="img_gksel_show" id="img1_gksel_show">
						<?php 
							$img1_gksel = '';
						?>
					</div>
					<div class="img_gksel_choose" id="img1_gksel_choose">上传图片</div>
					<div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel;?>"/></div>
					<div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;">仅支持 Jpg, Png, Gif 格式</font></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_company_name')?></td>
				<td align="left">
					<input type="text" name="company_name" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_company_title')?></td>
				<td align="left">
					<input type="text" name="company_title"/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_company_email')?></td>
				<td align="left">
					<input type="text" name="company_email" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_company_address')?></td>
				<td align="left">
					<input type="text" name="company_address" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_company_tel')?></td>
				<td align="left">
					<input type="text" name="company_phone" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr class="thead">
				<td align="right" width="150">注册人信息</td>
				<td align="left">
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_nickname')?></td>
				<td align="left">
					<input type="text" name="user_nickname" value=""/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_realname')?></td>
				<td align="left">
					<input type="text" name="user_realname" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
				<td align="left">
					<input type="text" name="user_phone" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo lang('dz_user_password')?></td>
				<td align="left">
					<input type="text" onfocus="this.type='password'" name="password" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
				<td align="left">
					<input type="text" name="user_email" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
		
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_nickname')?></td>
				<td align="left">
					<input type="text" name="user_nickname" value=""/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_realname')?></td>
				<td align="left">
					<input type="text" name="user_realname" value=""/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
				<td align="left">
					<input type="text" name="user_phone" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo lang('dz_user_password')?></td>
				<td align="left">
					<input type="text" onfocus="this.type='password'" name="password" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
				<td align="left">
					<input type="text" name="user_email" value=""/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
		
		<tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="toadd_userinfo(1)"><?php echo lang('cy_save')?></div>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var button_gksel1 = $('#img1_gksel_choose'), interval;
	if(button_gksel1.length>0){
		new AjaxUpload(button_gksel1,{
			action: baseurl+'index.php/welcome/upfile', 
			name: 'logo',onSubmit : function(file, ext){
				if (ext && /^(pdf)$/.test(ext)){
					button_gksel1.text('Uploading');
					this.disable();
					interval = window.setInterval(function(){
						var text = button_gksel1.text();
						if (text.length < 13){
							button_gksel1.text(text + '.');					
						} else {
							button_gksel1.text('Uploading');				
						}
					}, 200);
				} else {
					$('#img1_gksel_error').html('Upload Fail');
					return false;
				}
			},
			onComplete: function(file, response){
				button_gksel1.text('Upload PDF');						
				window.clearInterval(interval);
				this.enable();
				if(response=='false'){
					$('#img1_gksel_error').html('Upload Fail');
				}else{
					var pic = eval("("+response+")");
					$('#img1_gksel_show').html('<a target="_blank" href="'+baseurl+pic.logo+'">Download</a>');
					$('#img1_gksel').attr('value',pic.logo);
					$('#img1_gksel_error').html('');
				}	
			}
		});
	}
})
</script>
<?php $this->load->view('admin/footer')?>