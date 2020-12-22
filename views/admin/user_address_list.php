<?php $this->load->view('admin/header')?>
<?php 
$get_str='';
if($_GET){
	$arr = geturlparmersGETS();
	for($i=0;$i<count($arr);$i++){
		if(isset($_GET[$arr[$i]])){
			if($get_str!=""){$get_str .='&';}else{$get_str .='?';}
			$get_str .=$arr[$i].'='.$_GET[$arr[$i]];
		}
	}
}
$current_url = current_url();
$current_url_encode=str_replace('/','slash_tag',base64_encode($current_url.$get_str));

?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<table class="gksel_normal_tabaction">
	<tr>
		<td></td>
		<td>
		</td>
	</tr>
</table>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_realname')?></p></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_phone')?></p></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_email')?></p></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_address')?></p></td>
			<td width="165" align="center"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="200"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($addresslist)){for ($i = 0; $i < count($addresslist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td>
					<?php echo trim($addresslist[$i]['address_realname']);?>
				</td>
				<td>
					<?php echo trim($addresslist[$i]['address_phone']);?>
				</td>
				<td>
					<?php echo trim($addresslist[$i]['address_email']);?>
				</td>
				<td>
					<?php echo trim($addresslist[$i]['address_province_name']);?>
					<?php echo trim($addresslist[$i]['address_city_name']);?>
					<?php echo trim($addresslist[$i]['address_area_name']);?>
					<?php echo trim($addresslist[$i]['address_street_address']);?>
					<?php echo trim($addresslist[$i]['address_zip_code']);?>
				</td>
				<td align="center"><?php echo date('Y-m-d H:i:s', $addresslist[$i]['edited'])?></td>
				<td align="center"><?php echo $addresslist[$i]['edited_author']?></td>
				<td>
					<div style="float:right;">
						<?php 
							echo '<a href="'.base_url().'index.php/admins/user/toedit_address/'.$uid.'/'.$addresslist[$i]['address_id'].'?backurl='.$backurl.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>

<?php $this->load->view('admin/footer')?>