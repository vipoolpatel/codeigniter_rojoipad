<?php $this->load->view('admin/header') ?>
<script type='text/javascript' src='<?php echo base_url() ?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME() ?>'></script>
<script type="text/javascript">
//商品分类---保存
    function tosave_designinfo(parent, category_id) {
        if (isajaxsaveing == 0) {
            //具体点击的按钮
            actionsubmit_button = $('#dosave');
            //ajax正在保存中
            isajaxsaveing = 1;
            //返回url
            var backurl = $('input[name="backurl"]').val();
            var subbackurl = $('input[name="subbackurl"]').val();
            var thirdbackurl = $('input[name="thirdbackurl"]').val();
            //将提交按钮设置为保存中
            actionsubmit_button.attr('class', 'gksel_btn_action_off');
            actionsubmit_button.html('<img class="icon_loading" src="' + baseurl + 'themes/default/images/ajax_loading.gif"/><span>' + L['cy_saving'] + '...</span>');

            //商品分类信息
            var design_name_en = $('input[name="design_name_en"]').val();
            var design_name_ch = $('input[name="design_name_ch"]').val();
            var input_title_en = $('input[name="input_title_en"]').val();
            var input_title_ch = $('input[name="input_title_ch"]').val();
            var parent_design = $('select[name="design_cat"]').val();
            var design_type = $('select[name="design_type"]').val();
            var sort = $('input[name="sort"]').val();
//            var design_info = $('textarea[name="design_info"]').val();
            var img1_gksel = $('input[name="img1_gksel"]').val();

            var ispass = 1;
            if (ispass == 1) {
                $.post(baseurl + 'index.php/admins/product/add_design/' + parent + '/' + category_id, {
                    //返回url
                    backurl: backurl,
                    subbackurl: subbackurl,
                    thirdbackurl: thirdbackurl,
                    //商品分类信息
                    design_name_en: design_name_en,
                    design_name_ch: design_name_ch,
                    input_title_en: input_title_en,
                    input_title_ch: input_title_ch,
                    parent_design: parent_design,
                    design_type: design_type,
                    sort: sort,
//                    design_info: design_info,
                    img1_gksel: img1_gksel

                }, function (data) {
                    var obj = eval("(" + data + ")");
                    actionsubmit_button.html('<img class="icon_success" src="' + baseurl + 'themes/default/images/global_ok.png"/><span>' + L['cy_save_success'] + '</span>');
                    location.href = obj.thirdbackurl;
                });
            } else {
                actionsubmit_button.attr('class', 'gksel_btn_action_on');
                actionsubmit_button.html(L['cy_save']);
                isajaxsaveing = 0;//ajax正在保存中 --- 释放
            }
        }
    }
</script>
<form method="post">
    <table class="gksel_normal_tabpost">
        <tr>
            <td align="right">Picture</td>
            <td>
                <script>
                    function toviewproductoriginal(path) {
                        $('#img1_gksel_show').html('<img style="float:left;max-width:400px;max-height:400px;" src="' + baseurl + path + '" />');
                    }
                </script>
                <div class="img_gksel_choose" id="img1_gksel_choose">上传图片</div>
                <div style="float:left;"><input type="hidden" id="img1_gksel" name="img1_gksel"/></div>
                <div style="float:left;margin-left:5px;margin-top:5px;"><font class="fonterror" id="img1_gksel_error"><font style="color:gray;">仅支持 Jpg, Png, Gif (800px * 800px)</font></div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150">Category</td>
            <td align="left">
                <select name="design_cat">
                    <option value="0" >None</option>
                <?php
                    foreach($designlist as $design){
                        echo '<option value="'. $design['design_id'] .'"> ' . $design['design_name_en'] . " | ". $design['design_name_ch'] . "</option>";
                    }
                ?>
                </select>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150">Type</td>
            <td align="left">
                <select name="design_type">
                    <option value="1">Text + Image</option>
                    <option value="2">Text + Image + Custom Text</option>
                    <option value="3">Custom Text</option>
                    <option value="4">Text + Image + popup</option>
                    <option value="5">Text + Image + Custom Text + Pop Up Menu</option>
                    <option value="6">Text + Checkbox + Small Image + Custom text entry space</option>
                    <option value="7">Text + Checkbox</option>
                </select>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150"><?php if ($this->langtype == '_ch') {
                        echo '名称';
                } else {
                    echo 'Name';
                } ?> (English)
            </td>
            <td align="left">
                <input type="text" name="design_name_en" required/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150"><?php if ($this->langtype == '_ch') {
                    echo '名称';
                } else {
                    echo 'Name';
                } ?> (中文)
            </td>
            <td align="left">
                <input type="text" name="design_name_ch" required/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr class="custom-input" style="display:none;">
            <td align="right" width="150"><?php if ($this->langtype == '_ch') {
                    echo '自定义输入标题';
                } else {
                    echo 'Custom input title';
                } ?> (English)
            </td>
            <td align="left">
                <input type="text" name="input_title_en" required/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr class="custom-input" style="display:none;">
            <td align="right" width="150"><?php if ($this->langtype == '_ch') {
                    echo '自定义输入标题';
                } else {
                    echo 'Custom input title';
                } ?> (中文)
            </td>
            <td align="left">
                <input type="text" name="input_title_ch" required/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150">Sort</td>
            <td align="left">
                <input type="text" name="sort" value="1"/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
                <input name="subbackurl" type="hidden" value="<?php echo $subbackurl; ?>"/>
                <input name="thirdbackurl" type="hidden" value="<?php echo $thirdbackurl; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" id="dosave" onclick="tosave_designinfo(<?php echo $parent ?>, <?php echo $category_id ?>, <?php //echo $designinfo['design_id'] ?>)"><?php echo lang('cy_save') ?></div>
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
                        $('#img1_gksel_show').html('<img style="float:left;max-width:200px;max-height:200px;" src="' + baseurl + pic.logo + '" />');
                        $('#img1_gksel').attr('value', pic.logo);
                        $('#img1_gksel_error').html('');
                    }
                }
            });
        }
    });
    /*$('select[name=design_type]').on('change', function (){
        if ($(this).val()==6){
            $('.custom-input').show();
        }else{
            $('.custom-input').hide();
        }
    });*/
</script>
<?php
$this->load->view('admin/footer')?>