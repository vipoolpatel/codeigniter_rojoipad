<?php $this->load->view('admin/header') ?>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME() ?>'></script>
    <script type='text/javascript' src='<?php echo base_url() ?>ckeditor/ckeditor.js'></script>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_cms_cms.js?date=<?php echo CACHE_USETIME() ?>'></script>
<?php $lancodelist = getlancodelist(); ?>
    <form id="form_cms_add" method="post">
        <table class="gksel_normal_tabpost">
            <?php for ($lc = 0; $lc < count($lancodelist); $lc++) { ?>
                <?php
                $this->lang->load('gksel', $lancodelist[$lc]['langfolder']);
                ?>
                <tr>
                <td align="right" width="150"><?php echo lang('cy_name') ?> <?php if (count($lancodelist) != 1) {
            echo '(' . $lancodelist[$lc]['langname'] . ')';
        } ?></td>
                <td align="left">
                    <input type="text" name="cms_name<?php echo $lancodelist[$lc]['langtype'] ?>" style="width:300px;" value=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>

                    <input type="hidden" name="parent" style="width:300px;" value="<?= ($parentid > 0) ? $parentid : '0'; ?>"/>
                    <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
                </td>
            </tr>
            <tr style="display:none;">
                <td align="right"><?php echo lang('cy_description') ?> <?php if (count($lancodelist) != 1) {
            echo '(' . $lancodelist[$lc]['langname'] . ')';
        } ?></td>
                <td align="left">
                    <div style="float:left;width:800px;">
                        <textarea id="cms_description<?php echo $lancodelist[$lc]['langtype'] ?>" name="cms_description<?php echo $lancodelist[$lc]['langtype'] ?>"></textarea>
                    </div>
                    <div class="tipsgroupbox"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="float: left;width:100%;border-top:1px solid #ccc;margin:15px 0px;"></div>
                </td>
            </tr>
<?php } ?>
        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" onclick="toadd_cmsinfo();"><?php echo lang('cy_save') ?></div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
<?php for ($lc = 0; $lc < count($lancodelist); $lc++) { ?>
        if (CKEDITOR.instances["cms_description<?php echo $lancodelist[$lc]['langtype'] ?>"]) {
            //判断是否绑定
            CKEDITOR.remove(CKEDITOR.instances["cms_description<?php echo $lancodelist[$lc]['langtype'] ?>"]); //解除绑定
        }
        CKEDITOR.replace('cms_description<?php echo $lancodelist[$lc]['langtype'] ?>', {
            toolbar:
                    [
                        ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Font', 'FontSize', 'lineheight', 'TextColor', 'BGColor', 'Image', 'Table', 'SpecialChar', '-', 'Link', 'Unlink', 'link_rar', 'link_xls', 'link_doc', 'link_ppt', 'link_pdf', 'link_pic']]
        });
<?php } ?>
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var button_gksel1 = $('#img1_gksel_choose'), interval;
        if (button_gksel1.length > 0) {
            new AjaxUpload(button_gksel1, {
                action: baseurl + 'index.php/welcome/uplogo/800/800',
                name: 'logo', onSubmit: function (file, ext) {
                    if (ext && /^(jpg|png|gif)$/.test(ext)) {
                        button_gksel1.text('上传中');
                        this.disable();
                        interval = window.setInterval(function () {
                            var text = button_gksel1.text();
                            if (text.length < 13) {
                                button_gksel1.text(text + '.');
                            } else {
                                button_gksel1.text('上传中');
                            }
                        }, 200);
                    } else {
                        $('#img1_gksel_error').html('上传失败');
                        return false;
                    }
                },
                onComplete: function (file, response) {
                    button_gksel1.text('上传图片');
                    window.clearInterval(interval);
                    this.enable();
                    if (response == 'false') {
                        $('#img1_gksel_error').html('上传失败');
                    } else {
                        var pic = eval("(" + response + ")");
                        $('#img1_gksel_show').html('<img style="float:left;max-width:400px;max-height:400px;" src="' + baseurl + pic.logo + '" />');
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