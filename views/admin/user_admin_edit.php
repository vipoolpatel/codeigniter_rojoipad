<?php $this->load->view('admin/header')?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<form method="post">
	<table class="gksel_normal_tabpost">
			<tr><td colspan="2"></td></tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_username')?></td>
				<td align="left">
					<input type="text" name="admin_username" value="<?php echo $admininfo['admin_username']?>"/>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
				<td align="left">
					<input type="text" name="admin_email" value="<?php echo $admininfo['admin_email']?>"/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_sex')?></td>
				<td align="left">
					<select name="admin_sex" class="select_usersex">
						<option value="0"><?php echo lang('dz_user_sex_unknown')?></option>
						<option value="1" <?php if($admininfo['admin_sex'] != '' && $admininfo['admin_sex'] == 1){echo 'selected';}?>><?php echo lang('dz_user_sex_male')?></option>
						<option value="2" <?php if($admininfo['admin_sex'] != '' && $admininfo['admin_sex'] == 2){echo 'selected';}?>><?php echo lang('dz_user_sex_female')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
				<td align="left">
					<input type="text" name="admin_phone" value="<?php echo $admininfo['admin_phone']?>"/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo lang('dz_user_password')?></td>
				<td align="left">
					<input type="text" onfocus="this.type='password'" name="admin_password" value=""/>
				</td>
			</tr>
			<?php if($admin_type == 2){?>
			<tr class="thead">
				<td align="right" width="150">权限</td>
				<td align="left">
				</td>
			</tr>
			<tr>
				<td align="right" width="150"></td>
				<td align="left" style="line-height:25px;">
					<?php 
						$admin_roles = $admininfo['admin_roles'];
						if($admin_roles != ''){
							$admin_roles_arr = unserialize($admin_roles);
						}else{
							$admin_roles_arr = array();
						}
					?>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 101;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_article_category_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 102;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_article_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 103;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_cms_aboutus')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 104;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_cms_contactus')?></label>
						</div>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 201;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_user_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 202;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_company_business_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 203;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_user_contentproviders_manage')?></label>
						</div>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 301;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_product_category_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 302;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_product_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 303;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_product_recommended_manage')?></label>
						</div>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 401;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_order_all')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 402;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_order_pending')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 403;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_order_delivery')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 404;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_order_print')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 405;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('dz_order_finish')?></label>
						</div>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 901;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_feedback_manage')?></label>
						</div>
						<?php 
						$ischecked = '';
						$thisval = 902;
						if(!empty($admin_roles_arr)){
							for ($i = 0; $i < count($admin_roles_arr); $i++) {
								if($admin_roles_arr[$i] == $thisval){
									$ischecked = 'checked';
								}
							}
						}
						?>
						<div style="float: left;width:230px;">
							<input type="checkbox" name="admin_roles[]" value="<?php echo $thisval;?>" id="roles_<?php echo $thisval;?>" <?php echo $ischecked;?>/> <label for="roles_<?php echo $thisval;?>"><?php echo lang('cy_setting')?></label>
						</div>
					</div>
				</td>
			</tr>
			<?php }?>
		<tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="tosave_admininfo(<?php echo $admin_type?>, <?php echo $admininfo['admin_id']?>)"><?php echo lang('cy_save')?></div>
			</td>
		</tr>
	</table>
</form>
<?php $this->load->view('admin/footer')?>