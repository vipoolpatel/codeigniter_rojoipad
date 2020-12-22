<?php $this->load->view('admin/header')?>
<script type='text/javascript' src='<?php echo base_url()?>ckeditor/ckeditor.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_setting_email.js?date=<?php echo CACHE_USETIME()?>'></script>
	
<form method="post">
	<table class="gksel_normal_tabpost">
		<tr>
			<td align="right">Parameters</td>
			<td>
				<div style="float:left;border:1px solid #ccc;width:720px;padding:10px 10px 10px 10px;">
					<?php 
					$parameter=$emailinfo['email_parameter'];
					if($parameter!=""){
						$parameter=unserialize($parameter);
					}else{
						$parameter=array();
					}
					if(!empty($parameter)){
						for($i=0;$i<count($parameter);$i++){
							echo '<div style="float:left;width:180px;line-height:30px;">'.$parameter[$i].'</div>';
						}
					}
					?>
					
				</div>
			</td>
		</tr>
		
		<tr>
			<td align="right">From</td>
			<td>
				<input type="text" name="email_from" value="<?php echo $emailinfo['email_from'];?>"/>
				<div class="tipsgroupbox"><div class="request">*</div></div>
			</td>
		</tr>
		<tr>
			<td align="right">Sender</td>
			<td>
				<input type="text" name="email_sender" value="<?php echo $emailinfo['email_sender'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">Reply to </td>
			<td><input type="text" name="email_replyto" id="email_replyto" value="<?php echo $emailinfo['email_replyto'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">To </td>
			<td><input type="text" name="email_to" id="email_to" value="<?php echo $emailinfo['email_to'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">CC </td>
			<td>
				<input type="text" name="email_cc" id="email_cc" value="<?php echo $emailinfo['email_cc'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">BCC </td>
			<td>
				<input type="text" name="email_bcc" id="email_bcc" value="<?php echo $emailinfo['email_bcc'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">Subject (English)</td>
			<td>
				<input type="text" style="width:700px;" name="email_subject_en" value="<?php echo $emailinfo['email_subject_en'];?>"/>
			</td>
		</tr>
		<tr>
			<td align="right">Subject (中文)</td>
			<td>
				<input type="text" style="width:700px;" name="email_subject_ch" value="<?php echo $emailinfo['email_subject_ch'];?>"/>
			</td>
		</tr>
		
		<tr>
			<td align="right" width="150">Content (English)</td>
		    <td align="left">
		    	<div style="float:left;width:800px;">
		    		<textarea name="email_content_en"><?php echo $emailinfo['email_content_en']?></textarea>
		    	</div>
		    	<div class="tipsgroupbox"><div class="request">*</div></div>
		    </td>
	    </tr>
	    <tr>
			<td align="right" width="150">Content (中文)</td>
		    <td align="left">
		    	<div style="float:left;width:800px;">
		    		<textarea name="email_content_ch"><?php echo $emailinfo['email_content_ch']?></textarea>
		    	</div>
		    	<div class="tipsgroupbox"><div class="request">*</div></div>
		    </td>
	    </tr>
		<tr>
			<td>
				<input name="backurl" type="hidden" value="<?php echo $backurl;?>"/>
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="tosave_emailinfo(<?php echo $emailinfo['email_id']?>)"><?php echo lang('cy_save')?></div>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	if(CKEDITOR.instances["email_content_en"]){
		//判断是否绑定
		CKEDITOR.remove(CKEDITOR.instances["email_content_en"]); //解除绑定
	}
	CKEDITOR.replace( 'email_content_en',{
		toolbar :
        [
         [  'Bold',  'Italic', 'Underline',  '-',  'NumberedList',  'BulletedList',  '-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','-','Font', 'FontSize', 'TextColor', 'BGColor','Image', 'Table', 'SpecialChar','-',  'Link',  'Unlink','link_rar','link_xls','link_doc','link_ppt','link_pdf','link_pic' ]]
    });


	if(CKEDITOR.instances["email_content_ch"]){
		//判断是否绑定
		CKEDITOR.remove(CKEDITOR.instances["email_content_ch"]); //解除绑定
	}
	CKEDITOR.replace( 'email_content_ch',{
		toolbar :
        [
         [  'Bold',  'Italic', 'Underline',  '-',  'NumberedList',  'BulletedList',  '-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','-','Font', 'FontSize', 'TextColor', 'BGColor','Image', 'Table', 'SpecialChar','-',  'Link',  'Unlink','link_rar','link_xls','link_doc','link_ppt','link_pdf','link_pic' ]]
    });
</script>
<?php $this->load->view('admin/footer')?>