<?php $this->load->view('admin/header'); ?>
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
    <script type='text/javascript' src='<?php echo base_url()?>themes/default/js/fileuploader.js'></script>
    <table id="customers">
        <tbody>
            <tr>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户编号';                } else {                    echo 'Client#';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <?php echo $orderinformation['newclient_number'] ?>
                </td>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户姓名';                } else {                    echo 'Client Name';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_realname" type="text" value="<?php echo $orderinformation['client_realname'] ?>" />
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户地址';                } else {                    echo 'Client Address';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_address" type="text" value="<?php echo $orderinformation['client_address'] ?>" />
                </td>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户邮箱';                } else {                    echo 'Client Email';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_email" type="text" value="<?php echo $orderinformation['client_email'] ?>" />
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户行业';                } else {                    echo 'Client Industry';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_industry" type="text" value="<?php echo $orderinformation['client_industry'] ?>" />
                </td>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户微信';                } else {                    echo 'Client Wechat';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_wechat" type="text" value="<?php echo $orderinformation['client_wechat'] ?>" />
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户手机号码';                } else {                    echo 'Client Mobile';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_phone" type="text" value="<?php echo $orderinformation['client_phone'] ?>" />
                </td>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户生日';                } else {                    echo 'Client Birthday';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_birthday" type="text" value="<?php echo $orderinformation['client_birthday'] ?>" />
                </td>
            </tr>
            <tr>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '客户国际';                } else {                    echo 'Client Nationality';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <input name="client_nationality" type="text" value="<?php echo $orderinformation['client_nationality'] ?>" />
                </td>
                <td id="td1">
                    <?php                if ($this->langtype == '_ch') {                    echo '订单时间';                } else {                    echo 'Order Time';                }                ?>&nbsp;&nbsp;&nbsp;</td>
                <td id="td2">
                    <?php echo date('Y-m-d H:i:s', $orderinformation['created']) ?>
                </td>
            </tr>
            <tr>
                <td style="padding-top:5px;" align="right">Upload PDF&nbsp;&nbsp;&nbsp;</td>
                <td style="padding-top:5px;">
                    <div class="img_gksel_show" id="img1_gksel_show">
                        <?php $img1_gksel = '';if (file_exists($clientinfo['company_businesslicense']) && $clientinfo['company_businesslicense'] != "") {    $img1_gksel = $clientinfo['company_businesslicense'];    echo '<a target="_blank" href="' . base_url() . $clientinfo['company_businesslicense'] . '">Download</a>';}?> </div>
                    <button class="img_gksel_choose" id="img1_gksel_choose">Upload PDF</button>
                    <div style="float:left;">
                        <input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel; ?>" />
                    </div>
                    <div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;"></font></div>
                </td>
            </tr>
            <tr>
                <td style="padding-top:30px;padding-bottom:30px;" align="right">&nbsp;&nbsp;&nbsp;</td>
                <td style="padding-top:30px;padding-bottom:30px;">
                    <input name="backurl" type="hidden" value="<?php echo $backurl; ?>" />
                    <div class="gksel_btn_action_on" onclick="tosave_orderinfo(<?php echo $orderinformation['order_id'] ?>)">
                        <?php echo lang('cy_save') ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
            function tosave_orderinfo(order_id) {
    if (isajaxsaveing == 0) {
        actionsubmit_button = $('div[onclick="tosave_orderinfo(' + order_id + ')"]');
        isajaxsaveing = 1;
        var backurl = $('input[name="backurl"]').val();
        actionsubmit_button.attr('class', 'gksel_btn_action_off');
        actionsubmit_button.html('<img class="icon_loading" src="' + baseurl + 'themes/default/images/ajax_loading.gif"/><span>' + L['cy_saving'] + '...</span>');
        var client_realname = $('input[name="client_realname"]').val();
        var client_address = $('input[name="client_address"]').val();
        var client_email = $('input[name="client_email"]').val();
        var client_industry = $('input[name="client_industry"]').val();
        var client_wechat = $('input[name="client_wechat"]').val();
        var client_phone = $('input[name="client_phone"]').val();
        var client_birthday = $('input[name="client_birthday"]').val();
        var client_nationality = $('input[name="client_nationality"]').val();
        var img1_gksel = $('input[name="img1_gksel"]').val();
        $.post(baseurl + 'index.php/admins/order/edit_order_databackend/' + order_id, {
            backurl: backurl,
            client_realname: client_realname,
            client_address: client_address,
            client_email: client_email,
            client_industry: client_industry,
            client_wechat: client_wechat,
            client_phone: client_phone,
            client_birthday: client_birthday,
            client_nationality: client_nationality,
            img1_gksel: img1_gksel
        }, function(data) {
            var obj = eval("(" + data + ")");
            actionsubmit_button.html('<img class="icon_success" src="' + baseurl + 'themes/default/images/global_ok.png"/><span>' + L['cy_save_success'] + '</span>');
            location.href = obj.backurl;
        })
    }
}
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var button_gksel1 = $('#img1_gksel_choose'),
                interval;
            if (button_gksel1.length > 0) {
                new AjaxUpload(button_gksel1, {
                    action: baseurl + 'index.php/welcome/upfile',
                    name: 'logo',
                    onSubmit: function(file, ext) {
                        if (ext && /^(pdf)$/.test(ext)) {
                            button_gksel1.text('Uploading');
                            this.disable();
                            interval = window.setInterval(function() {
                                var text = button_gksel1.text();
                                if (text.length < 13) {
                                    button_gksel1.text(text + '.');
                                } else {
                                    button_gksel1.text('Uploading');
                                }
                            }, 200);
                        } else {
                            $('#img1_gksel_error').html('Upload Fail');
                            return false;
                        }
                    },
                    onComplete: function(file, response) {
                        button_gksel1.text('Upload PDF');
                        window.clearInterval(interval);
                        this.enable();
                        if (response == 'false') {
                            $('#img1_gksel_error').html('Upload Fail');
                        } else {
                            var pic = eval("(" + response + ")");
                            $('#img1_gksel_show').html('<a target="_blank" href="' + baseurl + pic.logo + '">Download</a>');
                            $('#img1_gksel').attr('value', pic.logo);
                            $('#img1_gksel_error').html('');
                        }
                    }
                });
            }
        })
    </script>
    <?php $this->load->view('admin/footer') ?>