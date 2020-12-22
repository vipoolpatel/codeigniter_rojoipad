<?php $this->load->view('admin/header')?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<form method="post">
	<table class="gksel_normal_tabpost">
		<tr><td colspan="2"></td></tr>
		<tr>
			<td align="right" width="150"><?php echo lang('dz_user_realname')?></td>
			<td align="left">
				<input type="text" name="address_realname" value="<?php echo $addressinfo['address_realname']?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		<tr>
			<td align="right" width="150"><?php echo lang('dz_user_phone')?></td>
			<td align="left">
				<input type="text" name="address_phone" value="<?php echo $addressinfo['address_phone']?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		<tr>
			<td align="right" width="150"><?php echo lang('dz_user_email')?></td>
			<td align="left">
				<input type="text" name="address_email" value="<?php echo $addressinfo['address_email']?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		<tr>
			<td align="right" width="150"><?php echo lang('dz_user_address')?></td>
			<td align="left">
				<select id="provinceID" name="provinceID">
					<option value="0">选择省份</option>
					<?php 
						$province = $this->UserModel->getprovince();
						if(!empty($province)){
							for($i=0;$i<count($province);$i++){
								if($addressinfo['address_province_id']==$province[$i]['provinceID']){
									$isselected = 'selected';
								}else{
									$isselected = '';
								}
								echo '<option value="'.$province[$i]['provinceID'].'" '.$isselected.'>'.$province[$i]['province'.$this->langtype].'</option>';
							}
						}
					?>
				</select>
				<div class="tipsgroupbox"><div class="request">*</div></div>
				<select id="cityID" name="cityID">
					<option value=0>选择城市</option>
					<?php 
							$city = $this->UserModel->getcity($addressinfo['address_province_id']);
							if(!empty($city)){
								for($i=0;$i<count($city);$i++){
									if($addressinfo['address_city_id']==$city[$i]['cityID']){
										$isselected = 'selected';
									}else{
										$isselected = '';
									}
									echo '<option value="'.$city[$i]['cityID'].'" '.$isselected.'>'.$city[$i]['city'.$this->langtype].'</option>';
								}
							}
					?>
				</select>
				<div class="tipsgroupbox"><div class="request">*</div></div>
				<select id="areaID" name="areaID">
					<option value="0"><?php if($this->langtype == '_ch'){echo '选择区域';}else{echo 'Select Area';}?></option>
					<?php 
							$area = $this->UserModel->getarea($addressinfo['address_city_id']);
							if(!empty($area)){
								for($i=0;$i<count($area);$i++){
									if($addressinfo['address_area_id']==$area[$i]['areaID']){
										$isselected = 'selected';
									}else{
										$isselected = '';
									}
									echo '<option value="'.$area[$i]['areaID'].'" '.$isselected.'>'.$area[$i]['area'.$this->langtype].'</option>';
								}
							}
					?>
				</select>
				<div class="tipsgroupbox"><div class="request">*&nbsp;&nbsp;</div></div>
				<input type="text" name="address_street_address" value="<?php echo $addressinfo['address_street_address']?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		<tr>
			<td align="right" width="150"><?php echo lang('dz_user_zipcode')?></td>
			<td align="left">
				<input type="text" name="address_zip_code" value="<?php echo $addressinfo['address_zip_code']?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		
		<tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="tosave_useraddressinfo(<?php echo $userinfo['uid']?>, <?php echo $addressinfo['address_id']?>)"><?php echo lang('cy_save')?></div>
			</td>
		</tr>
	</table>
</form>

<?php $this->load->view('admin/footer')?>