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
<table class="gksel_normal_tabaction">
	<tr>
		<td>
			<div class="searcharea">
				<div class="ma_actions">
					<ul>
						<li>
							<a href="<?php echo base_url().'index.php/admins/email/index'?>"><font class="nav_on">Manage Auto Response</font></a>
						</li>
						<li>
							<a href="<?php echo base_url().'index.php/admins/email/tosetting_email'?>"><font class="nav_off">Email Settings</font></a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
</table>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td align="left"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('cy_name')?></p></td>
			<td align="left"><p>&nbsp;&nbsp;&nbsp;From</p></td>
			<td align="left"><p>&nbsp;&nbsp;&nbsp;To</p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="100" align="center"><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($emaillist)){for ($i = 0; $i < count($emaillist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td align="left"><?php echo $emaillist[$i]['email_name'.$this->langtype];?></td>
				<td align="left"><?php echo $emaillist[$i]['email_from'];?></td>
				<td align="left"><?php echo $emaillist[$i]['email_to'];?></td>
				<td align="center"><?php echo $emaillist[$i]['edited_author']?></td>
				<td align="center">
					<div style="float:right;">
						<?php 
							echo '<a href="'.base_url().'index.php/admins/email/toedit_email/'.$emaillist[$i]['email_id'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>

<?php $this->load->view('admin/footer')?>