<?php $this->load->view('admin/subheader')?>
<script type='text/javascript' src='<?php echo base_url()?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<form method="post">
	<table class="gksel_normal_tabpost">
            <tr><td colspan="4" style="font-weight: bold; font-size: 20px;"><center><?php echo lang('measurement_cap')?></center></td></tr>
			<tr>
				<td align="right" width="150"><?php echo lang('cy_measurements')?></td>
				<td align="left">
					<select id="user_measurement" name="user_measurement" class="select_userlang">
						<option value=""><?php echo lang('measurement_unknown')?></option>
						<option value="CM" <?php if($userinfo['user_measurement'] != '' && $userinfo['user_measurement'] == 'CM'){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '厘米';}else{echo 'CM';}?></option>
						<option value="UK INCHES" <?php if($userinfo['user_measurement'] != '' && $userinfo['user_measurement'] == 'UK INCHES'){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '英國 INCHES';}else{echo 'UK INCHES';}?></option>
                                                <option value="CN INCHES" <?php if($userinfo['user_measurement'] != '' && $userinfo['user_measurement'] == 'CN INCHES'){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo 'CN INCHES';}else{echo 'CN INCHES';}?></option>
                                        </select>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			
		<tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="toupdate_user_measurement(<?php echo $userinfo['uid']?>, <?php echo $userinfo['user_type']?>)"><?php echo lang('cy_save')?></div>
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