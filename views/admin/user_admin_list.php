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

$keyword = $this->input->get('keyword');
$admin_type = $this->input->get('admin_type');
?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
<?php if($admin_type == 2){?>
	<table class="gksel_normal_tabaction">
		<tr>
			<td>
				<div class="searcharea">
					<form action = "<?php echo base_url().'index.php/admins/user/adminassistantlist?admin_type='.$admin_type?>" method="get">
						<input type="hidden" name="admin_type" value="<?php echo $admin_type?>"/>
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
                    <a href="<?php echo base_url() . 'index.php/admins/user/toadd_adminassistant/' . $admin_type . '?backurl=' . $current_url_encode ?>"><font
                                class="nav_on"><img class="plus"
                                                    src="<?php echo base_url() . 'themes/default/images/plus.png' ?>"/> <?php echo lang('cy_admin_assistant_add'); ?>
                        </font></a>
                    <div onclick="location.href='<?php echo base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type . '&keyword=' . $keyword . '&is_excel=1' ?>';"
                         style="float: left;margin-top:7px;cursor:pointer;">
                        <div style="float: left;margin-left:5px;">
                            <img src="<?php echo base_url() . 'themes/default/images/icon_xls.gif' ?>"/>
                        </div>
                        <div style="float: left;margin-left:5px;">
                            Export Excel
                        </div>
                    </div>
                </div>
            </td>
        </tr>
	</table>
<?php }?>

<?php if($admin_type == 1){?>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_username')?></p></td>
			<td width="165"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_email')?></p></td>
			<td width="120"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_phone')?></p></td>
			<td width="165" align="center"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="200" align="center"><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($adminlist)){for ($i = 0; $i < count($adminlist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_username']));?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_email']));?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_phone']));?></td>
				<td align="center"><?php echo date('Y-m-d H:i:s', $adminlist[$i]['edited'])?></td>
				<td align="center"><?php echo $adminlist[$i]['edited_author']?></td>
				<td align="center">
					<div style="float:right;">
						<?php 
							echo '<a href="'.base_url().'index.php/admins/user/toedit_adminassistant/'.$admin_type.'/'.$adminlist[$i]['admin_id'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
							if($adminlist[$i]['admin_type'] == 2){
								echo '<a onclick="todel_adminassistant('.$adminlist[$i]['admin_id'].', \''.$adminlist[$i]['admin_username'].'\')" href="javascript:;" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
							}
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>
<?php } else if($admin_type == 2){?>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_username')?></p></td>
			<td width="165"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_email')?></p></td>
			<td width="120"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_phone')?></p></td>
			<td width="250"><p>&nbsp;&nbsp;&nbsp;权限</p></td>
			<td width="165" align="center"><p><?php echo lang('cy_time_lastedited')?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '作者';}else{echo 'Author';}?></p></td>
			<td width="200" align="center"><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($adminlist)){for ($i = 0; $i < count($adminlist); $i++) {?>
			<tr>
				<td align="center"><?php echo $i+1?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_username']));?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_email']));?></td>
				<td><?php echo actionsearchdaxiaoxiezimu($keyword, strip_tags($adminlist[$i]['admin_phone']));?></td>
				<td>
				<?php 
						$admin_roles = $adminlist[$i]['admin_roles'];
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
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_article_category_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 102;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_article_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 103;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_cms_aboutus').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 104;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_cms_contactus').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 201;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_user_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 202;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_company_business_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 203;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_user_contentproviders_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 301;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_product_category_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 302;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_product_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 303;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_product_recommended_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 401;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_order_all').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 402;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_order_pending').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 403;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_order_delivery').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 404;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_order_print').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 405;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('dz_order_finish').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
					</div>
					<div style="float: left;width:100%;">
						<?php 
						$ischecked = '';
						$thisval = 901;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_feedback_manage').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
						<?php 
						$ischecked = '';
						$thisval = 902;
						if(!empty($admin_roles_arr)){
							for ($aa = 0; $aa < count($admin_roles_arr); $aa++) {
								if($admin_roles_arr[$aa] == $thisval){
									echo lang('cy_setting').'&nbsp;&nbsp;&nbsp;';
								}
							}
						}
						?>
					</div>
				</td>
				<td align="center"><?php echo date('Y-m-d H:i:s', $adminlist[$i]['edited'])?></td>
				<td align="center"><?php echo $adminlist[$i]['edited_author']?></td>
				<td align="center">
					<div style="float:right;">
						<?php 
							echo '<a href="'.base_url().'index.php/admins/user/toedit_adminassistant/'.$admin_type.'/'.$adminlist[$i]['admin_id'].'?backurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
							if($adminlist[$i]['admin_type'] == 2){
								echo '<a onclick="todel_adminassistant('.$adminlist[$i]['admin_id'].', \''.$adminlist[$i]['admin_username'].'\')" href="javascript:;" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
							}
						?>
					</div>
				</td>
			</tr>
		<?php }}?>
	</tbody>
</table>
<?php }?>
<?php $this->load->view('admin/footer')?>