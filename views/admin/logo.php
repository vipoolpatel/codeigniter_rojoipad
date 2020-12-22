<?php $this->load->view('admin/subheader') ?>
<script type='text/javascript' src='<?php echo base_url() ?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME() ?>'></script>

<form method="post">
    <table class="gksel_normal_tabpost">
        <tr><td colspan="4" style="font-weight: bold; font-size: 20px;"><center><?php echo lang('logo_cap') ?></center></td></tr>
    <tr>
        <td style="padding-top:5px;" align="right"><?php
            if ($this->langtype == '_ch') {
                echo '上傳品牌徽標';
            } else {
                echo 'Upload Brand Logo';
            }
            ?>&nbsp;&nbsp;&nbsp;</td>
        <td style="padding-top:5px;">
                <div class="img_gksel_show" id="img1_gksel_show">
                        <?php 
                                $img1_gksel = '';
                                
                                if($userinfo['user_brand_logo'] != ''){
                                    echo '<img src='. base_url().$userinfo['user_brand_logo'].'></img>';
                                }
                        ?>
                </div>
                <div class="img_gksel_choose" id="img1_gksel_choose"><?php
            if ($this->langtype == '_ch') {
                echo '上傳品牌徽標';
            } else {
                echo 'Upload Brand Logo';
            }
            ?></div>
                <div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel" value="<?php echo $img1_gksel;?>"/></div>
                <div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;"></font></div>
        </td>
    </tr>
        
        <tr><td colspan="2"></td></tr>

        <tr>
            <td align="right">
                <?php
                    if ($this->langtype == '_ch') {
                        echo '插入品牌名稱';
                    } else {
                        echo 'Insert Brand Name';
                    }
                    ?>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <input name="user_brandname" id="user_brandname" type="text" value="<?php echo $userinfo['user_brandname'] ?>" />
            </td>
        </tr>
        
        <tr>
            <td align="right">
                <?php
                    if ($this->langtype == '_ch') {
                        echo '插入品牌縮寫';
                    } else {
                        echo 'Insert Brand Initials';
                    }
                    ?>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <input name="user_brand_initials" id="user_brand_initials" type="text" value="<?php echo $userinfo['user_brand_initials'] ?>" />
            </td>
        </tr>
        
        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" onclick="toupdate_user_logo(<?php echo $userinfo['uid'] ?>, <?php echo $userinfo['user_type'] ?>)"><?php echo lang('cy_save') ?></div>
            </td>
        </tr>
        
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        var button_gksel1 = $('#img1_gksel_choose'), interval;
        if (button_gksel1.length > 0) {
            new AjaxUpload(button_gksel1, {
                action: baseurl + 'index.php/welcome/uplogo',
                name: 'logo', onSubmit: function (file, ext) {
                    if (ext && /^(jpg|png|jpeg|gif|bmp)$/.test(ext)) {
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
                    button_gksel1.text('Upload Brand Logo');
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