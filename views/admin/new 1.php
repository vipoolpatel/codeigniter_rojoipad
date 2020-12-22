<?php $this->load->view('admin/header');?>

<table width="100%" cellspacing=0 cellpadding=0>

			<tr>

				<td valign="top" width="50%">

					<table width="100%" cellspacing=0 cellpadding=0>

							<tr>

								<td colspan="2">

									<?php 

										$userinfo = $this->UserModel->getuserinfo($orderinfo['uid']);

									?>

									<div class="refund_loglist_l" style="float: left;width:calc(100% - 2px - 20px - 10px);margin-left: 0px;margin-top: 10px;border: 1px solid #ddd;padding: 10px;text-align: left;">

										<table width="100%" cellpadding="0" cellspacing="0" border=0>

											<tr>

												<th colspan="2" align="center"><?php if($this->langtype == '_ch'){echo '订单信息';}else{echo 'Order Information';}?></th>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户编号';}else{echo 'Client#';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><?php echo $orderinfo['newclient_number']?></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户姓名';}else{echo 'Client Name';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_realname" type="text" value="<?php echo $orderinfo['client_realname']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户地址';}else{echo 'Client Address';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_address" type="text" value="<?php echo $orderinfo['client_address']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户邮箱';}else{echo 'Client Email';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_email" type="text" value="<?php echo $orderinfo['client_email']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户行业';}else{echo 'Client Industry';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_industry" type="text" value="<?php echo $orderinfo['client_industry']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户微信';}else{echo 'Client Wechat';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_wechat" type="text" value="<?php echo $orderinfo['client_wechat']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户手机号码';}else{echo 'Client Mobile';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_phone" type="text" value="<?php echo $orderinfo['client_phone']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户生日';}else{echo 'Client Birthday';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_birthday" type="text" value="<?php echo $orderinfo['client_birthday']?>"/></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" width="150" align="right"><?php if($this->langtype == '_ch'){echo '客户国际';}else{echo 'Client Nationality';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;"><input name="client_nationality" type="text" value="<?php echo $orderinfo['client_nationality']?>"/></td>

											</tr>

											<tr>

												<td align="right"><?php if($this->langtype == '_ch'){echo '订单时间';}else{echo 'Order Time';}?>&nbsp;&nbsp;&nbsp;</td>

												<td><?php echo date('Y-m-d H:i:s',$orderinfo['created'])?></td>

											</tr>

											<tr>

												<td style="padding-top:5px;" align="right"><?php if($this->langtype == '_ch'){echo '状态';}else{echo 'Status';}?>&nbsp;&nbsp;&nbsp;</td>

												<td style="padding-top:5px;">

													<select name="status">

														<option value="4" <?php if($orderinfo['status'] == 4){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '进行中';}else{echo 'Processing';}?></option>

														<option value="5" <?php if($orderinfo['status'] == 5){echo 'selected';}?>><?php if($this->langtype == '_ch'){echo '已完成';}else{echo 'Completed';}?></option>

													</select>

												</td>

											</tr>

										</table>

									</div>

								</td>

							</tr>

							<tr><td colspan="2">&nbsp;</td></tr>

						</table>

						<table width="100%" cellspacing=0 cellpadding=0>

							

							<?php 

							$sql = "SELECT * FROM ".DB_PRE()."category_list WHERE parent = 3 ORDER BY sort ASC";

							$categorylist = $this->db->query($sql)->result_array();

							if(!empty($categorylist)){for ($c = 0; $c < count($categorylist); $c++) {



								

								

								

								if(isset($orderinfo['design_list_'.$categorylist[$c]['category_id']]) && !empty($orderinfo['design_list_'.$categorylist[$c]['category_id']])){

								echo '<tr><td>

									<div style="float:left;margin-left:3%;line-height:30px;font-weight:bold;font-size:18px;">'.$categorylist[$c]['category_name'.$this->langtype].'</div>

							</td></tr>';

							

							

							$design_list = $orderinfo['design_list_'.$categorylist[$c]['category_id']];

							

							

							

							$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = 0 AND category_id = ".$categorylist[$c]['category_id']." ORDER BY sort ASC";

							$data_designlist = $this->db->query($sql)->result_array();

							

							//正常返回数据(json)

							$newre = array();

							if(!empty($data_designlist)){

								for ($i = 0; $i < count($data_designlist); $i++) {

									$thisarr = array();

									$thisarr['design_id'] = $data_designlist[$i]['design_id'];

									$thisarr['design_name_en'] = $data_designlist[$i]['design_name_en'];

									$thisarr['design_name_ch'] = $data_designlist[$i]['design_name_ch'];

									if($data_designlist[$i]['ishave_input'] == 1){

										$thisarr['ishave_input'] = 1;

							

										if($data_designlist[$i]['input_title_en'] != ''){

											$thisarr['input_title_en'] = $data_designlist[$i]['input_title_en'];

										}

										if($data_designlist[$i]['input_title_ch'] != ''){

											$thisarr['input_title_ch'] = $data_designlist[$i]['input_title_ch'];

										}

									}

									if($data_designlist[$i]['ishave_input2'] == 1){

										$thisarr['ishave_input2'] = 1;

							

										if($data_designlist[$i]['input2_title_en'] != ''){

											$thisarr['input2_title_en'] = $data_designlist[$i]['input2_title_en'];

										}

										if($data_designlist[$i]['input2_title_ch'] != ''){

											$thisarr['input2_title_ch'] = $data_designlist[$i]['input2_title_ch'];

										}

									}

							

							

									$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = ".$data_designlist[$i]['design_id']." ORDER BY sort ASC";

									$sublist_get = $this->db->query($sql)->result_array();

									$sublist = array();

									if(!empty($sublist_get)){

										for ($j = 0; $j < count($sublist_get); $j++) {

											$sublist[$j]['design_id'] = $sublist_get[$j]['design_id'];

											$sublist[$j]['design_name_en'] = $sublist_get[$j]['design_name_en'];

											$sublist[$j]['design_name_ch'] = $sublist_get[$j]['design_name_ch'];

											if($sublist_get[$j]['ishave_radio'] == 1){

												$sublist[$j]['ishave_radio'] = 1;

											}else{

												$sublist[$j]['ishave_radio'] = 0;

											}

											if($sublist_get[$j]['ishave_checkbox'] == 1){

												$sublist[$j]['ishave_checkbox'] = 1;

											}else{

												$sublist[$j]['ishave_checkbox'] = 0;

											}

											if($sublist_get[$j]['ishave_input'] == 1){

												$sublist[$j]['ishave_input'] = 1;

												$sublist[$j]['input_title_en'] = $sublist_get[$j]['input_title_en'];

												$sublist[$j]['input_title_ch'] = $sublist_get[$j]['input_title_ch'];

											}else{

												$sublist[$j]['ishave_input'] = 0;

												$sublist[$j]['input_title_en'] = '';

												$sublist[$j]['input_title_ch'] = '';

											}

											if($sublist_get[$j]['ishave_input2'] == 1){

												$sublist[$j]['ishave_input2'] = 1;

												$sublist[$j]['input2_title_en'] = $sublist_get[$j]['input2_title_en'];

												$sublist[$j]['input2_title_ch'] = $sublist_get[$j]['input2_title_ch'];

											}else{

												$sublist[$j]['ishave_input2'] = 0;

												$sublist[$j]['input2_title_en'] = '';

												$sublist[$j]['input2_title_ch'] = '';

											}

											if($sublist_get[$j]['ishave_picture'] == 1){

												$sublist[$j]['design_pic'] = $sublist_get[$j]['design_pic'];

											}else{

												$sublist[$j]['design_pic'] = '';

											}

							

							

							

											$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = ".$sublist_get[$j]['design_id']." ORDER BY sort ASC";

											$thirdlist_get = $this->db->query($sql)->result_array();

											$thirdlist = array();

											if(!empty($thirdlist_get)){

												for ($k = 0; $k < count($thirdlist_get); $k++) {

													$thirdlist[$k]['design_id'] = $thirdlist_get[$k]['design_id'];

													$thirdlist[$k]['design_name_en'] = $thirdlist_get[$k]['design_name_en'];

													$thirdlist[$k]['design_name_ch'] = $thirdlist_get[$k]['design_name_ch'];

													if($thirdlist_get[$k]['ishave_radio'] == 1){

														$thirdlist[$k]['ishave_radio'] = 1;

													}else{

														$thirdlist[$k]['ishave_radio'] = 0;

													}

													if($thirdlist_get[$k]['ishave_checkbox'] == 1){

														$thirdlist[$k]['ishave_checkbox'] = 1;

													}else{

														$thirdlist[$k]['ishave_checkbox'] = 0;

													}

													if($thirdlist_get[$k]['ishave_input'] == 1){

														$thirdlist[$k]['ishave_input'] = 1;

														$thirdlist[$k]['input_title_en'] = $thirdlist_get[$k]['input_title_en'];

														$thirdlist[$k]['input_title_ch'] = $thirdlist_get[$k]['input_title_ch'];

													}else{

														$thirdlist[$k]['ishave_input'] = 0;

														$thirdlist[$k]['input_title_en'] = '';

														$thirdlist[$k]['input_title_ch'] = '';

													}

													if($thirdlist_get[$k]['ishave_input2'] == 1){

														$thirdlist[$k]['ishave_input2'] = 1;

														$thirdlist[$k]['input2_title_en'] = $thirdlist_get[$k]['input2_title_en'];

														$thirdlist[$k]['input2_title_ch'] = $thirdlist_get[$k]['input2_title_ch'];

													}else{

														$thirdlist[$k]['ishave_input2'] = 0;

														$thirdlist[$k]['input2_title_en'] = '';

														$thirdlist[$k]['input2_title_ch'] = '';

													}

													if($thirdlist_get[$k]['ishave_picture'] == 1){

														$thirdlist[$k]['design_pic'] = $thirdlist_get[$k]['design_pic'];

													}else{

														$thirdlist[$k]['design_pic'] = '';

													}

												}

												$sublist[$j]['thirdlist'] = $thirdlist;

											}

										}

										$thisarr['sublist'] = $sublist;

									}

									$newre[] = $thisarr;

								}

							}

							$data_designlist = $newre;

?>

							<tr>

								<td>

									<div class="refund_loglist_l" style="float: left;width:calc(100% - 2px - 20px - 10px);margin-left: 0px;margin-top: 10px;border: 1px solid #ddd;padding: 10px;text-align: left;">

										<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">

											<?php for ($i = 0; $i < count($data_designlist); $i++) {

													$sql = "SELECT * FROM ".DB_PRE()."order_detail WHERE order_id = ".$orderinfo['order_id']." AND design_id = ".$data_designlist[$i]['design_id'];

													$parent_design_data = $this->db->query($sql)->row_array();

												?>

												<tr>

													<td valign="top" <?php if($this->langtype == '_ch'){echo 'width="125"';}else{echo 'width="150"';}?> style="padding-left:10px;padding-top:10px;"><?php echo $data_designlist[$i]['design_name'.$this->langtype]?></td>

												</tr>

												<tr>

													<td valign="top" style="padding-left:10px;">

														<?php 

															if(isset($data_designlist[$i]['sublist'])){

																$sublist = $data_designlist[$i]['sublist'];

															}else{

																$sublist = NULL;

															}

														

														

															if(isset($sublist)){

																if(!empty($sublist)){

																	if(isset($sublist[0]['ishave_radio']) && $sublist[0]['ishave_radio'] == 1){

																		echo '

																			<input name="alldesign_id[]" type="hidden" value="'.$data_designlist[$i]['design_id'].'"/>

																			<input name="alltarget_type[]" type="hidden" value="radio"/>

																			<input name="allcategory_id[]" type="hidden" value="'.$categorylist[$c]['category_id'].'"/>

																		';

																	}

																	

																	

																	for ($mmm = 0; $mmm < count($sublist); $mmm++) {

																		if(isset($sublist[$mmm]['ishave_radio']) && $sublist[$mmm]['ishave_radio'] == 1){

																											if($sublist[$mmm]['design_pic'] != ''){

																												$this_radio_pic = '

																													<div style="float:left;width:100%;">

																														<img style="float:left;height:60px;" src="'.base_url().$sublist[$mmm]['design_pic'].'"/>

																													</div>

																												';

																											}else{

																												$this_radio_pic = '';

																											}

																											$ischecked = '';

																											if(!empty($parent_design_data)){

																												if($parent_design_data['radio_value'] == $sublist[$mmm]['design_id']){

																													$ischecked = 'checked';

																												}

																											}

																											echo '

																												<div style="float:left;width:150px;margin:10px 0px;">

																													'.$this_radio_pic.'

																													<div style="float:left;width:100%;margin:10px 0px;">

																														<div style="float:left;width:25px;">

																															<input name="design_id_'.$data_designlist[$i]['design_id'].'" class="mgr mgr-success" type="radio" value="'.$sublist[$mmm]['design_id'].'" '.$ischecked.'/>

																														</div>

																														<div style="float:left;width:calc(100% - 25px);">

																															'.$sublist[$mmm]['design_name'.$this->langtype].'

																														</div>

																													</div>

																												</div>

																											';

																		}else if(isset($sublist[$mmm]['ishave_checkbox']) && $sublist[$mmm]['ishave_checkbox'] == 1){

																			

																								echo '

																									<input name="alldesign_id[]" type="hidden" value="'.$sublist[$mmm]['design_id'].'"/>

																									<input name="alltarget_type[]" type="hidden" value="checkbox"/>

																									<input name="allcategory_id[]" type="hidden" value="'.$categorylist[$c]['category_id'].'"/>										

																								';

																														

																				

																				

																			

																								$sql = "SELECT * FROM ".DB_PRE()."order_detail WHERE order_id = ".$orderinfo['order_id']." AND design_id = ".$sublist[$mmm]['design_id'];

																								$sub_design_data = $this->db->query($sql)->row_array();

																								$ischecked = '';

																								if(!empty($sub_design_data)){

																									$input_value = $sub_design_data['input_value'];

																									$input2_value = $sub_design_data['input2_value'];

																									if($sub_design_data['checkbox_value'] == 1){

																										$ischecked = 'checked';

																									}

																								}else{

																									$input_value = '';

																									$input2_value = '';

																								}

																								

																								if(isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1){

																									$show_input_title =  '

																										<div style="float:left;margin-left:20px;">

																											'.$sublist[$mmm]['input_title'.$this->langtype].'

																										</div>

																										<div style="float:left;margin-left:20px;">

																											<input type="text" name="input_title_'.$sublist[$mmm]['design_id'].'" style="width:50px;" value="'.$input_value.'"/>

																										</div>

																									';

																								}else{

																									$show_input_title = '';

																								}

																								if(isset($sublist[$mmm]['ishave_input2']) && $sublist[$mmm]['ishave_input2'] == 1){

																									$show_input2_title =  '

																										<div style="float:left;margin-left:20px;">

																											'.$sublist[$mmm]['input2_title'.$this->langtype].'

																										</div>

																										<div style="float:left;margin-left:20px;">

																											<input type="text" name="input2_title_'.$sublist[$mmm]['design_id'].'" style="width:50px;" value="'.$input2_value.'"/>

																										</div>

																									';

																								}else{

																									$show_input2_title = '';

																								}

																			

																								if($sublist[$mmm]['design_pic'] != ''){

																									echo '

																										<div style="float:left;width:100%;margin:10px 0px;">

																											<div style="float:left;width:45px;">

																												<img style="float:left;max-width:40px;max-height:40px;" src="'.base_url().$sublist[$mmm]['design_pic'].'"/>

																											</div>

																											<div style="float:left;width:calc(100% - 45px);">

																												<div style="float:left;width:25px;">

																													<input name="design_id_'.$sublist[$mmm]['design_id'].'" class="mgc mgc-success" type="checkbox" value="1" '.$ischecked.'/>

																												</div>

																												<div style="float:left;width:calc(100% - 25px);">

																													<div style="float:left;">'.$sublist[$mmm]['design_name'.$this->langtype].'</div>

																													'.$show_input_title.'

																													'.$show_input2_title.'

																												</div>

																											</div>

																										</div>

																									';

																								}else{

																									echo '

																										<div style="float:left;width:100%;margin:10px 0px;">

																											<div style="float:left;width:25px;">

																												<input name="design_id_'.$sublist[$mmm]['design_id'].'" class="mgc mgc-success" type="checkbox" value="1" '.$ischecked.'/>

																											</div>

																											<div style="float:left;width:calc(100% - 25px);">

																												<div style="float:left;">'.$sublist[$mmm]['design_name'.$this->langtype].'</div>

																												'.$show_input_title.'

																												'.$show_input2_title.'

																											</div>

																										</div>

																									';

																								}

																		}else if(isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1){

																			

																								echo '

																									<input name="alldesign_id[]" type="hidden" value="'.$sublist[$mmm]['design_id'].'"/>

																									<input name="alltarget_type[]" type="hidden" value="checkbox"/>

																									<input name="allcategory_id[]" type="hidden" value="'.$categorylist[$c]['category_id'].'"/>										

																								';

																														

																				

																				

																			

																								$sql = "SELECT * FROM ".DB_PRE()."order_detail WHERE order_id = ".$orderinfo['order_id']." AND design_id = ".$sublist[$mmm]['design_id'];

																								$sub_design_data = $this->db->query($sql)->row_array();

																								if(!empty($sub_design_data)){

																									$input_value = $sub_design_data['input_value'];

																									$input2_value = $sub_design_data['input2_value'];

																								}else{

																									$input_value = '';

																									$input2_value = '';

																								}

																								

																								if(isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1){

																									$show_input_title = '';

																									if(isset($sublist[$mmm]['input_title'.$this->langtype])){

																										$show_input_title .= '

																											<div style="float:left;margin-left:20px;">

																												'.$sublist[$mmm]['input_title'.$this->langtype].'

																											</div>

																										';

																									}

																									

																									$show_input_title .= '

																										<div style="float:left;margin-left:20px;">

																											<input type="text" name="input_title_'.$sublist[$mmm]['design_id'].'" style="width:50px;" value="'.$input_value.'"/>

																										</div>

																									';

																								}else{

																									$show_input_title = '';

																								}

																								if(isset($sublist[$mmm]['ishave_input2']) && $sublist[$mmm]['ishave_input2'] == 1){

																									$show_input2_title = '';

																									if(isset($sublist[$mmm]['input2_title'.$this->langtype])){

																										$show_input2_title .=  '

																											<div style="float:left;margin-left:20px;">

																												'.$sublist[$mmm]['input2_title'.$this->langtype].'

																											</div>

																										';

																									}

																									

																									$show_input2_title .= '

																										<div style="float:left;margin-left:20px;">

																											<input type="text" name="input2_title_'.$sublist[$mmm]['design_id'].'" style="width:50px;" value="'.$input2_value.'"/>

																										</div>

																									';

																								}else{

																									$show_input2_title = '';

																								}

																			

																								if($sublist[$mmm]['design_pic'] != ''){

																									echo '

																										<div style="float:left;width:100%;margin:10px 0px;">

																											<div style="float:left;width:45px;">

																												<img style="float:left;max-width:40px;max-height:40px;" src="'.base_url().$sublist[$mmm]['design_pic'].'"/>

																											</div>

																											<div style="float:left;width:calc(100% - 45px);">

																												<div style="float:left;width:100%;">

																													<div style="float:left;">'.$sublist[$mmm]['design_name'.$this->langtype].'</div>

																													'.$show_input_title.'

																													'.$show_input2_title.'

																												</div>

																											</div>

																										</div>

																									';

																								}else{

																									echo '

																										<div style="float:left;width:100%;margin:10px 0px;">

																											<div style="float:left;width:100%;">

																												<div style="float:left;">'.$sublist[$mmm]['design_name'.$this->langtype].'</div>

																												'.$show_input_title.'

																												'.$show_input2_title.'

																											</div>

																										</div>

																									';

																								}

																		}else{

																			

																								if(isset($sublist[$mmm]['thirdlist'])){

																									$thirdlist = $sublist[$mmm]['thirdlist'];

																								}else{

																									$thirdlist = array();

																								}

																								echo '

																									<div style="float:left;width:100%;margin:10px 0px;">

																										'.$sublist[$mmm]['design_name'.$this->langtype].'

																									</div>

																								';

																			

																								if(!empty($thirdlist)){

																									for ($nnn = 0; $nnn < count($thirdlist); $nnn++) {

																										

																										

																										echo '

																											<input name="alldesign_id[]" type="hidden" value="'.$thirdlist[$nnn]['design_id'].'"/>

																											<input name="alltarget_type[]" type="hidden" value="checkboxorinput"/>

																											<input name="allcategory_id[]" type="hidden" value="'.$categorylist[$c]['category_id'].'"/>

																										';

																										

																										

																										$sql = "SELECT * FROM ".DB_PRE()."order_detail WHERE order_id = ".$orderinfo['order_id']." AND design_id = ".$thirdlist[$nnn]['design_id'];

																										$third_design_data = $this->db->query($sql)->row_array();

																										$ischecked = '';

																										if(!empty($third_design_data)){

																											$input_value = $third_design_data['input_value'];

																											$input2_value = $third_design_data['input2_value'];

																											if($third_design_data['checkbox_value'] == 1){

																												$ischecked = 'checked';

																											}

																										}else{

																											$input_value = '';

																											$input2_value = '';

																										}

																										

																										

																										if(isset($thirdlist[$nnn]['ishave_input']) && $thirdlist[$nnn]['ishave_input'] == 1){

																											$show_input_title = '';

																											if(isset($thirdlist[$nnn]['input_title'.$this->langtype])){

																												$show_input_title .= '

																													<div style="float:left;margin-left:20px;">

																														'.$thirdlist[$nnn]['input_title'.$this->langtype].'

																													</div>

																												';

																											}

																											$show_input_title .= '

																												<div style="float:left;margin-left:20px;">

																													<input type="text" name="input_title_'.$thirdlist[$nnn]['design_id'].'" style="width:50px;" value="'.$input_value.'"/>

																												</div>

																											';

																										}else{

																											$show_input_title = '';

																										}

																										if(isset($thirdlist[$nnn]['ishave_input2']) && $thirdlist[$nnn]['ishave_input2'] == 1){

																											$show_input2_title = '';

																											if(isset($thirdlist[$nnn]['input2_title'.$this->langtype])){

																												$show_input2_title .=  '

																													<div style="float:left;margin-left:20px;">

																														'.$thirdlist[$nnn]['input2_title'.$this->langtype].'

																													</div>

																												';

																											}

																											$show_input2_title .= '

																												<div style="float:left;margin-left:20px;">

																													<input type="text" name="input2_title_'.$thirdlist[$nnn]['design_id'].'" style="width:50px;" value="'.$input2_value.'"/>

																												</div>

																											';

																										}else{

																											$show_input2_title = '';

																										}

																										if(isset($thirdlist[$nnn]['ishave_checkbox']) && $thirdlist[$nnn]['ishave_checkbox'] == 1){

																											$show_checkbox_style = '

																												<div style="float:left;width:25px;">

																													<input name="design_id_'.$thirdlist[$nnn]['design_id'].'" class="mgc mgc-success" type="checkbox" value="1" '.$ischecked.'/>

																												</div>

																											';

																										}else{

																											$show_checkbox_style = '';

																										}

																										

																										echo '

																											<div style="float:left;width:calc(100% - 30px);margin:10px 0px 10px 30px;">

																												'.$show_checkbox_style.'

																												<div style="float:left;width:calc(100% - 25px);">

																													<div style="float:left;">'.$thirdlist[$nnn]['design_name'.$this->langtype].'</div>

																													'.$show_input_title.'

																													'.$show_input2_title.'

																												</div>

																											</div>

																										';

																									}

																								}

																								

																								

																								

																								

																			

																								

																		}

																	}

																}

															}

															

															

															if(isset($data_designlist[$i]['ishave_input']) && $data_designlist[$i]['ishave_input'] == 1){

																if(!empty($parent_design_data)){

																	$input_title = $parent_design_data['input_value'];

																}else{

																	$input_title = '';

																}

																$show_input_title =  '

																	<div style="float:left;margin-left:20px;">

																		'.$data_designlist[$i]['input_title'.$this->langtype].'

																	</div>

																	<div style="float:left;margin-left:20px;">

																		<input type="text" name="input_title_'.$data_designlist[$i]['design_id'].'" style="width:50px;" value="'.$input_title.'"/>

																	</div>

																';

															}else{

																$show_input_title = '';

															}

															if(isset($data_designlist[$i]['ishave_input2']) && $data_designlist[$i]['ishave_input2'] == 1){

																if(!empty($parent_design_data)){

																	$input2_title = $parent_design_data['input2_value'];

																}else{

																	$input2_title = '';

																}

																$show_input2_title =  '

																	<div style="float:left;margin-left:20px;">

																		'.$data_designlist[$i]['input2_title'.$this->langtype].'

																	</div>

																	<div style="float:left;margin-left:20px;">

																		<input type="text" name="input2_title_'.$data_designlist[$i]['design_id'].'" style="width:50px;" value="'.$input2_title.'"/>

																	</div>

																';

															}else{

																$show_input2_title = '';

															}

															echo '

																<div style="float:left;width:100%;margin:20px 0px;">

																	'.$show_input_title.'

																	'.$show_input2_title.'

																</div>

															';

														?>

													</td>

												</tr>

												<tr>

													<td>

														<div style="float:left;width:100%;margin:10px 0px;border-top:1px solid #CCC;"></div>

													</td>

												</tr>

											<?php }?>

										</table>

									</div>

								</td>

							</tr>

							<?php }?>	

							

							<?php }}?>	

						</table>

					</td>

					<td valign="top">

						<table width="100%" cellspacing=0 cellpadding=0>

							<?php if($userinfo['add_type'] == 1){?>

								<tr>

									<td>

										<div class="refund_loglist_l" style="float: left;width: calc(100% - 2px - 20px - 10px);margin-left: 0px;margin-top: 10px;border: 1px solid #ddd;padding: 10px;text-align: left;">

											<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">

												<tr>

													<td width="45" style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '姓名';}else{echo 'Name';}?></td>

													<td align="center" style="padding:10px 3px;"><div style="float:left;width:calc(100% - 10px);line-height:25px;margin-left:5px;border-bottom:1px solid black;"><?php if($orderinfo['client_realname'] != '0' && $orderinfo['client_realname'] != ''){echo $orderinfo['client_realname'];}else{echo '&nbsp;';}?></div></td>

													<td width="80" align="center" style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '西服样式';}else{echo 'JA Garment';}?></td>

													<td align="center" style="padding:10px 3px;"><input name="ja_garment" style="width:calc(100% - 6px);" type="text" value="<?php if($orderinfo['ja_garment'] != '0' && $orderinfo['ja_garment'] != ''){echo $orderinfo['ja_garment'];}else{echo '&nbsp;';}?>"/></td>

													<td width="80" style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '马甲样衣';}else{echo 'WC Garment';}?></td>

													<td align="center" style="padding:10px 3px;"><input name="wc_garment" style="width:calc(100% - 6px);" type="text" value="<?php if($orderinfo['wc_garment'] != '0' && $orderinfo['wc_garment'] != ''){echo $orderinfo['wc_garment'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '客户编号';}else{echo 'Client #';}?></td>

													<td align="center" style="padding:10px 3px;"><div style="float:left;width:calc(100% - 10px);line-height:25px;margin-left:5px;border-bottom:1px solid black;"><?php echo $orderinfo['newclient_number']?></div></td>

													<td align="center" style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '衬衣样式';}else{echo 'SH Garment';}?></td>

													<td align="center" style="padding:10px 3px;"><input name="sh_garment" style="width:calc(100% - 6px);" type="text" value="<?php if($orderinfo['sh_garment'] != '0' && $orderinfo['sh_garment'] != ''){echo $orderinfo['sh_garment'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding:10px 3px;"><?php if($this->langtype == '_ch'){echo '裤子样式';}else{echo 'TR Garment';}?></td>

													<td align="center" style="padding:10px 3px;"><input name="tr_garment" style="width:calc(100% - 6px);" type="text" value="<?php if($orderinfo['tr_garment'] != '0' && $orderinfo['tr_garment'] != ''){echo $orderinfo['tr_garment'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

											</table>

											<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">

												<tr>

													<td width="<?php if($this->langtype == '_ch'){echo 60;}else{echo 80;}?>" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '上身';}else{echo 'UPPER BODY';}?></td>

													<td align="center" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '西服';}else{echo 'JA';}?></td>

													<td align="center" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '衬衣';}else{echo 'SH';}?></td>

													<td align="center" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '马夹';}else{echo 'WC';}?></td>

													<td width="<?php if($this->langtype == '_ch'){echo 60;}else{echo 80;}?>" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '下身';}else{echo 'LOWER BODY';}?></td>

													<td align="center" style="padding:10px;background:#EFEFEF;"><?php if($this->langtype == '_ch'){echo '裤子';}else{echo 'TR';}?></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '衣长';}else{echo 'LENGTH';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_length" style="width:100%;" type="text" value="<?php if($orderinfo['ja_length'] != '0' && $orderinfo['ja_length'] != ''){echo $orderinfo['ja_length'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_length" style="width:100%;" type="text" value="<?php if($orderinfo['sh_length'] != '0' && $orderinfo['sh_length'] != ''){echo $orderinfo['sh_length'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_length" style="width:100%;" style="width:100%;" type="text" value="<?php if($orderinfo['wc_length'] != '0' && $orderinfo['wc_length'] != ''){echo $orderinfo['wc_length'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '裤子长';}else{echo 'LENGTH';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_length" style="width:100%;" type="text" value="<?php if($orderinfo['tr_length'] != '0' && $orderinfo['tr_length'] != ''){echo $orderinfo['tr_length'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '肩宽';}else{echo 'SHOULDERS';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_shoulders" style="width:100%;" type="text" value="<?php if($orderinfo['ja_shoulders'] != '0' && $orderinfo['ja_shoulders'] != ''){echo $orderinfo['ja_shoulders'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_shoulders" style="width:100%;" type="text" value="<?php if($orderinfo['sh_shoulders'] != '0' && $orderinfo['sh_shoulders'] != ''){echo $orderinfo['sh_shoulders'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_shoulders" style="width:100%;" type="text" value="<?php if($orderinfo['wc_shoulders'] != '0' && $orderinfo['wc_shoulders'] != ''){echo $orderinfo['wc_shoulders'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '裤子腰围';}else{echo 'WAIST';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_waist" style="width:100%;" type="text" value="<?php if($orderinfo['tr_waist'] != '0' && $orderinfo['tr_waist'] != ''){echo $orderinfo['tr_waist'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '胸围';}else{echo 'CHEST C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_chest" style="width:100%;" type="text" value="<?php if($orderinfo['ja_chest'] != '0' && $orderinfo['ja_chest'] != ''){echo $orderinfo['ja_chest'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_chest" style="width:100%;" type="text" value="<?php if($orderinfo['sh_chest'] != '0' && $orderinfo['sh_chest'] != ''){echo $orderinfo['sh_chest'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_chest" style="width:100%;" type="text" value="<?php if($orderinfo['wc_chest'] != '0' && $orderinfo['wc_chest'] != ''){echo $orderinfo['wc_chest'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '臀围';}else{echo 'GLUTEUS';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_gluteus" style="width:100%;" type="text" value="<?php if($orderinfo['tr_gluteus'] != '0' && $orderinfo['tr_gluteus'] != ''){echo $orderinfo['tr_gluteus'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '前胸';}else{echo 'CHEST FRONT';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_chest_f" style="width:100%;" type="text" value="<?php if($orderinfo['ja_chest_f'] != '0' && $orderinfo['ja_chest_f'] != ''){echo $orderinfo['ja_chest_f'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_chest_f" style="width:100%;" type="text" value="<?php if($orderinfo['sh_chest_f'] != '0' && $orderinfo['sh_chest_f'] != ''){echo $orderinfo['sh_chest_f'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_chest_f" style="width:100%;" type="text" value="<?php if($orderinfo['wc_chest_f'] != '0' && $orderinfo['wc_chest_f'] != ''){echo $orderinfo['wc_chest_f'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '大腿围';}else{echo 'Back W';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_thigh" style="width:100%;" type="text" value="<?php if($orderinfo['tr_thigh'] != '0' && $orderinfo['tr_thigh'] != ''){echo $orderinfo['tr_thigh'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '后背';}else{echo 'CHEST BACK';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_chest_b" style="width:100%;" type="text" value="<?php if($orderinfo['ja_chest_b'] != '0' && $orderinfo['ja_chest_b'] != ''){echo $orderinfo['ja_chest_b'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_chest_b" style="width:100%;" type="text" value="<?php if($orderinfo['sh_chest_b'] != '0' && $orderinfo['sh_chest_b'] != ''){echo $orderinfo['sh_chest_b'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_chest_b" style="width:100%;" type="text" value="<?php if($orderinfo['wc_chest_b'] != '0' && $orderinfo['wc_chest_b'] != ''){echo $orderinfo['wc_chest_b'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '直裆长';}else{echo 'CROTCH RISE';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_crotch_rise" style="width:100%;" type="text" value="<?php if($orderinfo['tr_crotch_rise'] != '0' && $orderinfo['tr_crotch_rise'] != ''){echo $orderinfo['tr_crotch_rise'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '腰围';}else{echo 'BUST C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_bust" style="width:100%;" type="text" value="<?php if($orderinfo['ja_bust'] != '0' && $orderinfo['ja_bust'] != ''){echo $orderinfo['ja_bust'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_bust" style="width:100%;" type="text" value="<?php if($orderinfo['sh_bust'] != '0' && $orderinfo['sh_bust'] != ''){echo $orderinfo['sh_bust'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_bust" style="width:100%;" type="text" value="<?php if($orderinfo['wc_bust'] != '0' && $orderinfo['wc_bust'] != ''){echo $orderinfo['wc_bust'];}else{echo '&nbsp;';}?>"/></td>

													<!-- 

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '前裆';}else{echo 'Front Crotch';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_crotch_front" style="width:100%;" type="text" value="<?php if($orderinfo['tr_crotch_front'] != '0' && $orderinfo['tr_crotch_front'] != ''){echo $orderinfo['tr_crotch_front'];}else{echo '&nbsp;';}?>"/></td>

													-->

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '中裆围';}else{echo 'HAMSTRING';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_hamstring" style="width:100%;" type="text" value="<?php if($orderinfo['tr_hamstring'] != '0' && $orderinfo['tr_hamstring'] != ''){echo $orderinfo['tr_hamstring'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '臀围';}else{echo 'HIP C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_circumference" style="width:100%;" type="text" value="<?php if($orderinfo['ja_circumference'] != '0' && $orderinfo['ja_circumference'] != ''){echo $orderinfo['ja_circumference'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_circumference" style="width:100%;" type="text" value="<?php if($orderinfo['sh_circumference'] != '0' && $orderinfo['sh_circumference'] != ''){echo $orderinfo['sh_circumference'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_circumference" style="width:100%;" type="text" value="<?php if($orderinfo['wc_circumference'] != '0' && $orderinfo['wc_circumference'] != ''){echo $orderinfo['wc_circumference'];}else{echo '&nbsp;';}?>"/></td>

													<!-- 

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '后裆';}else{echo 'Back Crotch';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_crotch_back" style="width:100%;" type="text" value="<?php if($orderinfo['tr_crotch_back'] != '0' && $orderinfo['tr_crotch_back'] != ''){echo $orderinfo['tr_crotch_back'];}else{echo '&nbsp;';}?>"/></td>

													-->

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '小腿围';}else{echo 'CALF';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_calf" style="width:100%;" type="text" value="<?php if($orderinfo['tr_calf'] != '0' && $orderinfo['tr_calf'] != ''){echo $orderinfo['tr_calf'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '袖长';}else{echo 'SLEEVE';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="ja_sleeve" style="width:100%;" type="text" value="<?php if($orderinfo['ja_sleeve'] != '0' && $orderinfo['ja_sleeve'] != ''){echo $orderinfo['ja_sleeve'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="sh_sleeve" style="width:100%;" type="text" value="<?php if($orderinfo['sh_sleeve'] != '0' && $orderinfo['sh_sleeve'] != ''){echo $orderinfo['sh_sleeve'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="wc_sleeve" style="width:100%;" type="text" value="<?php if($orderinfo['wc_sleeve'] != '0' && $orderinfo['wc_sleeve'] != ''){echo $orderinfo['wc_sleeve'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"><?php if($this->langtype == '_ch'){echo '脚口围';}else{echo 'ANKLE';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_ankle" style="width:100%;" type="text" value="<?php if($orderinfo['tr_ankle'] != '0' && $orderinfo['tr_ankle'] != ''){echo $orderinfo['tr_ankle'];}else{echo '&nbsp;';}?>"/></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php if($this->langtype == '_ch'){echo '袖肥';}else{echo 'BICEP C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="ja_bicep" style="width:100%;" type="text" value="<?php if($orderinfo['ja_bicep'] != '0' && $orderinfo['ja_bicep'] != ''){echo $orderinfo['ja_bicep'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="sh_bicep" style="width:100%;" type="text" value="<?php if($orderinfo['sh_bicep'] != '0' && $orderinfo['sh_bicep'] != ''){echo $orderinfo['sh_bicep'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="wc_bicep" style="width:100%;" type="text" value="<?php if($orderinfo['wc_bicep'] != '0' && $orderinfo['wc_bicep'] != ''){echo $orderinfo['wc_bicep'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php if($this->langtype == '_ch'){echo '袖口';}else{echo 'WRIST C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="ja_wrist" style="width:100%;" type="text" value="<?php if($orderinfo['ja_wrist'] != '0' && $orderinfo['ja_wrist'] != ''){echo $orderinfo['ja_wrist'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="sh_wrist" style="width:100%;" type="text" value="<?php if($orderinfo['sh_wrist'] != '0' && $orderinfo['sh_wrist'] != ''){echo $orderinfo['sh_wrist'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="wc_wrist" style="width:100%;" type="text" value="<?php if($orderinfo['wc_wrist'] != '0' && $orderinfo['wc_wrist'] != ''){echo $orderinfo['wc_wrist'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"></td>

												</tr>

												<tr>

													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php if($this->langtype == '_ch'){echo '领围';}else{echo 'NECK C';}?></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="ja_neck" style="width:100%;" type="text" value="<?php if($orderinfo['ja_neck'] != '0' && $orderinfo['ja_neck'] != ''){echo $orderinfo['ja_neck'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="sh_neck" style="width:100%;" type="text" value="<?php if($orderinfo['sh_neck'] != '0' && $orderinfo['sh_neck'] != ''){echo $orderinfo['sh_neck'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><input name="wc_neck" style="width:100%;" type="text" value="<?php if($orderinfo['wc_neck'] != '0' && $orderinfo['wc_neck'] != ''){echo $orderinfo['wc_neck'];}else{echo '&nbsp;';}?>"/></td>

													<td style="padding-left:10px;padding-top:10px;"></td>

													<td align="center" style="padding-left:10px;padding-top:10px;"></td>

												</tr>

											</table>

											<?php 

												$sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 ORDER BY cms_id ASC";

												$cmslist = $this->db->query($sql)->result_array();

											?>

											<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">

												<tr>

													<td width="<?php if($this->langtype == '_ch'){echo 60;}else{echo 115;}?>" style="padding:10px;"><?php if($this->langtype == '_ch'){echo '西装编号';}else{echo 'Suit Code';}?></td>

													<td align="center" style="padding:10px;"><input name="code_suit" style="width:100%;" type="text" value="<?php if($orderinfo['code_suit'] != '0' && $orderinfo['code_suit'] != ''){echo $orderinfo['code_suit'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding:10px;">

														<select name="code_suit_select">

															<?php 

																if(!empty($cmslist)){

																	for ($i = 0; $i < count($cmslist); $i++) {

																		if($cmslist[$i]['cms_name_en'] == $orderinfo['code_suit_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_suit_select']){

																			$isselected = 'selected';

																		}else{

																			$isselected = '';

																		}

																		echo '<option value="'.$cmslist[$i]['cms_name'.$this->langtype].'" '.$isselected.'>'.$cmslist[$i]['cms_name'.$this->langtype].'</option>';

																	}

																}

															?>

														</select>

													</td>

													<td width="<?php if($this->langtype == '_ch'){echo 60;}else{echo 115;}?>" style="padding-top:10px;"><?php if($this->langtype == '_ch'){echo '马夹编号';}else{echo 'Waistcoat Code';}?></td>

													<td align="center" style="padding:10px;"><input name="code_waistcoat" style="width:100%;" type="text" value="<?php if($orderinfo['code_waistcoat'] != '0' && $orderinfo['code_waistcoat'] != ''){echo $orderinfo['code_waistcoat'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding:10px;">

													

													

														<select name="code_waistcoat_select">

															<?php 

																if(!empty($cmslist)){

																	for ($i = 0; $i < count($cmslist); $i++) {

																		if($cmslist[$i]['cms_name_en'] == $orderinfo['code_waistcoat_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_waistcoat_select']){

																			$isselected = 'selected';

																		}else{

																			$isselected = '';

																		}

																		echo '<option value="'.$cmslist[$i]['cms_name'.$this->langtype].'" '.$isselected.'>'.$cmslist[$i]['cms_name'.$this->langtype].'</option>';

																	}

																}

															?>

														</select>

													</td>

												</tr>

												<tr>

													<td style="padding:10px;"><?php if($this->langtype == '_ch'){echo '裤子编号';}else{echo 'Trousers Code';}?></td>

													<td align="center" style="padding:10px;"><input name="code_trousers" style="width:100%;" type="text" value="<?php if($orderinfo['code_trousers'] != '0' && $orderinfo['code_trousers'] != ''){echo $orderinfo['code_trousers'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding:10px;">

														<select name="code_trousers_select">

															<?php 

																if(!empty($cmslist)){

																	for ($i = 0; $i < count($cmslist); $i++) {

																		if($cmslist[$i]['cms_name_en'] == $orderinfo['code_trousers_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_trousers_select']){

																			$isselected = 'selected';

																		}else{

																			$isselected = '';

																		}

																		echo '<option value="'.$cmslist[$i]['cms_name'.$this->langtype].'" '.$isselected.'>'.$cmslist[$i]['cms_name'.$this->langtype].'</option>';

																	}

																}

															?>

														</select>

													</td>

													<td style="padding-top:10px;"><?php if($this->langtype == '_ch'){echo '衬衫编号';}else{echo 'Shirt Code';}?></td>

													<td align="center" style="padding:10px;"><input name="code_shirt" style="width:100%;" type="text" value="<?php if($orderinfo['code_shirt'] != '0' && $orderinfo['code_shirt'] != ''){echo $orderinfo['code_shirt'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding:10px;">

														<select name="code_shirt_select">

															<?php 

																if(!empty($cmslist)){

																	for ($i = 0; $i < count($cmslist); $i++) {

																		if($cmslist[$i]['cms_name_en'] == $orderinfo['code_shirt_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_shirt_select']){

																			$isselected = 'selected';

																		}else{

																			$isselected = '';

																		}

																		echo '<option value="'.$cmslist[$i]['cms_name'.$this->langtype].'" '.$isselected.'>'.$cmslist[$i]['cms_name'.$this->langtype].'</option>';

																	}

																}

															?>

														</select>

													</td>

												</tr>

												<tr>

													<td style="padding:10px;"><?php if($this->langtype == '_ch'){echo '大衣编号';}else{echo 'Overcoat Code';}?></td>

													<td align="center" style="padding:10px;"><input name="code_overcoat" style="width:100%;" type="text" value="<?php if($orderinfo['code_overcoat'] != '0' && $orderinfo['code_overcoat'] != ''){echo $orderinfo['code_overcoat'];}else{echo '&nbsp;';}?>"/></td>

													<td align="center" style="padding:10px;">

														<select name="code_overcoat_select">

															<?php 

																if(!empty($cmslist)){

																	for ($i = 0; $i < count($cmslist); $i++) {

																		if($cmslist[$i]['cms_name_en'] == $orderinfo['code_overcoat_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_overcoat_select']){

																			$isselected = 'selected';

																		}else{

																			$isselected = '';

																		}

																		echo '<option value="'.$cmslist[$i]['cms_name'.$this->langtype].'" '.$isselected.'>'.$cmslist[$i]['cms_name'.$this->langtype].'</option>';

																	}

																}

															?>

														</select>

													</td>

													<td style="padding-top:10px;"></td>

													<td align="center" style="padding:10px;"></td>

													<td align="center" style="padding:10px;"></td>

												</tr>

											</table>

										</div>

									</td>

								</tr>

							<?php }?>

							<tr><td colspan="2">&nbsp;</td></tr>

							<tr>

								<td colspan="2" align="left">

									<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>

									<div class="gksel_btn_action_on" onclick="tosave_orderinfo(<?php echo $orderinfo['order_id']?>)"><?php echo lang('cy_save')?></div>

								</td>

							</tr>

						</table>

					</td>

			</tr>

		</table>

		

<script type="text/javascript">

//商品分类---保存

function tosave_orderinfo(order_id){

	if(isajaxsaveing == 0){

		//具体点击的按钮

		actionsubmit_button = $('div[onclick="tosave_orderinfo('+order_id+')"]');

		//ajax正在保存中

		isajaxsaveing = 1;

		//返回url

		var backurl = $('input[name="backurl"]').val();

		//将提交按钮设置为保存中

		actionsubmit_button.attr('class', 'gksel_btn_action_off');

		actionsubmit_button.html('<img class="icon_loading" src="'+baseurl+'themes/default/images/ajax_loading.gif"/><span>'+L['cy_saving']+'...</span>');



		var client_realname = $('input[name="client_realname"]').val();

		var client_address = $('input[name="client_address"]').val();

		var client_email = $('input[name="client_email"]').val();

		var client_industry = $('input[name="client_industry"]').val();

		var client_wechat = $('input[name="client_wechat"]').val();

		var client_phone = $('input[name="client_phone"]').val();

		var client_birthday = $('input[name="client_birthday"]').val();

		var client_nationality = $('input[name="client_nationality"]').val();

		

		var ja_garment = $('input[name="ja_garment"]').val();

		var wc_garment = $('input[name="wc_garment"]').val();

		var sh_garment = $('input[name="sh_garment"]').val();

		var tr_garment = $('input[name="tr_garment"]').val();



		var ja_length = $('input[name="ja_length"]').val();

		var sh_length = $('input[name="sh_length"]').val();

		var wc_length = $('input[name="wc_length"]').val();

		var tr_length = $('input[name="tr_length"]').val();



		var ja_shoulders = $('input[name="ja_shoulders"]').val();

		var sh_shoulders = $('input[name="sh_shoulders"]').val();

		var wc_shoulders = $('input[name="wc_shoulders"]').val();

		var tr_waist = $('input[name="tr_waist"]').val();



		var ja_chest = $('input[name="ja_chest"]').val();

		var sh_chest = $('input[name="sh_chest"]').val();

		var wc_chest = $('input[name="wc_chest"]').val();

		var tr_gluteus = $('input[name="tr_gluteus"]').val();



		var ja_chest_f = $('input[name="ja_chest_f"]').val();

		var sh_chest_f = $('input[name="sh_chest_f"]').val();

		var wc_chest_f = $('input[name="wc_chest_f"]').val();



		var ja_chest_b = $('input[name="ja_chest_b"]').val();

		var sh_chest_b = $('input[name="sh_chest_b"]').val();

		var wc_chest_b = $('input[name="wc_chest_b"]').val();



		var ja_bust = $('input[name="ja_bust"]').val();

		var sh_bust = $('input[name="sh_bust"]').val();

		var wc_bust = $('input[name="wc_bust"]').val();

		var tr_thigh = $('input[name="tr_thigh"]').val();



		var ja_circumference = $('input[name="ja_circumference"]').val();

		var sh_circumference = $('input[name="sh_circumference"]').val();

		var wc_circumference = $('input[name="wc_circumference"]').val();

		var tr_crotch_rise = $('input[name="tr_crotch_rise"]').val();



		var ja_sleeve = $('input[name="ja_sleeve"]').val();

		var sh_sleeve = $('input[name="sh_sleeve"]').val();

		var wc_sleeve = $('input[name="wc_sleeve"]').val();

		var tr_hamstring = $('input[name="tr_hamstring"]').val();



		var ja_bicep = $('input[name="ja_bicep"]').val();

		var sh_bicep = $('input[name="sh_bicep"]').val();

		var wc_bicep = $('input[name="wc_bicep"]').val();

		var tr_calf = $('input[name="tr_calf"]').val();



		var ja_wrist = $('input[name="ja_wrist"]').val();

		var sh_wrist = $('input[name="sh_wrist"]').val();

		var wc_wrist = $('input[name="wc_wrist"]').val();

		var tr_ankle = $('input[name="tr_ankle"]').val();



		var ja_neck = $('input[name="ja_neck"]').val();

		var sh_neck = $('input[name="sh_neck"]').val();

		var wc_neck = $('input[name="wc_neck"]').val();



		var code_suit = $('input[name="code_suit"]').val();

		var code_waistcoat = $('input[name="code_waistcoat"]').val();

		var code_trousers = $('input[name="code_trousers"]').val();

		var code_shirt = $('input[name="code_shirt"]').val();

		var code_overcoat = $('input[name="code_overcoat"]').val();



		var code_suit_select = $('select[name="code_suit_select"]').val();

		var code_waistcoat_select = $('select[name="code_waistcoat_select"]').val();

		var code_trousers_select = $('select[name="code_trousers_select"]').val();

		var code_shirt_select = $('select[name="code_shirt_select"]').val();

		var code_overcoat_select = $('select[name="code_overcoat_select"]').val();



		var status = $('select[name="status"]').val();





		var alldesign_id_arr = $('input[name="alldesign_id[]"]');

		var alltarget_type_arr = $('input[name="alltarget_type[]"]');

		var allcategory_id_arr = $('input[name="allcategory_id[]"]');

		

		var alldesign_id = [];

		var alltarget_type = [];

		var allcategory_id = [];

		var allradio_value = [];

		var allcheckbox_value = [];

		var allinput_value = [];

		var allinput2_value = [];

		

		if(alldesign_id_arr.length > 0){

			for(var i = 0; i < alldesign_id_arr.length; i++){

				alldesign_id.push(alldesign_id_arr[i].value);

				alltarget_type.push(alltarget_type_arr[i].value);

				allcategory_id.push(allcategory_id_arr[i].value);

			}

		}

		if(alldesign_id.length > 0){

			for(var i = 0; i < alldesign_id.length; i++){

				if(alltarget_type[i] == 'radio'){

					if($('input[name="design_id_'+alldesign_id[i]+'"]:checked').val() == undefined){

						allradio_value.push(0);

					}else{

						allradio_value.push($('input[name="design_id_'+alldesign_id[i]+'"]:checked').val());

					}

					allcheckbox_value.push(0);

				}else if(alltarget_type[i] == 'checkboxorinput'){

					if($('input[name="design_id_'+alldesign_id[i]+'"]:checked').val() == undefined){

						allcheckbox_value.push(0);

					}else{

						allcheckbox_value.push(1);

					}

					allradio_value.push(0);

				}else{

					if($('input[name="design_id_'+alldesign_id[i]+'"]:checked').val() == undefined){

						allcheckbox_value.push(0);

					}else{

						allcheckbox_value.push(1);

					}

					allradio_value.push(0);

				}



				allinput_value.push($('input[name="input_title_'+alldesign_id[i]+'"]').val());

				allinput2_value.push($('input[name="input2_title_'+alldesign_id[i]+'"]').val());

			}

		}

		



		var ispass=1;

		if(ispass == 1){

			$.post(baseurl+'index.php/admins/order/edit_order/'+order_id, {

				//返回url

				backurl: backurl,



				client_realname: client_realname,

				client_address: client_address,

				client_email: client_email,

				client_industry: client_industry,

				client_wechat: client_wechat,

				client_phone: client_phone,

				client_birthday: client_birthday,

				client_nationality: client_nationality,

				

				//商品分类信息

				ja_garment: ja_garment,

				wc_garment: wc_garment,

				sh_garment: sh_garment,

				tr_garment: tr_garment,

	

				ja_length: ja_length,

				sh_length: sh_length,

				wc_length: wc_length,

				tr_length: tr_length,

	

				ja_shoulders: ja_shoulders,

				sh_shoulders: sh_shoulders,

				wc_shoulders: wc_shoulders,

				tr_waist: tr_waist,

	

				ja_chest: ja_chest,

				sh_chest: sh_chest,

				wc_chest: wc_chest,

				tr_gluteus: tr_gluteus,



				ja_chest_f: ja_chest_f,

				sh_chest_f: sh_chest_f,

				wc_chest_f: wc_chest_f,



				ja_chest_b: ja_chest_b,

				sh_chest_b: sh_chest_b,

				wc_chest_b: wc_chest_b,

	

				ja_bust: ja_bust,

				sh_bust: sh_bust,

				wc_bust: wc_bust,

				tr_thigh: tr_thigh,

	

				ja_circumference: ja_circumference,

				sh_circumference: sh_circumference,

				wc_circumference: wc_circumference,

				tr_crotch_rise: tr_crotch_rise,

	

				ja_sleeve: ja_sleeve,

				sh_sleeve: sh_sleeve,

				wc_sleeve: wc_sleeve,

				tr_hamstring: tr_hamstring,

	

				ja_bicep: ja_bicep,

				sh_bicep: sh_bicep,

				wc_bicep: wc_bicep,

				tr_calf: tr_calf,

	

				ja_wrist: ja_wrist,

				sh_wrist: sh_wrist,

				wc_wrist: wc_wrist,

				tr_ankle: tr_ankle,

	

				ja_neck: ja_neck,

				sh_neck: sh_neck,

				wc_neck: wc_neck,

	

				code_suit: code_suit,

				code_waistcoat: code_waistcoat,

				code_trousers: code_trousers,

				code_shirt: code_shirt,

				code_overcoat: code_overcoat,



				code_suit_select: code_suit_select,

				code_waistcoat_select: code_waistcoat_select,

				code_trousers_select: code_trousers_select,

				code_shirt_select: code_shirt_select,

				code_overcoat_select: code_overcoat_select,





				alldesign_id: alldesign_id,

				allcategory_id: allcategory_id,

				allradio_value: allradio_value,

				allcheckbox_value: allcheckbox_value,

				allinput_value: allinput_value,

				allinput2_value: allinput2_value,



				

				status: status

				

			},function (data){

				var obj = eval( "(" + data + ")" );

				actionsubmit_button.html('<img class="icon_success" src="'+baseurl+'themes/default/images/global_ok.png"/><span>'+L['cy_save_success']+'</span>');

				location.href = obj.backurl;

			})

		}else{

			actionsubmit_button.attr('class', 'gksel_btn_action_on');

			actionsubmit_button.html(L['cy_save']);

			isajaxsaveing = 0;//ajax正在保存中 --- 释放

		}

	}

}

</script>





<?php $this->load->view('admin/footer')?>

