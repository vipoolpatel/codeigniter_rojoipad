<?php $this->load->view('admin/header')?>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<form method="post">
	<table class="gksel_normal_tabpost">
		<tr>
			<td align="right" width="150"><?php echo lang('dz_product_category_name')?> (English)</td>
			<td align="left">
				<input type="text" name="category_name_en" value="<?php echo $categoryinfo['category_name_en']?>"/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150"><?php echo lang('dz_product_category_name') ?> (中文)</td>
            <td align="left">
                <input type="text" name="category_name_ch" value="<?php echo $categoryinfo['category_name_ch'] ?>"/>
                <div class="tipsgroupbox">
                    <div class="request">*</div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right" width="150"><?php echo lang('cy_status') ?></td>
            <td align="left">
                <div style="float:left;">
                    <input name="status" id="status_1" type="radio" value="1" <?php if ($categoryinfo['status'] == 1) {
                        echo 'checked';
                    } ?>/>
                    <label for="status_1"><?php echo lang('cy_online') ?></label>
                </div>
                <div style="float:left;margin-left:10px;">
                    <input name="status" id="status_0" type="radio" value="0" <?php if ($categoryinfo['status'] == 0) {
                        echo 'checked';
                    } ?>/>
                    <label for="status_0"><?php echo lang('cy_offline') ?></label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on"
                     onclick="tosave_productsubcategoryinfo(<?php echo $parent ?>, <?php echo $categoryinfo['category_id'] ?>)"><?php echo lang('cy_save') ?></div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var button_gksel1 = $('#img1_gksel_choose'), interval;
	if(button_gksel1.length>0){
		new AjaxUpload(button_gksel1,{
			action: baseurl+'index.php/welcome/uplogo/800/800', 
			name: 'logo',onSubmit : function(file, ext){
				if (ext && /^(jpg|png|gif)$/.test(ext)){
					button_gksel1.text('上传中');
					this.disable();
					interval = window.setInterval(function(){
						var text = button_gksel1.text();
						if (text.length < 13){
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
			onComplete: function(file, response){
				button_gksel1.text('上传图片');						
				window.clearInterval(interval);
				this.enable();
				if(response=='false'){
					$('#img1_gksel_error').html('上传失败');
				}else{
					var pic = eval("("+response+")");
					$('#img1_gksel_show').html('<img style="float:left;max-width:400px;max-height:400px;" src="'+baseurl+pic.logo+'" />');
					$('#img1_gksel').attr('value',pic.logo);
					$('#img1_gksel_error').html('');
				}	
			}
		});
	}
})
</script>
<?php $this->load->view('admin/footer')?>