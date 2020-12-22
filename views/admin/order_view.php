<?php
$user_id = $this->session->userdata('user_id');
if($user_id > 0){
    $this->load->view('admin/subheader');
}else{
    $this->load->view('admin/header');
}

        ?>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 99%;
        margin-top:60px;

    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    
    #customers1 {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        float:left;
    }

    #customers1 td, #customers1 th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers1 tr:nth-child(even){background-color: #f2f2f2;}

    

    #customers1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
<table id="customers">
    <thead>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户编号';
        } else {
            echo 'Client #';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户姓名';
        } else {
            echo 'Client Name';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户地址';
        } else {
            echo 'Client Address';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户邮箱';
        } else {
            echo 'Client Email';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户行业';
        } else {
            echo 'Client Industry';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户微信';
        } else {
            echo 'Client Wechat';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户手机号码';
        } else {
            echo 'Client Mobile';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户生日';
        } else {
            echo 'Client Birthday';
        }
        ?></th>
    <th><?php
        if ($this->langtype == '_ch') {
            echo '客户国籍';
        } else {
            echo 'Client Nationality';
        }
        ?></th>
    <?php
    if ($clientinfo['add_type'] == 2) {
        ?>
        <th>Upload PDF</th>
        <?php
    }
    ?>
    <th>
        <?php
        if ($this->langtype == '_ch') {
            echo '订单时间';
        } else {
            echo 'Order Time';
        }
        ?>
    </th>

</thead>
<tbody>
    <tr>
        <td><?php echo $orderinformation['newclient_number'] ?></td>
        <td><?php echo $orderinformation['client_realname'] ?></td>
        <td><?php echo $orderinformation['client_address'] ?></td>
        <td><?php echo $orderinformation['client_email'] ?></td>
        <td><?php echo $orderinformation['client_industry'] ?></td>
        <td><?php echo $orderinformation['client_wechat'] ?></td>
        <td><?php echo $orderinformation['client_phone'] ?></td>
        <td><?php echo $orderinformation['client_birthday'] ?></td>
        <td><?php echo $orderinformation['client_nationality'] ?></td>
        <?php
        if ($clientinfo['add_type'] == 2) {
            ?>
            <td>
                <div class="img_gksel_show" id="img1_gksel_show">
                    <?php
                    $img1_gksel = '';
                    if (file_exists($clientinfo['company_businesslicense']) && $clientinfo['company_businesslicense'] != "") {
                        $img1_gksel = $clientinfo['company_businesslicense'];
                        echo '<a target="_blank" href="' . base_url() . $clientinfo['company_businesslicense'] . '">Download</a>';
                    }
                    ?>
                </div>
            </td>
            <?php
        }
        ?>
        <td><?php echo date('Y-m-d H:i:s', $orderinformation['created']) ?></td>
    </tr>
</tbody>
</table>
<?php
$sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
$categorylist = $this->db->query($sql)->result_array();
?>
<div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
<?php
if (!empty($orderinformation)) {

    foreach ($orderinformation['order_list'] as $orderinfo) {
        if (!empty($categorylist)) {
            ?>
            <table id="customers1" style="width:43%;">
                <tbody>
                <?php
                for ($c = 0; $c < count($categorylist); $c++) {
                    if (isset($orderinfo['design_list_' . $categorylist[$c]['category_id']]) && !empty($orderinfo['design_list_' . $categorylist[$c]['category_id']])) {

                        echo '<tr><td>
								<div style="float:left;margin-left:3%;line-height:30px;font-weight:bold;font-size:18px;">' . $categorylist[$c]['category_name' . $this->langtype] . ' - ' . $orderinfo['code_' . str_replace(' ', '_', strtolower($categorylist[$c]['category_name_en']))] . '</div>
						</td></tr>';


                        $design_list = $orderinfo['design_list_' . $categorylist[$c]['category_id']];
                        ?>
                        <tr>
                            <td>
                                <div class="refund_loglist_l">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                                        <?php for ($i = 0; $i < count($design_list); $i++) { ?>
                                            <tr>
                                                <td <?php
                                                if ($this->langtype == '_ch') {
                                                    echo 'width="125"';
                                                } else {
                                                    echo 'width="150"';
                                                }
                                                ?> style="padding-left:10px;padding-top:10px;"><?php echo $design_list[$i]['design_name' . $this->langtype] ?></td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if (isset($design_list[$i]['radio_value'])) {
                                                        if ($design_list[$i]['radio_pic'] != '') {
                                                            echo '
																		<div style="float:left;margin-left:10px;">
																			<img style="float:left;height:60px;" src="' . base_url() . $design_list[$i]['radio_pic'] . '"/>
																		</div>
																		<div style="float:left;margin-left:10px;line-height:60px;">
																			' . $design_list[$i]['radio_name' . $this->langtype] . '
																		</div>
																	';
                                                        } else {
                                                            echo '
																		<div style="float:left;margin-left:10px;line-height:60px;">
																			' . $design_list[$i]['radio_name' . $this->langtype] . '
																		</div>
																	';
                                                        }
                                                    }
                                                    if (isset($design_list[$i]['checkbox_value'])) {
                                                        if ($design_list[$i]['checkbox_value'] == 1) {
                                                            echo '
																		<div style="float:left;margin-left:10px;margin-top:23px;">
																			<input type="checkbox" class="mgc mgc-success" checked disabled/>
																		</div>
																	';
                                                        } else {
                                                            echo '
																		<div style="float:left;margin-left:10px;margin-top:23px;">
																			<input type="checkbox" class="mgc mgc-success" disabled/>
																		</div>
																	';
                                                        }
                                                    }
                                                    if (isset($design_list[$i]['design_pic']) && $design_list[$i]['design_pic'] != '') {
                                                        echo '
																	<div style="float:left;margin-left:10px;">
																		<!--<img style="float:left;height:60px;" src="' . base_url() . $design_list[$i]['design_pic'] . '"/> -->
																	</div>
																';
                                                    }
                                                    if (isset($design_list[$i]['input_title' . $this->langtype]) && isset($design_list[$i]['input_value'])) {
                                                        echo '
																	<div style="float:left;margin-left:10px;line-height:60px;">
																		' . $design_list[$i]['input_title' . $this->langtype] . ': 
																	</div>
					   												<div style="float:left;margin-left:10px;margin-top:20px;border-bottom:1px solid black;">
				   														' . $design_list[$i]['input_value'] . '
																	</div>
																';
                                                    } else if (isset($design_list[$i]['input_value'])) {
                                                        echo '
					   												<div style="float:left;margin-left:10px;margin-top:20px;border-bottom:1px solid black;">
				   														' . $design_list[$i]['input_value'] . '
																	</div>
																';
                                                    }

                                                    if (isset($design_list[$i]['input2_title' . $this->langtype]) && isset($design_list[$i]['input2_value'])) {
                                                        echo '
																	<div style="float:left;margin-left:10px;line-height:60px;">
																		' . $design_list[$i]['input2_title' . $this->langtype] . ':
																	</div>
					   												<div style="float:left;margin-left:10px;margin-top:20px;border-bottom:1px solid black;">
				   														' . $design_list[$i]['input2_value'] . '
																	</div>
																';
                                                    } else if (isset($design_list[$i]['input2_value'])) {
                                                        echo '
					   												<div style="float:left;margin-left:10px;margin-top:20px;border-bottom:1px solid black;">
				   														' . $design_list[$i]['input2_value'] . '
																	</div>
																';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        }
    } ?>
    <table id="customers1" style="width:55%; margin-left: 18px;">
        <tbody>
        <?php
        //  if ($userinfo['add_type'] == 1) {
        ?>
        <tr>
            <td colspan="2" style="height:30px; font-weight: bold; font-size: 20px;">Detailed Information:</td>
        </tr>
        <tr>
            <td>
                <div class="refund_loglist_l">
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                        <tr>
                            <td width="100" style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '姓名';
                                } else {
                                    echo 'Name';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinformation['client_realname'] != '0' && $orderinformation['client_realname'] != '') {
                                        echo $orderinformation['client_realname'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td width="100" align="center" style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '西服样式';
                                } else {
                                    echo 'JA Garment';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_garment'] != '0' && $orderinfo['ja_garment'] != '') {
                                        echo $orderinfo['ja_garment'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td width="100" style="padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '马甲样衣';
                                } else {
                                    echo 'WC Garment';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_garment'] != '0' && $orderinfo['wc_garment'] != '') {
                                        echo $orderinfo['wc_garment'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '客户编号';
                                } else {
                                    echo 'Client #';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php echo $orderinformation['newclient_number'] ?></div>
                            </td>
                            <td align="center" style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '衬衣样式';
                                } else {
                                    echo 'SH Garment';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_garment'] != '0' && $orderinfo['sh_garment'] != '') {
                                        echo $orderinfo['sh_garment'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '裤子样式';
                                } else {
                                    echo 'TR Garment';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_garment'] != '0' && $orderinfo['tr_garment'] != '') {
                                        echo $orderinfo['tr_garment'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                        <tr>
                            <td width="<?php
                            if ($this->langtype == '_ch') {
                                echo 60;
                            } else {
                                echo 115;
                            }
                            ?>" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '上身';
                                } else {
                                    echo 'UPPER BODY';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '西服';
                                } else {
                                    echo 'JA';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '衬衣';
                                } else {
                                    echo 'SH';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '马夹';
                                } else {
                                    echo 'WC';
                                }
                                ?></td>
                            <td width="<?php
                            if ($this->langtype == '_ch') {
                                echo 60;
                            } else {
                                echo 115;
                            }
                            ?>" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '下身';
                                } else {
                                    echo 'LOWER BODY';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;background:#EFEFEF;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '裤子';
                                } else {
                                    echo 'TR';
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '衣长';
                                } else {
                                    echo 'LENGTH';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_length'] != '0' && $orderinfo['ja_length'] != '') {
                                        echo $orderinfo['ja_length'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_length'] != '0' && $orderinfo['sh_length'] != '') {
                                        echo $orderinfo['sh_length'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_length'] != '0' && $orderinfo['wc_length'] != '') {
                                        echo $orderinfo['wc_length'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '裤子长';
                                } else {
                                    echo 'LENGTH';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_length'] != '0' && $orderinfo['tr_length'] != '') {
                                        echo $orderinfo['tr_length'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '肩宽';
                                } else {
                                    echo 'SHOULDERS';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_shoulders'] != '0' && $orderinfo['ja_shoulders'] != '') {
                                        echo $orderinfo['ja_shoulders'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_shoulders'] != '0' && $orderinfo['sh_shoulders'] != '') {
                                        echo $orderinfo['sh_shoulders'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_shoulders'] != '0' && $orderinfo['wc_shoulders'] != '') {
                                        echo $orderinfo['wc_shoulders'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '裤子腰围';
                                } else {
                                    echo 'WAIST';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_waist'] != '0' && $orderinfo['tr_waist'] != '') {
                                        echo $orderinfo['tr_waist'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '胸围';
                                } else {
                                    echo 'CHEST C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_chest'] != '0' && $orderinfo['ja_chest'] != '') {
                                        echo $orderinfo['ja_chest'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_chest'] != '0' && $orderinfo['sh_chest'] != '') {
                                        echo $orderinfo['sh_chest'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_chest'] != '0' && $orderinfo['wc_chest'] != '') {
                                        echo $orderinfo['wc_chest'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '臀围';
                                } else {
                                    echo 'GLUTEUS';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_gluteus'] != '0' && $orderinfo['tr_gluteus'] != '') {
                                        echo $orderinfo['tr_gluteus'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '前胸';
                                } else {
                                    echo 'CHEST FRONT';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_chest_f'] != '0' && $orderinfo['ja_chest_f'] != '') {
                                        echo $orderinfo['ja_chest_f'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_chest_f'] != '0' && $orderinfo['sh_chest_f'] != '') {
                                        echo $orderinfo['sh_chest_f'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_chest_f'] != '0' && $orderinfo['wc_chest_f'] != '') {
                                        echo $orderinfo['wc_chest_f'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '大腿围';
                                } else {
                                    echo 'THIGH';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_thigh'] != '0' && $orderinfo['tr_thigh'] != '') {
                                        echo $orderinfo['tr_thigh'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '后背';
                                } else {
                                    echo 'CHEST BACK';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_chest_b'] != '0' && $orderinfo['ja_chest_b'] != '') {
                                        echo $orderinfo['ja_chest_b'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_chest_b'] != '0' && $orderinfo['sh_chest_b'] != '') {
                                        echo $orderinfo['sh_chest_b'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_chest_b'] != '0' && $orderinfo['wc_chest_b'] != '') {
                                        echo $orderinfo['wc_chest_b'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '直裆长';
                                } else {
                                    echo 'CROTCH RISE';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_crotch_rise'] != '0' && $orderinfo['tr_crotch_rise'] != '') {
                                        echo $orderinfo['tr_crotch_rise'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '腰围';
                                } else {
                                    echo 'BUST C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_bust'] != '0' && $orderinfo['ja_bust'] != '') {
                                        echo $orderinfo['ja_bust'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_bust'] != '0' && $orderinfo['sh_bust'] != '') {
                                        echo $orderinfo['sh_bust'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_bust'] != '0' && $orderinfo['wc_bust'] != '') {
                                        echo $orderinfo['wc_bust'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <!--
                                                <td style="padding-left:10px;padding-top:10px;"><?php
                            if ($this->langtype == '_ch') {
                                echo '前裆';
                            } else {
                                echo 'Front Crotch';
                            }
                            ?></td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;"><div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                            if ($orderinfo['tr_crotch_front'] != '0' && $orderinfo['tr_crotch_front'] != '') {
                                echo $orderinfo['tr_crotch_front'];
                            } else {
                                echo '&nbsp;';
                            }
                            ?></div></td>
                                                -->
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '中裆围';
                                } else {
                                    echo 'HAMSTRING';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_hamstring'] != '0' && $orderinfo['tr_hamstring'] != '') {
                                        echo $orderinfo['tr_hamstring'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '臀围';
                                } else {
                                    echo 'HIP C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_circumference'] != '0' && $orderinfo['ja_circumference'] != '') {
                                        echo $orderinfo['ja_circumference'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_circumference'] != '0' && $orderinfo['sh_circumference'] != '') {
                                        echo $orderinfo['sh_circumference'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_circumference'] != '0' && $orderinfo['wc_circumference'] != '') {
                                        echo $orderinfo['wc_circumference'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <!--
                                                <td style="padding-left:10px;padding-top:10px;"><?php
                            if ($this->langtype == '_ch') {
                                echo '后裆';
                            } else {
                                echo 'Back Crotch';
                            }
                            ?></td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;"><div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                            if ($orderinfo['tr_crotch_back'] != '0' && $orderinfo['tr_crotch_back'] != '') {
                                echo $orderinfo['tr_crotch_back'];
                            } else {
                                echo '&nbsp;';
                            }
                            ?></div></td>
                                                -->
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '小腿围';
                                } else {
                                    echo 'CALF';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_calf'] != '0' && $orderinfo['tr_calf'] != '') {
                                        echo $orderinfo['tr_calf'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '袖长';
                                } else {
                                    echo 'SLEEVE';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_sleeve'] != '0' && $orderinfo['ja_sleeve'] != '') {
                                        echo $orderinfo['ja_sleeve'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_sleeve'] != '0' && $orderinfo['sh_sleeve'] != '') {
                                        echo $orderinfo['sh_sleeve'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_sleeve'] != '0' && $orderinfo['wc_sleeve'] != '') {
                                        echo $orderinfo['wc_sleeve'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '脚口围';
                                } else {
                                    echo 'ANKLE';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['tr_ankle'] != '0' && $orderinfo['tr_ankle'] != '') {
                                        echo $orderinfo['tr_ankle'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '袖肥';
                                } else {
                                    echo 'BICEP C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_bicep'] != '0' && $orderinfo['ja_bicep'] != '') {
                                        echo $orderinfo['ja_bicep'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_bicep'] != '0' && $orderinfo['sh_bicep'] != '') {
                                        echo $orderinfo['sh_bicep'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_bicep'] != '0' && $orderinfo['wc_bicep'] != '') {
                                        echo $orderinfo['wc_bicep'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '袖口';
                                } else {
                                    echo 'WRIST C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_wrist'] != '0' && $orderinfo['ja_wrist'] != '') {
                                        echo $orderinfo['ja_wrist'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_wrist'] != '0' && $orderinfo['sh_wrist'] != '') {
                                        echo $orderinfo['sh_wrist'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_wrist'] != '0' && $orderinfo['wc_wrist'] != '') {
                                        echo $orderinfo['wc_wrist'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                        </tr>
                        <tr>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '领围';
                                } else {
                                    echo 'NECK C';
                                }
                                ?></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['ja_neck'] != '0' && $orderinfo['ja_neck'] != '') {
                                        echo $orderinfo['ja_neck'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['sh_neck'] != '0' && $orderinfo['sh_neck'] != '') {
                                        echo $orderinfo['sh_neck'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['wc_neck'] != '0' && $orderinfo['wc_neck'] != '') {
                                        echo $orderinfo['wc_neck'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;"></td>
                            <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                        </tr>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                        <tr>
                            <td width="<?php
                            if ($this->langtype == '_ch') {
                                echo 60;
                            } else {
                                echo 115;
                            }
                            ?>" style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '西装编号';
                                } else {
                                    echo 'Suit Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_suit'] != '0' && $orderinfo['code_suit'] != '') {
                                        echo $orderinfo['code_suit'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_suit_select'] != '0' && $orderinfo['code_suit_select'] != '' && $orderinfo['code_suit_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_suit_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_suit_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_suit_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td width="<?php
                            if ($this->langtype == '_ch') {
                                echo 60;
                            } else {
                                echo 115;
                            }
                            ?>" style="padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '马夹编号';
                                } else {
                                    echo 'Waistcoat Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_waistcoat'] != '0' && $orderinfo['code_waistcoat'] != '') {
                                        echo $orderinfo['code_waistcoat'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_waistcoat_select'] != '0' && $orderinfo['code_waistcoat_select'] != '' && $orderinfo['code_waistcoat_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_waistcoat_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_waistcoat_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_waistcoat_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '裤子编号';
                                } else {
                                    echo 'Trousers Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_trousers'] != '0' && $orderinfo['code_trousers'] != '') {
                                        echo $orderinfo['code_trousers'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_trousers_select'] != '0' && $orderinfo['code_trousers_select'] != '' && $orderinfo['code_trousers_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_trousers_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_trousers_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_trousers_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td style="padding-top:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '衬衫编号';
                                } else {
                                    echo 'Shirt Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_shirt'] != '0' && $orderinfo['code_shirt'] != '') {
                                        echo $orderinfo['code_shirt'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_shirt_select'] != '0' && $orderinfo['code_shirt_select'] != '' && $orderinfo['code_shirt_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_shirt_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_shirt_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_shirt_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '大衣编号';
                                } else {
                                    echo 'Overcoat Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_overcoat'] != '0' && $orderinfo['code_overcoat'] != '') {
                                        echo $orderinfo['code_overcoat'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_overcoat_select'] != '0' && $orderinfo['code_overcoat_select'] != '' && $orderinfo['code_overcoat_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_overcoat_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_overcoat_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_overcoat_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>

                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '短裤代码';
                                } else {
                                    echo 'Shorts Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_shorts'] != '0' && $orderinfo['code_shorts'] != '') {
                                        echo $orderinfo['code_shorts'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_shorts_select'] != '0' && $orderinfo['code_shorts_select'] != '' && $orderinfo['code_shorts_select'] != ' ') {
                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_shorts_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_shorts_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_shorts_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '牛仔长裤代码';
                                } else {
                                    echo 'Denim Trouser Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_denim_trousers'] != '0' && $orderinfo['code_denim_trousers'] != '') {
                                        echo $orderinfo['code_denim_trousers'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_denim_trousers_select'] != '0' && $orderinfo['code_denim_trousers_select'] != '' && $orderinfo['code_denim_trousers_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_denim_trousers_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_denim_trousers_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_denim_trousers_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>

                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '休闲裤代码';
                                } else {
                                    echo 'Casual Trouser Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_casual_trousers'] != '0' && $orderinfo['code_casual_trousers'] != '') {
                                        echo $orderinfo['code_casual_trousers'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_casual_trousers_select'] != '0' && $orderinfo['code_casual_trousers_select'] != '' && $orderinfo['code_casual_trousers_select'] != ' ') {
                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_casual_trousers_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_casual_trousers_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_casual_trousers_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;"><?php
                                if ($this->langtype == '_ch') {
                                    echo '法兰绒裤子代码';
                                } else {
                                    echo 'Flannel Trouser Code';
                                }
                                ?></td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;"><?php
                                    if ($orderinfo['code_flannel_trousers'] != '0' && $orderinfo['code_flannel_trousers'] != '') {
                                        echo $orderinfo['code_flannel_trousers'];
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?></div>
                            </td>
                            <td align="center" style="padding:10px;">
                                <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                    <?php
                                    if ($orderinfo['code_flannel_trousers_select'] != '0' && $orderinfo['code_flannel_trousers_select'] != '' && $orderinfo['code_flannel_trousers_select'] != ' ') {

                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND ((cms_name_en = '" . $orderinfo['code_flannel_trousers_select'] . "') OR (cms_name_ch = '" . $orderinfo['code_flannel_trousers_select'] . "'))";
                                        $selectselectinfo = $this->db->query($sql)->row_array();
                                        if (!empty($selectselectinfo)) {
                                            echo $selectselectinfo['cms_name' . $this->langtype];
                                        } else {
                                            echo $orderinfo['code_flannel_trousers_select'];
                                        }
                                    } else {
                                        echo '&nbsp;';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <?php
        //   }
        ?>

        </tbody>

        <!--Order Images-->
        <?php if ($orderimages) { ?>
            <tr>
                <td>
                    <div style="float:left;margin-left:3%;line-height:30px;font-weight:bold;font-size:18px;">Images</div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php foreach ($orderimages as $image) { ?>
                        <div style="float:left;margin-left:10px;border:2px solid #ddd;">
                            <a href="<?= base_url($image['image']) ?>" target="_blank"><img style="height:60px;"
                                                                                            src="<?= base_url($image['image']) ?>"></a>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>

        <!--Order Notes-->
        <?php if ($ordernotes) { ?>
            <tr>
                <td>
                    <div style="float:left;margin-left:3%;line-height:30px;font-weight:bold;font-size:18px;">Notes</div>
                </td>
            </tr>
            <?php foreach ($ordernotes as $note) { ?>
                <tr>
                    <td><?= $note['note'] ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
    <?php
}
?>
</div>
<?php $this->load->view('admin/footer') ?>
