<?php
$user_id = $this->session->userdata('user_id');
if ($user_id > 0) {
    $this->load->view('admin/subheader');
} else {
    $this->load->view('admin/header');
}

?>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 99%;
            margin-top: 60px;
        }

        #customers input {
            width: 80%;
        }

        customers th {
            border: 1px solid #ddd;
            padding: 8px;
            width: 23%;
        }

        #td1 {
            border: 1px solid #ddd;
            padding: 8px;
            width: 10%;
        }

        #td2 {
            border: 1px solid #ddd;
            padding: 8px;
            width: 35%;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

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
            float: left;
        }

        #customers1 td,
        #customers1 th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers1 tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers1 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <form id="testform" action="#">
        <table id="customers">
            <tbody>
            <tr>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户编号';
                    } else {
                        echo 'Client#';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <?php echo $orderinformation['newclient_number'] ?>
                </td>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户姓名';
                    } else {
                        echo 'Client Name';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_realname" type="text" value="<?php echo $orderinformation['client_realname'] ?>"/>
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户地址';
                    } else {
                        echo 'Client Address';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_address" type="text" value="<?php echo $orderinformation['client_address'] ?>"/>
                </td>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户邮箱';
                    } else {
                        echo 'Client Email';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_email" type="text" value="<?php echo $orderinformation['client_email'] ?>"/>
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户行业';
                    } else {
                        echo 'Client Industry';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_industry" type="text" value="<?php echo $orderinformation['client_industry'] ?>"/>
                </td>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户微信';
                    } else {
                        echo 'Client Wechat';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_wechat" type="text" value="<?php echo $orderinformation['client_wechat'] ?>"/>
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户手机号码';
                    } else {
                        echo 'Client Mobile';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_phone" type="text" value="<?php echo $orderinformation['client_phone'] ?>"/>
                </td>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户生日';
                    } else {
                        echo 'Client Birthday';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_birthday" type="text" value="<?php echo $orderinformation['client_birthday'] ?>"/>
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '客户国际';
                    } else {
                        echo 'Client Nationality';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <input name="client_nationality" type="text" value="<?php echo $orderinformation['client_nationality'] ?>"/>
                </td>
                <td id="td1">
                    <?php
                    if ($this->langtype == '_ch') {
                        echo '订单时间';
                    } else {
                        echo 'Order Time';
                    }
                    ?>&nbsp;&nbsp;&nbsp;
                </td>
                <td id="td2">
                    <?php echo date('Y-m-d H:i:s', $orderinformation['created']) ?>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
        $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
        $categorylist = $this->db->query($sql)->result_array();
        ?>
        <?php
        if (!empty($orderinformation)) {
            $count = 0;
            foreach ($orderinformation['order_list'] as $orderinfo) {
                $count++;
                if (!empty($categorylist)) {
                    ?>
                    <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                        <table id="customers1" style="width:55%;">
                            <tbody>
                            <?php
                            for ($c = 0; $c < count($categorylist); $c++) {
                                if (isset($orderinfo['design_list_' . $categorylist[$c]['category_id']]) && !empty($orderinfo['design_list_' . $categorylist[$c]['category_id']])) {
                                    echo '<tr><td>								<div style="float:left;margin-left:3%;line-height:30px;font-weight:bold;font-size:18px;">' . $categorylist[$c]['category_name' . $this->langtype] . '</div>						</td></tr>';
                                    $design_list = $orderinfo['design_list_' . $categorylist[$c]['category_id']];
                                    $sql = "SELECT * FROM " . DB_PRE() . "category_design WHERE status = 1 AND parent = 0 AND category_id = " . $categorylist[$c]['category_id'] . " ORDER BY sort ASC";
                                    $data_designlist = $this->db->query($sql)->result_array();
                                    $newre = array();
                                    if (!empty($data_designlist)) {
                                        for ($i = 0; $i < count($data_designlist); $i++) {
                                            $thisarr = array();
                                            $thisarr['design_id'] = $data_designlist[$i]['design_id'];
                                            $thisarr['design_name_en'] = $data_designlist[$i]['design_name_en'];
                                            $thisarr['design_name_ch'] = $data_designlist[$i]['design_name_ch'];
                                            if ($data_designlist[$i]['ishave_input'] == 1) {
                                                $thisarr['ishave_input'] = 1;
                                                if ($data_designlist[$i]['input_title_en'] != '') {
                                                    $thisarr['input_title_en'] = $data_designlist[$i]['input_title_en'];
                                                }
                                                if ($data_designlist[$i]['input_title_ch'] != '') {
                                                    $thisarr['input_title_ch'] = $data_designlist[$i]['input_title_ch'];
                                                }
                                            }
                                            if ($data_designlist[$i]['ishave_input2'] == 1) {
                                                $thisarr['ishave_input2'] = 1;
                                                if ($data_designlist[$i]['input2_title_en'] != '') {
                                                    $thisarr['input2_title_en'] = $data_designlist[$i]['input2_title_en'];
                                                }
                                                if ($data_designlist[$i]['input2_title_ch'] != '') {
                                                    $thisarr['input2_title_ch'] = $data_designlist[$i]['input2_title_ch'];
                                                }
                                            }
                                            $sql = "SELECT * FROM " . DB_PRE() . "category_design WHERE status = 1 AND parent = " . $data_designlist[$i]['design_id'] . " ORDER BY sort ASC";
                                            $sublist_get = $this->db->query($sql)->result_array();
                                            $sublist = array();
                                            if (!empty($sublist_get)) {
                                                for ($j = 0; $j < count($sublist_get); $j++) {
                                                    $sublist[$j]['design_id'] = $sublist_get[$j]['design_id'];
                                                    $sublist[$j]['design_name_en'] = $sublist_get[$j]['design_name_en'];
                                                    $sublist[$j]['design_name_ch'] = $sublist_get[$j]['design_name_ch'];
                                                    if ($sublist_get[$j]['ishave_radio'] == 1) {
                                                        $sublist[$j]['ishave_radio'] = 1;
                                                    } else {
                                                        $sublist[$j]['ishave_radio'] = 0;
                                                    }
                                                    if ($sublist_get[$j]['ishave_checkbox'] == 1) {
                                                        $sublist[$j]['ishave_checkbox'] = 1;
                                                    } else {
                                                        $sublist[$j]['ishave_checkbox'] = 0;
                                                    }
                                                    if ($sublist_get[$j]['ishave_input'] == 1) {
                                                        $sublist[$j]['ishave_input'] = 1;
                                                        $sublist[$j]['input_title_en'] = $sublist_get[$j]['input_title_en'];
                                                        $sublist[$j]['input_title_ch'] = $sublist_get[$j]['input_title_ch'];
                                                    } else {
                                                        $sublist[$j]['ishave_input'] = 0;
                                                        $sublist[$j]['input_title_en'] = '';
                                                        $sublist[$j]['input_title_ch'] = '';
                                                    }
                                                    if ($sublist_get[$j]['ishave_input2'] == 1) {
                                                        $sublist[$j]['ishave_input2'] = 1;
                                                        $sublist[$j]['input2_title_en'] = $sublist_get[$j]['input2_title_en'];
                                                        $sublist[$j]['input2_title_ch'] = $sublist_get[$j]['input2_title_ch'];
                                                    } else {
                                                        $sublist[$j]['ishave_input2'] = 0;
                                                        $sublist[$j]['input2_title_en'] = '';
                                                        $sublist[$j]['input2_title_ch'] = '';
                                                    }
                                                    if ($sublist_get[$j]['ishave_picture'] == 1) {
                                                        $sublist[$j]['design_pic'] = $sublist_get[$j]['design_pic'];
                                                    } else {
                                                        $sublist[$j]['design_pic'] = '';
                                                    }
                                                    $sql = "SELECT * FROM " . DB_PRE() . "category_design WHERE status = 1 AND parent = " . $sublist_get[$j]['design_id'] . " ORDER BY sort ASC";
                                                    $thirdlist_get = $this->db->query($sql)->result_array();
                                                    $thirdlist = array();
                                                    if (!empty($thirdlist_get)) {
                                                        for ($k = 0; $k < count($thirdlist_get); $k++) {
                                                            $thirdlist[$k]['design_id'] = $thirdlist_get[$k]['design_id'];
                                                            $thirdlist[$k]['design_name_en'] = $thirdlist_get[$k]['design_name_en'];
                                                            $thirdlist[$k]['design_name_ch'] = $thirdlist_get[$k]['design_name_ch'];
                                                            if ($thirdlist_get[$k]['ishave_radio'] == 1) {
                                                                $thirdlist[$k]['ishave_radio'] = 1;
                                                            } else {
                                                                $thirdlist[$k]['ishave_radio'] = 0;
                                                            }
                                                            if ($thirdlist_get[$k]['ishave_checkbox'] == 1) {
                                                                $thirdlist[$k]['ishave_checkbox'] = 1;
                                                            } else {
                                                                $thirdlist[$k]['ishave_checkbox'] = 0;
                                                            }
                                                            if ($thirdlist_get[$k]['ishave_input'] == 1) {
                                                                $thirdlist[$k]['ishave_input'] = 1;
                                                                $thirdlist[$k]['input_title_en'] = $thirdlist_get[$k]['input_title_en'];
                                                                $thirdlist[$k]['input_title_ch'] = $thirdlist_get[$k]['input_title_ch'];
                                                            } else {
                                                                $thirdlist[$k]['ishave_input'] = 0;
                                                                $thirdlist[$k]['input_title_en'] = '';
                                                                $thirdlist[$k]['input_title_ch'] = '';
                                                            }
                                                            if ($thirdlist_get[$k]['ishave_input2'] == 1) {
                                                                $thirdlist[$k]['ishave_input2'] = 1;
                                                                $thirdlist[$k]['input2_title_en'] = $thirdlist_get[$k]['input2_title_en'];
                                                                $thirdlist[$k]['input2_title_ch'] = $thirdlist_get[$k]['input2_title_ch'];
                                                            } else {
                                                                $thirdlist[$k]['ishave_input2'] = 0;
                                                                $thirdlist[$k]['input2_title_en'] = '';
                                                                $thirdlist[$k]['input2_title_ch'] = '';
                                                            }
                                                            if ($thirdlist_get[$k]['ishave_picture'] == 1) {
                                                                $thirdlist[$k]['design_pic'] = $thirdlist_get[$k]['design_pic'];
                                                            } else {
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
                                            <div class="refund_loglist_l">
                                                <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                                                    <?php
                                                    for ($i = 0; $i < count($data_designlist); $i++) {
                                                        $sql = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id = " . $orderinformation['order_id'] . " AND order_list_id=" . $orderinfo['order_list_id'] . " AND design_id = " . $data_designlist[$i]['design_id'];
                                                        $parent_design_data = $this->db->query($sql)->row_array();
                                                        ?>
                                                        <tr>
                                                            <td valign="top" <?php if ($this->langtype == '_ch') {
                                                                echo 'width="125"';
                                                            } else {
                                                                echo 'width="150"';
                                                            } ?> style="padding-left:10px;padding-top:10px;">
                                                                <?php echo $data_designlist[$i]['design_name' . $this->langtype] ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" style="padding-left:10px;">
                                                                <?php
                                                                if (isset($data_designlist[$i]['sublist'])) {
                                                                    $sublist = $data_designlist[$i]['sublist'];
                                                                } else {
                                                                    $sublist = NULL;
                                                                }
                                                                if (isset($sublist)) {
                                                                    if (!empty($sublist)) {
                                                                        if (isset($sublist[0]['ishave_radio']) && $sublist[0]['ishave_radio'] == 1) {
                                                                            echo '																			<input name="alldesign_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $data_designlist[$i]['design_id'] . '"/>																			<input name="alltarget_type_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="radio"/>																			<input name="allcategory_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $categorylist[$c]['category_id'] . '"/>																		';
                                                                        }
                                                                        for ($mmm = 0; $mmm < count($sublist); $mmm++) {
                                                                            if (isset($sublist[$mmm]['ishave_radio']) && $sublist[$mmm]['ishave_radio'] == 1) {
                                                                                if ($sublist[$mmm]['design_pic'] != '') {
                                                                                    $this_radio_pic = '																													<div style="float:left;width:100%;">																														<img style="float:left;height:60px;" src="' . base_url() . $sublist[$mmm]['design_pic'] . '"/>																													</div>																												';
                                                                                } else {
                                                                                    $this_radio_pic = '';
                                                                                }
                                                                                $ischecked = '';
                                                                                if (!empty($parent_design_data)) {
                                                                                    if ($parent_design_data['radio_value'] == $sublist[$mmm]['design_id']) {
                                                                                        $ischecked = 'checked';
                                                                                    }
                                                                                }
                                                                                echo '																												<div style="float:left;width:150px;margin:10px 0px;">																													' . $this_radio_pic . '																													<div style="float:left;width:100%;margin:10px 0px;">																														<div style="float:left;width:25px;">																															<input name="design_id_' . $data_designlist[$i]['design_id'] . '_' . $orderinfo['order_list_id'] . '" class="mgr mgr-success" type="radio" value="' . $sublist[$mmm]['design_id'] . '" ' . $ischecked . '/>																														</div>																														<div style="float:left;width:calc(100% - 25px);">																															' . $sublist[$mmm]['design_name' . $this->langtype] . '																														</div>																													</div>																												</div>																											';
                                                                            } else if (isset($sublist[$mmm]['ishave_checkbox']) && $sublist[$mmm]['ishave_checkbox'] == 1) {
                                                                                echo '																									<input name="alldesign_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $sublist[$mmm]['design_id'] . '"/>																									<input name="alltarget_type_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="checkbox"/>																									<input name="allcategory_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $categorylist[$c]['category_id'] . '"/>																																		';
                                                                                $sql = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id = " . $orderinformation['order_id'] . " AND order_list_id=" . $orderinfo['order_list_id'] . " AND design_id = " . $sublist[$mmm]['design_id'];
                                                                                $sub_design_data = $this->db->query($sql)->row_array();
                                                                                $ischecked = '';
                                                                                if (!empty($sub_design_data)) {
                                                                                    $input_value = $sub_design_data['input_value'];
                                                                                    $input2_value = $sub_design_data['input2_value'];
                                                                                    if ($sub_design_data['checkbox_value'] == 1) {
                                                                                        $ischecked = 'checked';
                                                                                    }
                                                                                } else {
                                                                                    $input_value = '';
                                                                                    $input2_value = '';
                                                                                }
                                                                                if (isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1) {
                                                                                    $show_input_title = '																										<div style="float:left;margin-left:20px;">																											' . $sublist[$mmm]['input_title' . $this->langtype] . '																										</div>																										<div style="float:left;margin-left:20px;">																											<input type="text" name="input_title_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input_value . '"/>																										</div>																									';
                                                                                } else {
                                                                                    $show_input_title = '';
                                                                                }
                                                                                if (isset($sublist[$mmm]['ishave_input2']) && $sublist[$mmm]['ishave_input2'] == 1) {
                                                                                    $show_input2_title = '																										<div style="float:left;margin-left:20px;">																											' . $sublist[$mmm]['input2_title' . $this->langtype] . '																										</div>																										<div style="float:left;margin-left:20px;">																											<input type="text" name="input2_title_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input2_value . '"/>																										</div>																									';
                                                                                } else {
                                                                                    $show_input2_title = '';
                                                                                }
                                                                                if ($sublist[$mmm]['design_pic'] != '') {
                                                                                    echo '																										<div style="float:left;width:100%;margin:10px 0px;">																											<div style="float:left;width:45px;">																												<img style="float:left;max-width:40px;max-height:40px;" src="' . base_url() . $sublist[$mmm]['design_pic'] . '"/>																											</div>																											<div style="float:left;width:calc(100% - 45px);">																												<div style="float:left;width:25px;">																													<input name="design_id_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" class="mgc mgc-success" type="checkbox" value="1" ' . $ischecked . '/>																												</div>																												<div style="float:left;width:calc(100% - 25px);">																													<div style="float:left;">' . $sublist[$mmm]['design_name' . $this->langtype] . '</div>																													' . $show_input_title . '																													' . $show_input2_title . '																												</div>																											</div>																										</div>																									';
                                                                                } else {
                                                                                    echo '																										<div style="float:left;width:100%;margin:10px 0px;">																											<div style="float:left;width:25px;">																												<input name="design_id_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" class="mgc mgc-success" type="checkbox" value="1" ' . $ischecked . '/>																											</div>																											<div style="float:left;width:calc(100% - 25px);">																												<div style="float:left;">' . $sublist[$mmm]['design_name' . $this->langtype] . '</div>																												' . $show_input_title . '																												' . $show_input2_title . '																											</div>																										</div>																									';
                                                                                }
                                                                            } else if (isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1) {
                                                                                echo '																									<input name="alldesign_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $sublist[$mmm]['design_id'] . '"/>																									<input name="alltarget_type_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="checkbox"/>																									<input name="allcategory_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $categorylist[$c]['category_id'] . '"/>																																		';
                                                                                $sql = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id = " . $orderinformation['order_id'] . " AND order_list_id=" . $orderinfo['order_list_id'] . " AND design_id = " . $sublist[$mmm]['design_id'];
                                                                                $sub_design_data = $this->db->query($sql)->row_array();
                                                                                if (!empty($sub_design_data)) {
                                                                                    $input_value = $sub_design_data['input_value'];
                                                                                    $input2_value = $sub_design_data['input2_value'];
                                                                                } else {
                                                                                    $input_value = '';
                                                                                    $input2_value = '';
                                                                                }
                                                                                if (isset($sublist[$mmm]['ishave_input']) && $sublist[$mmm]['ishave_input'] == 1) {
                                                                                    $show_input_title = '';
                                                                                    if (isset($sublist[$mmm]['input_title' . $this->langtype])) {
                                                                                        $show_input_title .= '																											<div style="float:left;margin-left:20px;">																												' . $sublist[$mmm]['input_title' . $this->langtype] . '																											</div>																										';
                                                                                    }
                                                                                    $show_input_title .= '																										<div style="float:left;margin-left:20px;">																											<input type="text" name="input_title_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input_value . '"/>																										</div>																									';
                                                                                } else {
                                                                                    $show_input_title = '';
                                                                                }
                                                                                if (isset($sublist[$mmm]['ishave_input2']) && $sublist[$mmm]['ishave_input2'] == 1) {
                                                                                    $show_input2_title = '';
                                                                                    if (isset($sublist[$mmm]['input2_title' . $this->langtype])) {
                                                                                        $show_input2_title .= '																											<div style="float:left;margin-left:20px;">																												' . $sublist[$mmm]['input2_title' . $this->langtype] . '																											</div>																										';
                                                                                    }
                                                                                    $show_input2_title .= '																										<div style="float:left;margin-left:20px;">																											<input type="text" name="input2_title_' . $sublist[$mmm]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input2_value . '"/>																										</div>																									';
                                                                                } else {
                                                                                    $show_input2_title = '';
                                                                                }
                                                                                if ($sublist[$mmm]['design_pic'] != '') {
                                                                                    echo '																										<div style="float:left;width:100%;margin:10px 0px;">																											<div style="float:left;width:45px;">																												<img style="float:left;max-width:40px;max-height:40px;" src="' . base_url() . $sublist[$mmm]['design_pic'] . '"/>																											</div>																											<div style="float:left;width:calc(100% - 45px);">																												<div style="float:left;width:100%;">																													<div style="float:left;">' . $sublist[$mmm]['design_name' . $this->langtype] . '</div>																													' . $show_input_title . '																													' . $show_input2_title . '																												</div>																											</div>																										</div>																									';
                                                                                } else {
                                                                                    echo '																										<div style="float:left;width:100%;margin:10px 0px;">																											<div style="float:left;width:100%;">																												<div style="float:left;">' . $sublist[$mmm]['design_name' . $this->langtype] . '</div>																												' . $show_input_title . '																												' . $show_input2_title . '																											</div>																										</div>																									';
                                                                                }
                                                                            } else {
                                                                                if (isset($sublist[$mmm]['thirdlist'])) {
                                                                                    $thirdlist = $sublist[$mmm]['thirdlist'];
                                                                                } else {
                                                                                    $thirdlist = array();
                                                                                }
                                                                                echo '																									<div style="float:left;width:100%;margin:10px 0px;">																										' . $sublist[$mmm]['design_name' . $this->langtype] . '																									</div>																								';
                                                                                if (!empty($thirdlist)) {
                                                                                    for ($nnn = 0; $nnn < count($thirdlist); $nnn++) {
                                                                                        echo '																											<input name="alldesign_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $thirdlist[$nnn]['design_id'] . '"/>																											<input name="alltarget_type_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="checkboxorinput"/>																											<input name="allcategory_id_' . $orderinfo['order_list_id'] . '[]" type="hidden" value="' . $categorylist[$c]['category_id'] . '"/>																										';
                                                                                        $sql = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id = " . $orderinformation['order_id'] . " AND order_list_id=" . $orderinfo['order_list_id'] . " AND design_id = " . $thirdlist[$nnn]['design_id'];
                                                                                        $third_design_data = $this->db->query($sql)->row_array();
                                                                                        $ischecked = '';
                                                                                        if (!empty($third_design_data)) {
                                                                                            $input_value = $third_design_data['input_value'];
                                                                                            $input2_value = $third_design_data['input2_value'];
                                                                                            if ($third_design_data['checkbox_value'] == 1) {
                                                                                                $ischecked = 'checked';
                                                                                            }
                                                                                        } else {
                                                                                            $input_value = '';
                                                                                            $input2_value = '';
                                                                                        }
                                                                                        if (isset($thirdlist[$nnn]['ishave_input']) && $thirdlist[$nnn]['ishave_input'] == 1) {
                                                                                            $show_input_title = '';
                                                                                            if (isset($thirdlist[$nnn]['input_title' . $this->langtype])) {
                                                                                                $show_input_title .= '																													<div style="float:left;margin-left:20px;">																														' . $thirdlist[$nnn]['input_title' . $this->langtype] . '																													</div>																												';
                                                                                            }
                                                                                            $show_input_title .= '																												<div style="float:left;margin-left:20px;">																													<input type="text" name="input_title_' . $thirdlist[$nnn]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input_value . '"/>																												</div>																											';
                                                                                        } else {
                                                                                            $show_input_title = '';
                                                                                        }
                                                                                        if (isset($thirdlist[$nnn]['ishave_input2']) && $thirdlist[$nnn]['ishave_input2'] == 1) {
                                                                                            $show_input2_title = '';
                                                                                            if (isset($thirdlist[$nnn]['input2_title' . $this->langtype])) {
                                                                                                $show_input2_title .= '																													<div style="float:left;margin-left:20px;">																														' . $thirdlist[$nnn]['input2_title' . $this->langtype] . '																													</div>																												';
                                                                                            }
                                                                                            $show_input2_title .= '																												<div style="float:left;margin-left:20px;">																													<input type="text" name="input2_title_' . $thirdlist[$nnn]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input2_value . '"/>																												</div>																											';
                                                                                        } else {
                                                                                            $show_input2_title = '';
                                                                                        }
                                                                                        if (isset($thirdlist[$nnn]['ishave_checkbox']) && $thirdlist[$nnn]['ishave_checkbox'] == 1) {
                                                                                            $show_checkbox_style = '																												<div style="float:left;width:25px;">																													<input name="design_id_' . $thirdlist[$nnn]['design_id'] . '_' . $orderinfo['order_list_id'] . '" class="mgc mgc-success" type="checkbox" value="1" ' . $ischecked . '/>																												</div>																											';
                                                                                        } else {
                                                                                            $show_checkbox_style = '';
                                                                                        }
                                                                                        echo '																											<div style="float:left;width:calc(100% - 30px);margin:10px 0px 10px 30px;">																												' . $show_checkbox_style . '																												<div style="float:left;width:calc(100% - 25px);">																													<div style="float:left;">' . $thirdlist[$nnn]['design_name' . $this->langtype] . '</div>																													' . $show_input_title . '																													' . $show_input2_title . '																												</div>																											</div>																										';
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if (isset($data_designlist[$i]['ishave_input']) && $data_designlist[$i]['ishave_input'] == 1) {
                                                                    if (!empty($parent_design_data)) {
                                                                        $input_title = $parent_design_data['input_value'];
                                                                    } else {
                                                                        $input_title = '';
                                                                    }
                                                                    $show_input_title = '																	<div style="float:left;margin-left:20px;">																		' . $data_designlist[$i]['input_title' . $this->langtype] . '																	</div>																	<div style="float:left;margin-left:20px;">																		<input type="text" name="input_title_' . $data_designlist[$i]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input_title . '"/>																	</div>																';
                                                                } else {
                                                                    $show_input_title = '';
                                                                }
                                                                if (isset($data_designlist[$i]['ishave_input2']) && $data_designlist[$i]['ishave_input2'] == 1) {
                                                                    if (!empty($parent_design_data)) {
                                                                        $input2_title = $parent_design_data['input2_value'];
                                                                    } else {
                                                                        $input2_title = '';
                                                                    }
                                                                    $show_input2_title = '																	<div style="float:left;margin-left:20px;">																		' . $data_designlist[$i]['input2_title' . $this->langtype] . '																	</div>																	<div style="float:left;margin-left:20px;">																		<input type="text" name="input2_title_' . $data_designlist[$i]['design_id'] . '_' . $orderinfo['order_list_id'] . '" style="width:50px;" value="' . $input2_title . '"/>																	</div>																';
                                                                } else {
                                                                    $show_input2_title = '';
                                                                }
                                                                echo '																<div style="float:left;width:100%;margin:20px 0px;">																	' . $show_input_title . '																	' . $show_input2_title . '																</div>															';
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
                        <table id="customers1" style="width:43%; margin-left: 18px;">
                            <tbody>
                            <?php // if ($userinfo['add_type'] == 1) { ?>
                            <tr>
                                <td colspan="2" style="height:30px; font-weight: bold; font-size: 20px;">Detailed Information:</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="refund_loglist_l">
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                                            <tr>
                                                <td width="100" style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '姓名';
                                                    } else {
                                                        echo 'Name';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                                        <?php
                                                        if ($orderinformation['client_realname'] != '0' && $orderinformation['client_realname'] != '') {
                                                            echo $orderinformation['client_realname'];
                                                        } else {
                                                            echo '&nbsp;';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '客户编号';
                                                    } else {
                                                        echo 'Client #';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <div style="float:left;width:calc(100% - 20px);line-height:25px;margin-left:10px;border-bottom:1px solid black;">
                                                        <?php echo $orderinformation['newclient_number'] ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100" align="center" style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西服样式';
                                                    } else {
                                                        echo 'JA Garment';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="ja_garment_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_garment'] != '0' && $orderinfo['ja_garment'] != '') {
                                                               echo $orderinfo['ja_garment'];
                                                           } else {
                                                               echo '&nbsp;';
                                                           }
                                                           ?>"/>
                                                </td>
                                                <td width="100" style="padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '马甲样衣';
                                                    } else {
                                                        echo 'WC Garment';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="wc_garment_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_garment'] != '0' && $orderinfo['wc_garment'] != '') {
                                                               echo $orderinfo['wc_garment'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '衬衣样式';
                                                    } else {
                                                        echo 'SH Garment';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="sh_garment_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_garment'] != '0' && $orderinfo['sh_garment'] != '') {
                                                               echo $orderinfo['sh_garment'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '裤子样式';
                                                    } else {
                                                        echo 'TR Garment';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="tr_garment_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_garment'] != '0' && $orderinfo['tr_garment'] != '') {
                                                               echo $orderinfo['tr_garment'];
                                                           } else {

                                                           }
                                                           ?>"/>
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
                                                ?>" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '上身';
                                                    } else {
                                                        echo 'UPPER BODY';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西服';
                                                    } else {
                                                        echo 'JA';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '衬衣';
                                                    } else {
                                                        echo 'SH';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '马夹';
                                                    } else {
                                                        echo 'WC';
                                                    }
                                                    ?>
                                                </td>
                                                <td width="<?php
                                                if ($this->langtype == '_ch') {
                                                    echo 60;
                                                } else {
                                                    echo 115;
                                                }
                                                ?>" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '下身';
                                                    } else {
                                                        echo 'LOWER BODY';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;background:#EFEFEF;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '裤子';
                                                    } else {
                                                        echo 'TR';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '衣长';
                                                    } else {
                                                        echo 'LENGTH';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_length_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_length'] != '0' && $orderinfo['ja_length'] != '') {
                                                               echo $orderinfo['ja_length'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_length_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_length'] != '0' && $orderinfo['sh_length'] != '') {
                                                               echo $orderinfo['sh_length'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_length_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" style="width:100%;"
                                                           type="text" value="<?php
                                                    if ($orderinfo['wc_length'] != '0' && $orderinfo['wc_length'] != '') {
                                                        echo $orderinfo['wc_length'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '裤子长';
                                                    } else {
                                                        echo 'LENGTH';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_length_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_length'] != '0' && $orderinfo['tr_length'] != '') {
                                                               echo $orderinfo['tr_length'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '肩宽';
                                                    } else {
                                                        echo 'SHOULDERS';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_shoulders_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_shoulders'] != '0' && $orderinfo['ja_shoulders'] != '') {
                                                               echo $orderinfo['ja_shoulders'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_shoulders_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_shoulders'] != '0' && $orderinfo['sh_shoulders'] != '') {
                                                               echo $orderinfo['sh_shoulders'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_shoulders_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_shoulders'] != '0' && $orderinfo['wc_shoulders'] != '') {
                                                               echo $orderinfo['wc_shoulders'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '裤子腰围';
                                                    } else {
                                                        echo 'WAIST';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_waist_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_waist'] != '0' && $orderinfo['tr_waist'] != '') {
                                                               echo $orderinfo['tr_waist'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '胸围';
                                                    } else {
                                                        echo 'CHEST C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_chest_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_chest'] != '0' && $orderinfo['ja_chest'] != '') {
                                                               echo $orderinfo['ja_chest'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_chest_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_chest'] != '0' && $orderinfo['sh_chest'] != '') {
                                                               echo $orderinfo['sh_chest'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_chest_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_chest'] != '0' && $orderinfo['wc_chest'] != '') {
                                                               echo $orderinfo['wc_chest'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '臀围';
                                                    } else {
                                                        echo 'GLUTEUS';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_gluteus_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_gluteus'] != '0' && $orderinfo['tr_gluteus'] != '') {
                                                               echo $orderinfo['tr_gluteus'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '前胸';
                                                    } else {
                                                        echo 'CHEST FRONT';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_chest_f_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_chest_f'] != '0' && $orderinfo['ja_chest_f'] != '') {
                                                               echo $orderinfo['ja_chest_f'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_chest_f_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_chest_f'] != '0' && $orderinfo['sh_chest_f'] != '') {
                                                               echo $orderinfo['sh_chest_f'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_chest_f_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_chest_f'] != '0' && $orderinfo['wc_chest_f'] != '') {
                                                               echo $orderinfo['wc_chest_f'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '大腿围';
                                                    } else {
                                                        echo 'Back W';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_thigh_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_thigh'] != '0' && $orderinfo['tr_thigh'] != '') {
                                                               echo $orderinfo['tr_thigh'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '后背';
                                                    } else {
                                                        echo 'CHEST BACK';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_chest_b_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_chest_b'] != '0' && $orderinfo['ja_chest_b'] != '') {
                                                               echo $orderinfo['ja_chest_b'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_chest_b_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_chest_b'] != '0' && $orderinfo['sh_chest_b'] != '') {
                                                               echo $orderinfo['sh_chest_b'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_chest_b_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_chest_b'] != '0' && $orderinfo['wc_chest_b'] != '') {
                                                               echo $orderinfo['wc_chest_b'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '直裆长';
                                                    } else {
                                                        echo 'CROTCH RISE';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_crotch_rise_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_crotch_rise'] != '0' && $orderinfo['tr_crotch_rise'] != '') {
                                                               echo $orderinfo['tr_crotch_rise'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '腰围';
                                                    } else {
                                                        echo 'BUST C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_bust_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['ja_bust'] != '0' && $orderinfo['ja_bust'] != '') {
                                                        echo $orderinfo['ja_bust'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_bust_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['sh_bust'] != '0' && $orderinfo['sh_bust'] != '') {
                                                        echo $orderinfo['sh_bust'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_bust_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['wc_bust'] != '0' && $orderinfo['wc_bust'] != '') {
                                                        echo $orderinfo['wc_bust'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <!--                                                     <td style="padding-left:10px;padding-top:10px;"><?php
                                                if ($this->langtype == '_ch') {
                                                    echo '前裆';
                                                } else {
                                                    echo 'Front Crotch';
                                                }
                                                ?></td>                                                    <td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_crotch_front" style="width:100%;" type="text" value="<?php
                                                if ($orderinfo['tr_crotch_front'] != '0' && $orderinfo['tr_crotch_front'] != '') {
                                                    echo $orderinfo['tr_crotch_front'];
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                ?>"/></td>                                                    -->
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '中裆围';
                                                    } else {
                                                        echo 'HAMSTRING';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_hamstring_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_hamstring'] != '0' && $orderinfo['tr_hamstring'] != '') {
                                                               echo $orderinfo['tr_hamstring'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '臀围';
                                                    } else {
                                                        echo 'HIP C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_circumference_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_circumference'] != '0' && $orderinfo['ja_circumference'] != '') {
                                                               echo $orderinfo['ja_circumference'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_circumference_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_circumference'] != '0' && $orderinfo['sh_circumference'] != '') {
                                                               echo $orderinfo['sh_circumference'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_circumference_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_circumference'] != '0' && $orderinfo['wc_circumference'] != '') {
                                                               echo $orderinfo['wc_circumference'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <!--                                                     <td style="padding-left:10px;padding-top:10px;"><?php
                                                if ($this->langtype == '_ch') {
                                                    echo '后裆';
                                                } else {
                                                    echo 'Back Crotch';
                                                }
                                                ?></td>                                                    <td align="center" style="padding-left:10px;padding-top:10px;"><input name="tr_crotch_back" style="width:100%;" type="text" value="<?php
                                                if ($orderinfo['tr_crotch_back'] != '0' && $orderinfo['tr_crotch_back'] != '') {
                                                    echo $orderinfo['tr_crotch_back'];
                                                } else {
                                                    echo '&nbsp;';
                                                }
                                                ?>"/></td>                                                    -->
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '小腿围';
                                                    } else {
                                                        echo 'CALF';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_calf_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['tr_calf'] != '0' && $orderinfo['tr_calf'] != '') {
                                                        echo $orderinfo['tr_calf'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '袖长';
                                                    } else {
                                                        echo 'SLEEVE';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="ja_sleeve_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_sleeve'] != '0' && $orderinfo['ja_sleeve'] != '') {
                                                               echo $orderinfo['ja_sleeve'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="sh_sleeve_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_sleeve'] != '0' && $orderinfo['sh_sleeve'] != '') {
                                                               echo $orderinfo['sh_sleeve'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="wc_sleeve_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_sleeve'] != '0' && $orderinfo['wc_sleeve'] != '') {
                                                               echo $orderinfo['wc_sleeve'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '脚口围';
                                                    } else {
                                                        echo 'ANKLE';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;">
                                                    <input name="tr_ankle_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['tr_ankle'] != '0' && $orderinfo['tr_ankle'] != '') {
                                                               echo $orderinfo['tr_ankle'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '袖肥';
                                                    } else {
                                                        echo 'BICEP C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="ja_bicep_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_bicep'] != '0' && $orderinfo['ja_bicep'] != '') {
                                                               echo $orderinfo['ja_bicep'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="sh_bicep_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_bicep'] != '0' && $orderinfo['sh_bicep'] != '') {
                                                               echo $orderinfo['sh_bicep'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="wc_bicep_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_bicep'] != '0' && $orderinfo['wc_bicep'] != '') {
                                                               echo $orderinfo['wc_bicep'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;"></td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '袖口';
                                                    } else {
                                                        echo 'WRIST C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="ja_wrist_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['ja_wrist'] != '0' && $orderinfo['ja_wrist'] != '') {
                                                               echo $orderinfo['ja_wrist'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="sh_wrist_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['sh_wrist'] != '0' && $orderinfo['sh_wrist'] != '') {
                                                               echo $orderinfo['sh_wrist'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="wc_wrist_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['wc_wrist'] != '0' && $orderinfo['wc_wrist'] != '') {
                                                               echo $orderinfo['wc_wrist'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;"></td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '领围';
                                                    } else {
                                                        echo 'NECK C';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="ja_neck_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['ja_neck'] != '0' && $orderinfo['ja_neck'] != '') {
                                                        echo $orderinfo['ja_neck'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="sh_neck_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['sh_neck'] != '0' && $orderinfo['sh_neck'] != '') {
                                                        echo $orderinfo['sh_neck'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;padding-bottom:10px;">
                                                    <input name="wc_neck_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text" value="<?php
                                                    if ($orderinfo['wc_neck'] != '0' && $orderinfo['wc_neck'] != '') {
                                                        echo $orderinfo['wc_neck'];
                                                    } else {

                                                    }
                                                    ?>"/>
                                                </td>
                                                <td style="padding-left:10px;padding-top:10px;"></td>
                                                <td align="center" style="padding-left:10px;padding-top:10px;"></td>
                                            </tr>
                                        </table>
                                        <?php
                                        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 ORDER BY cms_id ASC";
                                        $cmslist = $this->db->query($sql)->result_array();
                                        ?>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                                            <tr>
                                                <td width="<?php
                                                if ($this->langtype == '_ch') {
                                                    echo 60;
                                                } else {
                                                    echo 115;
                                                }
                                                ?>" style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装编号';
                                                    } else {
                                                        echo 'Suit Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_suit_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_suit'] != '0' && $orderinfo['code_suit'] != '') {
                                                               echo $orderinfo['code_suit'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">

                                                    <select name="code_suit_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select one</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_suit_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_suit_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="<?php
                                                if ($this->langtype == '_ch') {
                                                    echo 60;
                                                } else {
                                                    echo 115;
                                                }
                                                ?>" style="padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '马夹编号';
                                                    } else {
                                                        echo 'Waistcoat Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_waistcoat_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_waistcoat'] != '0' && $orderinfo['code_waistcoat'] != '') {
                                                               echo $orderinfo['code_waistcoat'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_waistcoat_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select one</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_waistcoat_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_waistcoat_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '裤子编号';
                                                    } else {
                                                        echo 'Trousers Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_trousers_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_trousers'] != '0' && $orderinfo['code_trousers'] != '') {
                                                               echo $orderinfo['code_trousers'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_trousers_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select one</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_trousers_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_trousers_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '衬衫编号';
                                                    } else {
                                                        echo 'Shirt Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_shirt_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_shirt'] != '0' && $orderinfo['code_shirt'] != '') {
                                                               echo $orderinfo['code_shirt'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_shirt_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select one</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_shirt_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_shirt_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '大衣编号';
                                                    } else {
                                                        echo 'Overcoat Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_overcoat_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_overcoat'] != '0' && $orderinfo['code_overcoat'] != '') {
                                                               echo $orderinfo['code_overcoat'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_overcoat_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_overcoat_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_overcoat_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装面料';
                                                    } else {
                                                        echo 'Jacket Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_jacket_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_jacket'] != '0' && $orderinfo['code_jacket'] != '') {
                                                               echo $orderinfo['code_jacket'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_jacket_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_jacket_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_jacket_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装面料';
                                                    } else {
                                                        echo 'Shorts Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_shorts_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_shorts'] != '0' && $orderinfo['code_shorts'] != '') {
                                                               echo $orderinfo['code_shorts'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_shorts_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_shorts_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_shorts_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装面料';
                                                    } else {
                                                        echo 'Denim Trousers Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_denim_trousers_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_denim_trousers'] != '0' && $orderinfo['code_denim_trousers'] != '') {
                                                               echo $orderinfo['code_denim_trousers'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_denim_trousers_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_denim_trousers_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_denim_trousers_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装面料';
                                                    } else {
                                                        echo 'Casual Trousers Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_casual_trousers_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;" type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_casual_trousers'] != '0' && $orderinfo['code_casual_trousers'] != '') {
                                                               echo $orderinfo['code_casual_trousers'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_casual_trousers_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_casual_trousers_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_casual_trousers_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '西装面料';
                                                    } else {
                                                        echo 'Flannel Trousers Code';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <input name="code_flannel_trousers_<?php echo $orderinfo['order_list_id'] ?>" style="width:100%;"
                                                           type="text"
                                                           value="<?php
                                                           if ($orderinfo['code_flannel_trousers'] != '0' && $orderinfo['code_flannel_trousers'] != '') {
                                                               echo $orderinfo['code_flannel_trousers'];
                                                           } else {

                                                           }
                                                           ?>"/>
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="code_flannel_trousers_select_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="none">Select One</option>
                                                        <?php
                                                        if (!empty($cmslist)) {
                                                            for ($i = 0; $i < count($cmslist); $i++) {
                                                                if ($cmslist[$i]['cms_name_en'] == $orderinfo['code_flannel_trousers_select'] || $cmslist[$i]['cms_name_ch'] == $orderinfo['code_flannel_trousers_select']) {
                                                                    $isselected = 'selected';
                                                                } else {
                                                                    $isselected = '';
                                                                }
                                                                echo '<option value="' . $cmslist[$i]['cms_name' . $this->langtype] . '" ' . $isselected . '>' . $cmslist[$i]['cms_name' . $this->langtype] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="padding:10px;">
                                                    <?php
                                                    if ($this->langtype == '_ch') {
                                                        echo '状态';
                                                    } else {
                                                        echo 'Status';
                                                    }
                                                    ?>&nbsp;&nbsp;&nbsp;
                                                </td>
                                                <td align="center" style="padding:10px;">
                                                    <select name="status_<?php echo $orderinfo['order_list_id'] ?>">
                                                        <option value="4" <?php if ($orderinfo['status'] == 4) {
                                                            echo 'selected';
                                                        } ?>>
                                                            <?php
                                                            if ($this->langtype == '_ch') {
                                                                echo '进行中';
                                                            } else {
                                                                echo 'Processing';
                                                            }
                                                            ?>
                                                        </option>
                                                        <option value="5" <?php if ($orderinfo['status'] == 5) {
                                                            echo 'selected';
                                                        } ?>>
                                                            <?php
                                                            if ($this->langtype == '_ch') {
                                                                echo '已完成';
                                                            } else {
                                                                echo 'Completed';
                                                            }
                                                            ?>
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <?php //} ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <div style=" float: left;width:99%; margin-top: 10px; margin-bottom: 10px;">
            <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
            <div style="margin-left:450px;" class="gksel_btn_action_on" onclick="tosave_orderinfo(<?php echo $orderinformation['order_id'] ?>)">
                <?php echo lang('cy_save') ?>
            </div>
        </div>
        <input type="hidden" id="count" name="count" value="<?php echo $count; ?>"/>
    </form>
    <script type="text/javascript">
        function tosave_orderinfo(order_id) {
            if (isajaxsaveing == 0) {
                actionsubmit_button = $('div[onclick="tosave_orderinfo(' + order_id + ')"]');
                isajaxsaveing = 1;
                var backurl = $('input[name="backurl"]').val();
                actionsubmit_button.attr('class', 'gksel_btn_action_off');
                actionsubmit_button.html('<img class="icon_loading" src="' + baseurl + 'themes/default/images/ajax_loading.gif"/><span>' + L['cy_saving'] + '...</span>');
                var ispass = 1;
                if (ispass == 1) {
                    $.post(baseurl + 'index.php/admins/order/edit_order/' + order_id, $("#testform").serialize(), function (data) {
                        var obj = eval("(" + data + ")");
                        actionsubmit_button.html('<img class="icon_success" src="' + baseurl + 'themes/default/images/global_ok.png"/><span>' + L['cy_save_success'] + '</span>');
                        //console.log(res)
                        location.href = obj.backurl;
                        // location.reload();
                    })
                } else {
                    actionsubmit_button.attr('class', 'gksel_btn_action_on');
                    actionsubmit_button.html(L['cy_save']);
                    isajaxsaveing = 0;
                }
            }
        }
    </script>
<?php $this->load->view('admin/footer') ?>