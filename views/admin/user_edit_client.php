<?php 
$this->load->view('admin/subheader');
/*echo '<pre>';
print_r($userinfo);
exit;*/
?>
<script type='text/javascript' src='<?php echo base_url()?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 99%;
        margin-top: 60px;
    }

    #customers input {
        width: 80%;
    }

    customers th {
        border: 1px solid #ddd;
        padding: 8px;
        width: 23%;
    }

    #td1 {
        border: 1px solid #ddd;
        padding: 8px;
        width: 10%;
    }

    #td2 {
        border: 1px solid #ddd;
        padding: 8px;
        width: 35%;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    #customers1 {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        float: left;
    }

    #customers1 td,
    #customers1 th {
        padding: 8px;
    }

    #customers1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>	
<form method="post">
	<table class="gksel_normal_tabpost">
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_user_nickname')?></td>
				<td align="left">
					<input type="text" name="user_nickname" value="<?php echo $userinfo['user_nickname']?>"/>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] > 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Login ID</td>
				<td align="left">
					<input type="text" name="user_number" value="<?php echo $userinfo['user_number']?>"/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150">Username</td>
				<td align="left">
					<input type="text" name="user_realname" value="<?php echo $userinfo['user_realname']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			
			<tr>
				<td align="right" width="150">Brand Name</td>
				<td align="left">
					<input type="text" name="user_brandname" required value="<?php echo $userinfo['user_brandname']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			
			<tr <?php if($userinfo['parent'] > 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150"><?php echo lang('dz_user_sex')?></td>
				<td align="left">
					<select name="user_sex" class="select_usersex">
						<option value="0"><?php echo lang('dz_user_sex_unknown')?></option>
						<option value="1" <?php if($userinfo['user_sex'] != '' && $userinfo['user_sex'] == 1){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '男';}else{echo 'Male';}?></option>
						<option value="2" <?php if($userinfo['user_sex'] != '' && $userinfo['user_sex'] == 2){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '女';}else{echo 'Female';}?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
				<td align="left">
					<input type="text" name="user_phone" disabled="disabled" value="<?php echo $userinfo['user_phone']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] > 0){echo 'style="display:none;"';}?>>
				<td align="right"><?php echo lang('dz_user_password')?></td>
				<td align="left">
					<input type="text" onfocus="this.type='password'" name="password" value=""/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
				<td align="left">
					<input type="text" name="user_email" value="<?php echo $userinfo['user_email']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] == 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Address</td>
				<td align="left">
					<input type="text" name="user_address" value="<?php echo $userinfo['user_address']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] == 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Birthday</td>
				<td align="left">
					<input type="text" name="user_birthday" value="<?php echo $userinfo['user_birthday']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] == 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Industry</td>
				<td align="left">
					<input type="text" name="user_industry" value="<?php echo $userinfo['user_industry']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] == 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Wechat</td>
				<td align="left">
					<input type="text" name="user_wechat" value="<?php echo $userinfo['user_wechat']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr <?php if($userinfo['parent'] == 0){echo 'style="display:none;"';}?>>
				<td align="right" width="150">Nationality</td>
				<td align="left">
					<input type="text" name="user_nationality" value="<?php echo $userinfo['user_nationality']?>"/>
					<div class="tipsgroupbox"><div class="request"></div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_profile')?></td>
				<td align="left">
					<textarea name="user_profile"><?php echo $userinfo['user_profile']?></textarea>
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
					<input type="text" name="company_name" value="<?php echo $userinfo['company_name']?>"/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_title')?></td>
				<td align="left">
					<input type="text" name="company_title" value="<?php echo $userinfo['company_title']?>"/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_email')?></td>
				<td align="left">
					<input type="text" name="company_email" value="<?php echo $userinfo['company_email']?>"/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_address')?></td>
				<td align="left">
					<input type="text" name="company_address" value="<?php echo $userinfo['company_address']?>"/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display: none;">
				<td align="right" width="150"><?php echo lang('dz_company_tel')?></td>
				<td align="left">
					<input type="text" name="company_phone" value="<?php echo $userinfo['company_phone']?>"/>
					<div class="tipsgroupbox"></div>
				</td>
			</tr>
			<tr style="display:none;">
				<td align="right">Upload PDF</td>
				<td>
					<div class="img_gksel_show" id="img1_gksel_show">
						<?php 
							$img1_gksel = '';
							if(file_exists($userinfo['company_businesslicense']) && $userinfo['company_businesslicense']!=""){
								$img1_gksel = $userinfo['company_businesslicense'];
								echo '<a target="_blank" href="'.base_url().$userinfo['company_businesslicense'].'">Download</a>';
							}
						?>
					</div>
					<button class="img_gksel_choose" id="img1_gksel_choose">Upload PDF</button>
					<div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel;?>"/></div>
					<div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;"></font></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('cy_status')?></td>
				<td align="left">
					<input type="radio" name="status" value="1" <?php if($userinfo['status'] == 1){echo 'checked';}?>/> <?php echo lang('cy_online')?>
					<input type="radio" name="status" value="0" <?php if($userinfo['status'] != 1){echo 'checked';}?>/> <?php echo lang('cy_offline')?>
				</td>
			</tr>
                        
                        <!-- start from here -->
                        <tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="tosave_userinfo(<?php echo $userinfo['uid']?>, <?php echo $userinfo['user_type']?>)"><?php echo lang('cy_save')?></div>
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