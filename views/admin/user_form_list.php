<?php $this->load->view('admin/header')?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>

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
		<td>
			<div class="searcharea">
				<a href="<?php echo base_url().'index.php/admins/user/toadd_form/'.$uid.'?backurl='.$backurl.'&subbackurl='.$current_url_encode?>"><font class="nav_on"><img class="plus" src="<?php echo base_url().'themes/default/images/plus.png'?>"/>Add FORM</font></a>
			</div>
		</td>
	</tr>
</table>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td><p>&nbsp;&nbsp;&nbsp;Form Name</p></td>
			<td width="165" align="center"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="200"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($formlist)){for ($i = 0; $i < count($formlist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td>
					<?php echo trim($formlist[$i]['form_name']);?>
				</td>
				<td align="center"><?php echo date('Y-m-d H:i:s', $formlist[$i]['edited'])?></td>
				<td align="center"><?php echo $formlist[$i]['edited_author']?></td>
				<td>
					<div style="float:right;">
						<?php 
							echo '<a href="'.base_url().'index.php/admins/user/toedit_form/'.$uid.'/'.$formlist[$i]['form_id'].'?backurl='.$backurl.'&subbackurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
							echo '<a onclick="todel_user_form('.$formlist[$i]['form_id'].', \''.$formlist[$i]['form_name'].'\')" href="javascript:;" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>

<?php $this->load->view('admin/footer')?>