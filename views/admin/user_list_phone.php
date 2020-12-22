<?php $this->load->view('admin/header')?>
<style>
.Frame_Leftmenu{display:none}
.Frame_Body {left:0;}
.gksel_normal_tablist tbody {font-size:12px;}
.Frame_Header .logo{width:30%;height:auto;margin-top:25px;}
.Frame_Header .infomation{width:45%;}
.Frame_Header .infomation .infoarea img{}

</style>
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

<?php $this->load->view('admin/admin_phone')?>
<table class="gksel_normal_tabaction">
	<tr>
		<td>
			<div class="searcharea">
				<form action = "<?php echo base_url().'index.php/admins/user/user_list_phone'?>" method="get">
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
</table>
<table class="gksel_normal_tabaction">
    <tr>
        <td>
            <div class="searcharea">
                <!--
				<a href="<?php echo base_url() . 'RO/index.html' ?>"><font class="nav_on">FORM </font></a>
				-->
                <a href="<?php echo base_url() . 'index.php/admins/user/toadd_user_phone/' . $user_type . '?backurl=' . $current_url_encode ?>"><font
                            class="nav_on"><img class="plus"
                                                src="<?php echo base_url() . 'themes/default/images/plus.png' ?>"/> <?php echo lang('dz_user_add') ?></font></a>
                <div onclick="location.href='<?php echo base_url() . 'index.php/admins/user/index?user_type=' . $user_type . '&keyword=' . $keyword . '&is_excel=1' ?>';"
                     style="float: left;margin-top:7px;cursor:pointer;">
                    <div style="float: left;margin-left:5px;display:none">
                        <img src="<?php echo base_url() . 'themes/default/images/icon_xls.gif' ?>"/>
                    </div>
                    <div style="float: left;margin-left:5px;display:none">
                        Export Excel
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td width="300" style="text-align:center"><p>&nbsp;&nbsp;&nbsp;Customer Number</p><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_realname')?></p><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_contact')?></p></td>
			
			<td width="165" align="center" style="display:none"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center" style="display:none"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="420" align="center" ><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($userlist)){for ($i = 0; $i < count($userlist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td style="text-align:center"><?php echo $userlist[$i]['user_number']?><br><br>
				   <p>
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
				   </p><br>
				   <p>
				     <?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_phone'])).'<br />';?>
					
					<?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($userlist[$i]['user_email']));?>
				   </p>
				</td>
				<td style="display:none">
					
				</td>
				<td style="display:none">
					
				</td>
				<td align="center" style="display:none"><?php echo date('Y-m-d H:i:s', $userlist[$i]['edited'])?></td>
				<td align="center" style="display:none"><?php echo $userlist[$i]['edited_author']?></td>
				<td align="center">
					<div style="float:right;margin-right:30%">
						<?php 
							$con=array('uid'=>$userlist[$i]['uid'], 'orderby'=>'form_id', 'orderby_res'=>'DESC');
							$count_form = $this->UserModel->getuser_formlist($con, 1);
							if($count_form > 0){
								$class = 'gksel_btn_action_on';
								$alink = base_url().'index.php/admins/user/form_list/'.$userlist[$i]['uid'].'?backurl='.$current_url_encode;
								$text = 'FORM <font style="color:#000;font-weight:bold;">('.$count_form.')</font>';
							}else{
								$class = 'gksel_btn_action_off';
								$alink = base_url().'index.php/admins/user/form_list/'.$userlist[$i]['uid'].'?backurl='.$current_url_encode;
								$text = 'FORM';
							}
							
						
						
						
								$con=array('uid'=>$userlist[$i]['uid'], 'orderby'=>'address_id', 'orderby_res'=>'DESC');
								$count_address=$this->UserModel->getaddresslist($con, 1);
								if($count_address > 0){
									$class = 'gksel_btn_action_on';
									$alink = base_url().'index.php/admins/user/address_list/'.$userlist[$i]['uid'].'?backurl='.$current_url_encode;
									$text = lang('dz_user_address_manage').' <font style="color:#000;font-weight:bold;">('.$count_address.')</font>';
								}else{
									$class = 'gksel_btn_action_off';
									$alink = 'javascript:;';
									$text = lang('dz_user_address_manage');
								}
								
								
								echo '<a href="'.base_url().'index.php/admins/user/toedit_user/'.$userlist[$i]['user_type'].'/'.$userlist[$i]['uid'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on" style="margin-right:50% !important;">'.lang('cy_edit').'</a>';
								
								
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>
<?php $this->load->view('admin/footer')?>
<script> 
// $(document).ready(function (){
// 	$(".user_phone_user").click(function(){
// 		if($(".user_phone_user_child").css("display")=="none"){
// 			$(".user_phone_user_child").slideDown(500);  
		
// 		}else{
// 			$(".user_phone_user_child").slideUp(500);
// 		}
// 	});
// 	$(".user_phone_qr").click(function(){
// 		if($(".user_phone_qr_child").css("display")=="none"){
// 			$(".user_phone_qr_child").slideDown(500);  
		
// 		}else{
// 			$(".user_phone_qr_child").slideUp(500);
// 		}
// 	});
// })
 </script> 