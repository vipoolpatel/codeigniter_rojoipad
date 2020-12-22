<?php $this->load->view('admin/header') ?>
<script type='text/javascript' src='<?php echo base_url() ?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME() ?>'></script>

<form method="post">
    <table class="gksel_normal_tabpost">
        <tr><td colspan="4" style="font-weight: bold; font-size: 20px;"><center><?php //echo lang('language_cap') ?></center></td></tr>
        <tr>
            <td align="right" width="150">User<?php //echo lang('cy_language') ?></td>
            <td align="left">
                <select id="userid" name="userid" class="select_userlang">
                <?php
                for($i=0;$i<count($userinfo);$i++){
                ?>
                    <option value="<?php echo $userinfo[$i]['uid']?>"><?php echo $userinfo[$i]['user_realname']?></option>
                <?php    
                }
                ?>    
                </select>
            </td>
        </tr>
        <tr>
                <td align="right" width="150">Amount</td>
                <td align="left">
                    <input type="text" name="amount" id="amount" value=""/>
                </td>
            </tr>
            
            <tr>
                <td align="right" width="150">Comment</td>
                <td align="left">
                    <textarea type="text" name="comment" id="comment" value=""></textarea>
                </td>
            </tr>
        <tr><td colspan="2"></td></tr>

        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" onclick="add_wallet()"><?php echo lang('cy_save') ?></div>
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