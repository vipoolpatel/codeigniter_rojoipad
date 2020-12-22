<?php $this->load->view('admin/header') ?>
<script type='text/javascript' src='<?php echo base_url() ?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME() ?>'></script>
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
<form method="post">
    <table class="gksel_normal_tabpost">
        <?php if ($user_type == 1) { ?>
            <tr style="display:none;">
                <td align="right" width="150"><?php echo lang('dz_user_nickname') ?></td>
                <td align="left">
                    <input type="text" name="user_nickname" value=""/>
                </td>
            </tr>
            <tr>
                <td align="right" width="150">Login ID</td>
                <td align="left">
                    <input type="text" name="user_number" value=""/>
                </td>
            </tr>
            <tr>
                <td align="right" width="150">Username</td>
                <td align="left">
                    <input type="text" name="user_realname" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>

            <tr>
                <td align="right" width="150">Brand Name</td>
                <td align="left">
                    <input type="text" name="user_brandname" required value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>

            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_sex') ?></td>
                <td align="left">
                    <select name="user_sex" class="select_usersex">
                        <option value="0"><?php echo lang('dz_user_sex_unknown') ?></option>
                        <option value="1"><?php echo lang('dz_user_sex_male') ?></option>
                        <option value="2"><?php echo lang('dz_user_sex_female') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_phone') ?></td>
                <td align="left">
                    <input type="text" name="user_phone" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right"><?php echo lang('dz_user_password') ?></td>
                <td align="left">
                    <input type="text" onfocus="this.type = 'password'" name="password" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_email') ?></td>
                <td align="left">
                    <input type="text" name="user_email" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_profile') ?></td>
                <td align="left">
                    <textarea name="user_profile"></textarea>
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr class="thead" style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_information') ?></td>
                <td align="left">
                </td>
            </tr>
            <tr style="display: none;"><td colspan="2"></td></tr>
            <tr style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_name') ?></td>
                <td align="left">
                    <input type="text" name="company_name" value=""/>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_title') ?></td>
                <td align="left">
                    <input type="text" name="company_title" value=""/>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_email') ?></td>
                <td align="left">
                    <input type="text" name="company_email" value=""/>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_address') ?></td>
                <td align="left">
                    <input type="text" name="company_address" value=""/>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr style="display: none;">
                <td align="right" width="150"><?php echo lang('dz_company_tel') ?></td>
                <td align="left">
                    <input type="text" name="company_phone" value=""/>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr>
                <td align="right">Upload PDF</td>
                <td>
                    <div class="img_gksel_show" id="img1_gksel_show">
                        <?php
                        $img1_gksel = '';
                        ?>
                    </div>
                    <div class="img_gksel_choose" id="img1_gksel_choose">Upload PDF</div>
                    <div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel; ?>"/></div>
                    <div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;"></font></div>
                </td>
            </tr>
        <?php } else if ($user_type == 2) { ?>
            <tr class="thead">
                <td align="right" width="150"><?php echo lang('dz_company_information') ?></td>
                <td align="left">
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr>
                <td align="right"><?php echo lang('dz_company_businesslicense') ?></td>
                <td>
                    <div class="img_gksel_show" id="img1_gksel_show">
                        <?php
                        $img1_gksel = '';
                        ?>
                    </div>
                    <div class="img_gksel_choose" id="img1_gksel_choose">上传图片</div>
                    <div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel; ?>"/></div>
                    <div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;">仅支持 Jpg, Png, Gif 格式</font></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_company_name') ?></td>
                <td align="left">
                    <input type="text" name="company_name" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_company_title') ?></td>
                <td align="left">
                    <input type="text" name="company_title"/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_company_email') ?></td>
                <td align="left">
                    <input type="text" name="company_email" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_company_address') ?></td>
                <td align="left">
                    <input type="text" name="company_address" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_company_tel') ?></td>
                <td align="left">
                    <input type="text" name="company_phone" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr class="thead">
                <td align="right" width="150">注册人信息</td>
                <td align="left">
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_nickname') ?></td>
                <td align="left">
                    <input type="text" name="user_nickname" value=""/>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_realname') ?></td>
                <td align="left">
                    <input type="text" name="user_realname" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_phone') ?></td>
                <td align="left">
                    <input type="text" name="user_phone" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right"><?php echo lang('dz_user_password') ?></td>
                <td align="left">
                    <input type="text" onfocus="this.type = 'password'" name="password" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_email') ?></td>
                <td align="left">
                    <input type="text" name="user_email" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
        <?php } else if ($user_type == 3) { ?>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_nickname') ?></td>
                <td align="left">
                    <input type="text" name="user_nickname" value=""/>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_realname') ?></td>
                <td align="left">
                    <input type="text" name="user_realname" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_phone') ?></td>
                <td align="left">
                    <input type="text" name="user_phone" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right"><?php echo lang('dz_user_password') ?></td>
                <td align="left">
                    <input type="text" onfocus="this.type = 'password'" name="password" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_user_email') ?></td>
                <td align="left">
                    <input type="text" name="user_email" value=""/>
                    <div class="tipsgroupbox"><div class="request"></div></div>
                </td>
            </tr>
            <tr><td colspan="2"></td></tr>
        <?php } ?>

        <tr>
            <td colspan="6">
                <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                    <table id="customers1" style="width:100%;">
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
                            $categorylist = $this->db->query($sql)->result_array();
                            for ($c = 0; $c < count($categorylist); $c++) {
                                echo '<tr>';
                                if ($this->langtype == '_ch') {
                                    echo '<td><b>' . $categorylist[$c]['category_name_ch'] . '</b></td>';
                                } else {
                                    echo '<td><b>' . $categorylist[$c]['category_name_en'] . '</b></td>';
                                }
                                $sql1 = "SELECT * FROM " . DB_PRE() . "category_design WHERE parent=0 and category_id=" . $categorylist[$c]['category_id'] . " order by sort asc";
                                $subcategorylist = $this->db->query($sql1)->result_array();
                                /* echo '<pre>';
                                  print_r($subcategorylist);
                                  exit; */
                                ?>
                                <tr>
                                    <td>
                                        <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                                            <table style="width:96%;">
                                                <?php
                                                for ($d = 0; $d < count($subcategorylist); $d++) {
                                                    echo '<tr>';
                                                    if ($this->langtype == '_ch') {
                                                        echo '<td><b>' . $subcategorylist[$d]['design_name_ch'] . '</b></td>';
                                                    } else {
                                                        echo '<td><b>' . $subcategorylist[$d]['design_name_en'] . '</b></td>';
                                                    }
                                                    echo '</tr>';

                                                    $sql2 = "SELECT * FROM " . DB_PRE() . "category_design WHERE parent=" . $subcategorylist[$d]['design_id'] . " and category_id=" . $categorylist[$c]['category_id'] . " order by sort asc";
                                                    $designlist = $this->db->query($sql2)->result_array();
                                                    /*echo '<pre>';
                                                    print_r($designlist);
                                                    exit;*/
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                                                                <table style="width:100%; ">
                                                                    <?php
                                                                    for ($a = 0; $a < count($designlist); $a++) {
                                                                        echo '<tr >';
                                                                        if ($this->langtype == '_ch') {
                                                                            echo '<td style="width:25%!important; float:left;"><b>' . $designlist[$a]['design_name_ch'] . '</b></td>';
                                                                        } else {
                                                                            echo '<td style="width:25%!important; float:left;"><b>' . $designlist[$a]['design_name_en'] . '</b></td>';
                                                                        }
                                                                        echo '<td style="width:25%!important; float:left;"><img style="float:left;max-width:40px;max-height:40px;" src="' . base_url() . $designlist[$a]['design_pic'] . '"/></td>';
                                                                        echo '<td style="width:15%!important; float:left;">Points : </td>';
                                                                        echo '<td style="width:15%!important; float:left;"><input type="text" name="points[]" value=""/>'
                                                                        . '<input type="hidden" name="category[]" value="'.$designlist[$a]['category_id'].'"/>'
                                                                        . '<input type="hidden" name="design[]" value="'.$designlist[$a]['design_id'].'"/>'
                                                                        . '</td>';
                                                                        
                                                                        echo '</tr>';
                                                                        echo  '<tr><td><hr></hr></td></tr>';
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>    
                                                    <?php
                                                }
                                                ?>


                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </td>    
        </tr>        
        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" onclick="toadd_userinfo(<?php echo $user_type ?>)"><?php echo lang('cy_save') ?></div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        var button_gksel1 = $('#img1_gksel_choose'), interval;
        if (button_gksel1.length > 0) {
            new AjaxUpload(button_gksel1, {
                action: baseurl + 'index.php/welcome/upfile',
                name: 'logo', onSubmit: function (file, ext) {
                    if (ext && /^(pdf)$/.test(ext)) {
                        button_gksel1.text('Uploading');
                        this.disable();
                        interval = window.setInterval(function () {
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
                onComplete: function (file, response) {
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
<?php
$this->load->view('admin/footer')?>