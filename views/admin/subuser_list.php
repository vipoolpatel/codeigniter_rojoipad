<?php $this->load->view('admin/subheader')?>
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

$user_type = $this->input->get('user_type');
$keyword = $this->input->get('keyword');
?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<!--<table class="gksel_normal_tabaction">
	<tr>
		<td>
			<div class="searcharea">
				<form action = "<?php echo base_url().'index.php/admins/user/index'?>" method="get">
					<select name="user_type" class="select_usertype displaynone">
						<option value=""><?php echo lang('cy_all')?></option>
						<option value="1" <?php if($user_type != '' && $user_type == 1){echo 'selected';}?>>客户</option>
						<option value="2" <?php if($user_type != '' && $user_type == 2){echo 'selected';}?>>供应商</option>
					</select>
					<input type="text" name="keyword" placeholder="<?php echo lang('cy_enter_keyword')?>" value="<?php echo $keyword?>"/>
					<input type="submit" value="<?php echo lang('cy_search')?>"/>
				</form>
			</div>
		</td>
	</tr>
</table>-->

<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<!-- 
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			 -->
			<td width="165"><p style="border-left:0px;">&nbsp;&nbsp;&nbsp;Login ID</p></td>
			<td><p>&nbsp;&nbsp;&nbsp;Administrator</p></td>
			<td width="165"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_contact')?></p></td>
			<td width="165" align="center"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="280" align="center"><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($userlist)){for ($i = 0; $i < count($userlist); $i++) {?>
			<?php 
				$con=array('parent'=>$userlist[$i]['uid'], 'orderby'=>'u.user_number','orderby_res'=>'DESC', 'row'=>0, 'page'=>1);
				$subuserlist = $this->UserModel->getuserlist($con);
			?>
			<tr>
				<!-- 
				<td align="center" style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>"><?php echo $i+1?></td>
				 -->
				<td align="left" style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>"><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_number']));?></td>
				<td style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>">
					<?php 
						if($userlist[$i]['user_type'] == 1){
							if($userlist[$i]['user_sex'] == 1){
								echo '<img style="width:16px;height:16px;" src="'.base_url().'themes/default/images/sex_male.jpg"/>';
							}else if($userlist[$i]['user_sex'] == 2){
								echo '<img style="width:16px;height:16px;" src="'.base_url().'themes/default/images/sex_female.jpg"/>';
							}
						}else{
							echo '-';
						}
					?>
					<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_realname']));?>
				</td>
				<td style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>">
					<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_phone'])).'<br />';?>
					<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_email'])).'<br />';?>
					<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_address'])).'<br />';?>
				</td>
				<td align="center" style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>"><?php echo date('Y-m-d H:i:s', $userlist[$i]['edited'])?></td>
				<td align="center" style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>"><?php echo $userlist[$i]['edited_author']?></td>
				<td align="center" style="padding:5px 0px;<?php if(count($subuserlist) > 0){echo 'border-bottom:0px;';}?>">
					<div style="float:right;">
						<?php 
								echo '<a href="'.base_url().'index.php/admins/user/toedit_client_user/'.$userlist[$i]['user_type'].'/'.$userlist[$i]['uid'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
								if(empty($subuserlist)){
									echo '<a onclick="todel_user('.$userlist[$i]['uid'].', \''.$userlist[$i]['user_phone'].'\')" href="javascript:;" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
								}
						?>
					</div>
				</td>
			</tr>
			<?php 
			$subuserlist = array();
			if(!empty($subuserlist)){for ($j = 0; $j < count($subuserlist); $j++) {?>
				<tr>
					<!-- x
					<td align="center" style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>"></td>
					 -->
					<td align="right" style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>"></td>
					<td style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>">
						<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($subuserlist[$j]['user_realname']));?>
					</td>
					<td style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>">
						<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($subuserlist[$j]['user_phone'])).'<br />';?>
						<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($subuserlist[$j]['user_email'])).'<br />';?>
						<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($subuserlist[$j]['user_address'])).'<br />';?>
					</td>
					<td align="center" style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>"><?php echo date('Y-m-d H:i:s', $subuserlist[$j]['edited'])?></td>
					<td align="center" style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>"><?php echo $subuserlist[$j]['edited_author']?></td>
					<td align="center" style="padding:5px 0px;<?php if($j != (count($subuserlist) - 1)){echo 'border-bottom:0px;';}?>">
						<div style="float:right;">
							<?php 
									echo '<a href="'.base_url().'index.php/admins/user/toedit_user/'.$subuserlist[$j]['user_type'].'/'.$subuserlist[$j]['uid'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
									echo '<a onclick="todel_user('.$subuserlist[$j]['uid'].', \''.$subuserlist[$j]['user_phone'].'\')" href="javascript:;" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
							?>
						</div>
					</td>
				</tr>
			<?php }}?>
		<?php }}?>
	</tbody>
	<?php if(isset($fy)){?>
		<thead>
			<tr>
				<td colspan="8"><?php echo $fy;?></td>
			</tr>
		</thead>
	<?php }?>
</table>
<?php $this->load->view('admin/footer')?>