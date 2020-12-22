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

$user_type = $this->input->get('user_type');
$keyword = $this->input->get('keyword');
?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME()?>'></script>
		
<table class="gksel_normal_tabaction">
	<tr>
		<td>
			<div class="searcharea">
				<form action = "<?php echo base_url().'index.php/admins/user/wallet'?>" method="get">
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
				<a href="<?php echo base_url().'index.php/admins/user/toadd_user_wallet/'?>"><font class="nav_on"><img class="plus" src="<?php echo base_url().'themes/default/images/plus.png'?>"/> Add Points</font></a>
				<!--  
				<div onclick="javascript:location.href='<?php echo base_url().'index.php/admins/user/index?user_type='.$user_type.'&keyword='.$keyword.'&is_excel=1'?>';" style="float: left;margin-top:7px;cursor:pointer;">
					<div style="float: left;margin-left:5px;">
						<img src="<?php echo base_url().'themes/default/images/icon_xls.gif'?>"/>
					</div>
					<div style="float: left;margin-left:5px;">
						Export Excel
					</div>
				</div>
				-->
			</div>
		</td>
	</tr>
</table>
<table class="gksel_normal_tablist">
    <thead>
        <tr>
            <td width="50" align="center"><?php echo lang('wallet_sr') ?></td>
            <td align="center"><?php echo lang('wallet_login_id') ?></td>
            <td align="center"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('wallet_user') ?></p></td>
            
            <td align="center"><p><?php echo lang('wallet_points') ?></p></td>
            <td width="280" align="center"><p><?php echo lang('cy_actions')?></p></td>
        </tr>
    </thead>
    <tbody>
<?php if (isset($walletdetails)) {
    for ($i = 0; $i < count($walletdetails); $i++) { ?>
                        
                <tr style="background: #EFEFEF;">
                    <td align="center"><?php echo $i + 1 ?></td>
                    <td align="center">	<?php echo $walletdetails[$i]['user_number'];?></td>
                    <td align="center">	<?php echo $walletdetails[$i]['user_realname'];?></td>
                    <td align="center">	<?php echo $walletdetails[$i]['amount'];?></td>
                    <td align="center">	<center><?php echo '<a href="'.base_url().'index.php/admins/user/view_wallet/'.$walletdetails[$i]['uid'].'" class="gksel_btn_action_on">'.lang('cy_preview').'</a>';?></center></td>
					
                </tr>
                        
    <?php }
} ?>
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