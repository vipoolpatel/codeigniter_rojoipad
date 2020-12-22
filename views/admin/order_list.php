<?php
$user_id = $this->session->userdata('user_id');
if($user_id > 0){
    $this->load->view('admin/subheader');
}else{
    $this->load->view('admin/header');

}

        ?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME()?>'></script>

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
//echo $this->input->get('user_brandname');exit;
$product_type = $this->input->get('product_type');
$keyword = $this->input->get('keyword');
?>
<table class="gksel_normal_tabaction">
	<tr>
		<td>

		</td>
		<td>
			<div class="searcharea" <?= ($user_id > 0) ?'':'style="width:65%"';?>>
				<form action = "<?php echo base_url().'index.php/admins/order/index'?>" method="get" id="newform">
					<?php
					if($user_id > 0){

					}else{
					?>
                        <select name="user_brandname" class="select_usertype" onchange="$('#newform').submit();" style="width:300px !important;">
                            <option value=""><?php echo lang('cy_all')?></option>
						<?php
						$sql = $this->db->query("select distinct user_brandname from rojoipad_user_list where user_brandname != '' and user_brandname !='0' ");

						foreach($sql->result_array() as $data){
							$selected = '';
							if($data['user_brandname'] == $this->input->get('user_brandname') && !empty($this->input->get('user_brandname'))){
								$selected = 'selected="selected"';
							}
							echo '<option value="'.$data['user_brandname'].'"'.$selected.'>'.$data['user_brandname'].'</option>';
						}
						?>
					</select>
					<?php
					}
					?>

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
				<a href="<?php echo base_url().'index.php/admins/order/toadd_order?backurl='.$current_url_encode?>"><font class="nav_on"><img class="plus" src="<?php echo base_url().'themes/default/images/plus.png'?>"/> Add Order</font></a>
			</div>
		</td>
	</tr>
</table>
<table class="gksel_normal_tablist" style="width:2300px;">
	<thead>
		<tr>
			<!--
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			-->
			<!--
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_user_username')?></p></td>
			 -->
			<td><p style="border-left:0px;">&nbsp;&nbsp;&nbsp;Customer</p></td>
			<td width="320" align="center"><p>Factory Phase 1</p></td>
			<td width="340" align="center"><p>Alteration Center Phase 2</p></td>
			<td width="300" align="center"><p>Store Fitting Phase 3</p></td>
			<td width="300" align="center"><p>Alteration Center Phase 4</p></td>
			<td width="240" align="center"><p>Store Phase 5</p></td>
			<td width="280" align="center"><p>Delivered Phase 6</p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '订单时间';}else{echo 'Order Time';}?></p></td>
			<td width="100" align="center"><p><?php if($this->langtype == '_ch'){echo '状态';}else{echo 'Status';}?></p></td>
		</tr>
	</thead>
	<tbody>
	<?php
	if(isset($orderlist)){
		for ($i = 0; $i < count($orderlist); $i++) {
			if($orderlist[$i]['client_id'] > 0){
				$clientinfo = $this->UserModel->getuserinfo($orderlist[$i]['client_id']); ?>
                <tr>
                    <td width="15%">
                        <div style="float:left;width:100%;">
                            <div style="float:left;">
                                <?php echo $orderlist[$i]['newclient_number']?>
						</div>
                            <div style="float:left;margin-left:8px;margin-top:-5px;">                            <?php if ($clientinfo['add_type'] == 1) {
                                    echo '<div style="float:left;border:2px solid orange;padding:3px 6px;border-radius:10px;">Ipad</div>';
                                } else {
                                    echo '<div style="float:left;border:2px solid #CCC;padding:3px 6px;border-radius:10px;">Backend</div>';
                                } ?>
                            </div>
                        </div>
                        <div style="float:left;width:100%;margin-top:10px;">
                            <?php echo $orderlist[$i]['client_realname'] ?>                    </div> <?php if ($orderlist[$i]['factory_name' . $this->langtype] != '') { ?>
                            <div style="float:left;width: 100%;margin-top:10px;">
                                Factory: <?php echo $orderlist[$i]['factory_name' . $this->langtype] ?>                        </div>                    <?php } ?>                                        <?php $sql = "SELECT * FROM ipadqrcode_product_form_qfcheck WHERE status = 1 AND product_id = " . $orderlist[$i]['qrcode_product_id'];
                        $qfcheckinfo = $this->db->query($sql)->row_array(); ?>                    <?php if (!empty($qfcheckinfo)) { ?>
                            <div style="float:left;width: 100%;margin-top:10px;"><a
                                        href="<?php echo str_replace('rojoipad/', 'rojoipadqrcode/', base_url()) . 'index.php/admins/product/toview_qfcheckform/' . $orderlist[$i]['qrcode_product_id'] ?>">Quality
                                    Check Form</a>
                            </div>                    <?php } ?>                                                            <?php $sql = "SELECT * FROM ipadqrcode_product_form_meacheck WHERE status = 1 AND product_id = " . $orderlist[$i]['qrcode_product_id'];
                        $meacheckinfo = $this->db->query($sql)->row_array();
                        //  print_r($meacheckinfo); ## Abhishek
                        ?>                    <?php /* if(!empty($meacheckinfo)){ */ ?>
                        <div style="float:left;width: 100%;margin-top:10px;"><a
                                    href="<?php echo str_replace('rojoipad/', 'rojoipadqrcode/', base_url()) . 'index.php/admins/product/toview_meacheckform/' . $orderlist[$i]['qrcode_product_id'] ?>">Measurement
                                Check Form</a></div> <?php /* } */
                        ?>
                        <div style="float:left;width:100%;margin-top:5px;">
                            <div style="float:left;">                            <?php if ($orderlist[$i]['status'] == 4) {
                                    if ($this->langtype == '_ch') {
                                        $cy_edit_text = '已完成';
                                    } else {
                                        $cy_edit_text = 'Completed';
                                    }
                                    echo '<a onclick="tocompleted_order(' . $orderlist[$i]['order_id'] . ')" href="javascript:;" class="gksel_btn_action_on">' . $cy_edit_text . '</a>';
                                } ?>                            <?php if ($orderlist[$i]['status'] == 4 || $orderlist[$i]['status'] == 5) {
                                    if ($this->langtype == '_ch') {
                                        $cy_edit_text = '修改';
                                    } else {
                                        $cy_edit_text = 'Edit';
                                    }
                                    echo '<a href="' . base_url() . 'index.php/admins/order/toedit_order/' . $orderlist[$i]['order_id'] . '?backurl=' . $current_url_encode . '" class="gksel_btn_action_on">' . $cy_edit_text . '</a>';
                                } ?>                            <?php if ($this->langtype == '_ch') {
                                    $cy_view_text = '查看订单';
                                } else {
                                    $cy_view_text = 'View Order';
                                }
                                echo '<a href="' . base_url() . 'index.php/admins/order/toview_order/' . $orderlist[$i]['order_id'] . '?backurl=' . $current_url_encode . '" class="gksel_btn_action_on">' . $cy_view_text . '</a>'; ?>                                                        <?php echo '<a title="删除订单及其相关的数据" style="display:none;" href="' . base_url() . 'index.php/admins/order/del_order/' . $orderlist[$i]['order_id'] . '?backurl=' . $current_url_encode . '">Delete</a>';
                                echo '<a title="重新生成客户编号" style="display:none;" href="' . base_url() . 'index.php/admins/user/toreaction_clientno_fromorder/' . $orderlist[$i]['order_id'] . '?backurl=' . $current_url_encode . '">Delete</a>'; ?>
                                <a style="background: #e69603;" href="<?php echo base_url('index.php/admins/order/print_order') . '/' . $orderlist[$i]['order_id']; ?>"
                                   class="gksel_btn_action_on">Print</a></div>
                        </div>


                    </td>
                    <td>                    <?php if ($orderlist[$i]['step1_approve_status'] != '') { ?>
                            <div style="float:left;width: 100%;">                            <?php echo 'Date of cloth due: ' . $orderlist[$i]['step1_date_cloth_due'] . '<br />';
                                echo 'Date of cloth submitted: ' . $orderlist[$i]['step1_date_cloth_submitted']; ?>                        </div>
                            <div style="display:none;float: left;width:100%;margin-top:5px;"> keyword tag</div>
                            <div style="float: left;width:100%;margin-top:10px;">
                                <div style="<?php if ($orderlist[$i]['step1_status_num'] >= 1) {
                                    echo 'background:#EFEFEF;';
                                } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 1.1 Start Production</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 1) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step1_approve_time_1']) ?><?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 1) { ?>                                        Done                                    <?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                </div>
                                <div style="<?php if ($orderlist[$i]['step1_status_num'] >= 2) {
                                    echo 'background:#EFEFEF;';
                                } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 1.2 Pickup Suit</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 2) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step1_approve_time_2']) ?><?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 2) { ?>                                        Done                                    <?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                </div>
                                <div style="<?php if ($orderlist[$i]['step1_status_num'] >= 3) {
                                    echo 'background:#EFEFEF;';
                                } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 1.3 Suit Done</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 3) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step1_approve_time_3']) ?><?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 3) { ?>                                        Done                                    <?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                </div>
                                <div style="<?php if ($orderlist[$i]['step1_status_num'] >= 4) {
                                    echo 'background:#EFEFEF;';
                                } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 1.4 Quality Check</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 4) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step1_approve_time_4']) ?><?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 4) { ?>                                        Done                                    <?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                </div>
                                <div style="<?php if ($orderlist[$i]['step1_status_num'] >= 5) {
                                    echo 'background:#EFEFEF;';
                                } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 1.5 Suit Taken</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 5) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step1_approve_time_5']) ?><?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                    <?php if ($orderlist[$i]['step1_status_num'] >= 5) { ?>                                        Done                                    <?php } else { ?>                                        &nbsp;                                    <?php } ?>                                </div>
                                </div>
                            </div>                    <?php } ?>                </td>
                    <td>                    <?php if ($orderlist[$i]['step2_approve_status'] != '') { ?>
                            <div style="display:none;float: left;width:100%;margin-top:5px;"> Notes</div>
                            <div style="display:none;float: left;width:100%;margin-top:10px;">                            <?php echo $orderlist[$i]['step2_notes'] ?>                        </div>
                            <div style="float: left;width:100%;margin-top:10px;">
                                <div style="background:#EFEFEF;float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;">
                                        <!-- 									going into production -->                                    2.1 Measurement
                                        Check
                                    </div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                        <?php echo date('Y-m-d H:i', $orderlist[$i]['step2_approve_time']) ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;"> Done</div>
                                </div>
                            </div>                    <?php } ?>                </td>
                    <td>                    <?php if ($orderlist[$i]['step3_approve_status'] != '') { ?><?php //判断是第几次							$sql = "SELECT count(*) AS numcount FROM ipadqrcode_product_step3 WHERE product_id = ".$orderlist[$i]['qrcode_product_id'].' AND isdel = 1';							$count_res = $this->db->query($sql)->row_array();							if(!empty($count_res)){								$count = $count_res['numcount'];							}else{								$count = 0;							}							if($count > 0){								echo '<div style="float:left;width:100%;margin-bottom:10px;">('.($count + 1).' times)</div>';							}						?>
                            <div style="float: left;width:100%;margin-top:10px;">
                                <div style="background:#EFEFEF;float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;">
                                        <!-- 									going into production -->                                    3.1 Store Fitting
                                    </div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                        <?php echo date('Y-m-d H:i', $orderlist[$i]['step3_approve_time']) ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;"> Done</div>
                                </div>
                            </div>
                            <div style="display:none;float:left;width: 100%;margin-top:5px;"> entering alteration center</div>
                            <div style="display:none;float: left;width:100%;margin-top:10px;"> New Due
                                Date: <?php echo $orderlist[$i]['step3_date_new_due'] ?>                        </div>
                            <div style="display:none;float: left;width:100%;margin-top:10px;"> Action
                                Time: <?php echo date('Y-m-d H:i', $orderlist[$i]['step3_approve_time']) ?>                        </div>                    <?php } ?>
                    </td>
                    <td>                    <?php if ($orderlist[$i]['step4_approve_status'] != '') { ?><?php //判断是第几次							$sql = "SELECT count(*) AS numcount FROM ipadqrcode_product_step4 WHERE product_id = ".$orderlist[$i]['qrcode_product_id'].' AND isdel = 1';							$count_res = $this->db->query($sql)->row_array();							if(!empty($count_res)){								$count = $count_res['numcount'];							}else{								$count = 0;							}							if($count > 0){								echo '<div style="float:left;width:100%;margin-bottom:10px;">('.($count + 1).' times)</div>';							}						?>
                            <div style="float:left;width:100%;"> Date of cloth submitted: <?php echo $orderlist[$i]['step4_date_start'] ?><br/> Date of cloth
                                due: <?php echo $orderlist[$i]['step4_date_end'] ?>                        </div>
                            <div style="<?php if ($orderlist[$i]['step4_status_num'] >= 1) {
                                echo 'background:#EFEFEF;';
                            } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 4.1 Alterations</div>
                                <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 1) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step4_approve_time_1']) ?><?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                                <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 1) { ?>                                    Done                                <?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                            </div>
                            <div style="<?php if ($orderlist[$i]['step4_status_num'] >= 2) {
                                echo 'background:#EFEFEF;';
                            } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 4.2 Tailor views form
                                    measurement
                                </div>
                                <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 2) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step4_approve_time_2']) ?><?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                                <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 2) { ?>                                    Done                                <?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                            </div>
                            <div style="<?php if ($orderlist[$i]['step4_status_num'] >= 3) {
                                echo 'background:#EFEFEF;';
                            } ?>float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;margin-top:6px;">
                                <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 4.3 Quality Check</div>
                                <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 3) { ?><?php echo date('Y-m-d H:i', $orderlist[$i]['step4_approve_time_3']) ?><?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                                <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;">                                <?php if ($orderlist[$i]['step4_status_num'] >= 3) { ?>                                    Done                                <?php } else { ?>                                    &nbsp;                                <?php } ?>                            </div>
                            </div>                    <?php } ?>                </td>
                    <td>                    <?php if ($orderlist[$i]['step5_approve_status'] != '') { ?><?php //判断是第几次							$sql = "SELECT count(*) AS numcount FROM ipadqrcode_product_step5 WHERE product_id = ".$orderlist[$i]['qrcode_product_id'].' AND isdel = 1';							$count_res = $this->db->query($sql)->row_array();							if(!empty($count_res)){								$count = $count_res['numcount'];							}else{								$count = 0;							}							if($count > 0){								echo '<div style="float:left;width:100%;margin-bottom:10px;">('.($count + 1).' times)</div>';							}						?>
                            <div style="float: left;width:100%;margin-top:10px;">
                                <div style="background:#EFEFEF;float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 5.1 Delivery</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                        <?php echo date('Y-m-d H:i', $orderlist[$i]['step5_approve_time']) ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;"> Done</div>
                                </div>
                            </div>                    <?php } ?>                </td>
                    <td>                    <?php if ($orderlist[$i]['step5_approve_status'] != '') { ?>
                            <div style="float: left;width:100%;margin-top:10px;">
                                <div style="background:#EFEFEF;float:left;width:calc(100% - 2px);border:1px solid gray;height:40px;">
                                    <div style="float:left;width:calc(100% - 160px);text-indent:10px;height:40px;line-height:40px;"> 6.1 Delivered</div>
                                    <div style="float:left;width:120px;margin:10px 0px;height:20px;line-height:20px;">                                    <?php echo date('Y-m-d H:i', $orderlist[$i]['step5_approve_time']) ?>                                </div>
                                    <div style="float:left;width:40px;margin:10px 0px;height:20px;line-height:20px;color:green;"> Done</div>
                                </div>
                            </div>                    <?php } ?>                </td>
                    <td align="center"><?php echo date('Y-m-d H:i:s', $orderlist[$i]['created']) ?></td>
                    <td align="center">                    <?php if ($orderlist[$i]['status'] == 4) {
                            if ($this->langtype == '_ch') {
                                echo '处理中';
                            } else {
                                echo 'Processing';
                            }
                        } else if ($orderlist[$i]['status'] == 5) {
                            if ($this->langtype == '_ch') {
                                echo '已完成';
                            } else {
                                echo 'Completed';
                            }
                        } ?>                </td>
                </tr>        <?php }			}
			}?>
	</tbody>
	<thead>
		<tr>
			<td colspan="10"><?php if(isset($fy)){echo $fy;}?></td>
		</tr>
	</thead>
</table>
<script type="text/javascript">
//删除商品
function tocompleted_order(id, name){
	<?php if($this->langtype == '_ch'){?>
		var title = '您确定要此订单加入到已完成订单吗？';
	<?php }else{?>
		var title = 'Are you sure to complete this order?';
	<?php }?>
	var subtitle = '';
	del_url = encodeURI(baseurl+"index.php/admins/order/tocompleted_order/"+id);
	todel(title, subtitle);
}
</script>
<?php $this->load->view('admin/footer')?>