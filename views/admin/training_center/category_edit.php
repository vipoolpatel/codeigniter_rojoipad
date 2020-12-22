<?php $this->load->view('admin/header') ?>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME() ?>'></script>
    <script type='text/javascript' src='<?php echo base_url() ?>ckeditor/ckeditor.js'></script>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_cms_cms.js?date=<?php echo CACHE_USETIME() ?>'></script>

   

<div class="gksel_navigation"><a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center">Training Center</a> &gt; Edit Category</div>
<div class="gksel_delete_box_bg"></div>
<div class="gksel_delete_box">
    <table>
        <tr>
            <td>
                <div class="gksel_delete_content">
                    <div class="close"><img onclick="toclose_deletebox()" src="<?php echo base_url().'themes/default/images/close.png'?>"></div>
                    <div class="title"></div>
                    <div class="subtitle"></div>
                    <div class="control">
                        <div class="yes" onclick="del()">OK</div>
                        <div class="no" onclick="toclose_deletebox()">Cancel</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div> 
 

    <form action="" method="post" enctype="multipart/form-data">
        <table class="gksel_normal_tabpost">
         <tr>
               <td align="right" width="150">Main Category (English)</td>
                <td align="left">
                    <input type="text" name="main_category_en" style="width:90%;" value="<?=$getRecord->main_category_en?>" required=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
               <td align="right" width="150">Main Category (Chenese)</td>
                <td align="left">
                    <input type="text" name="main_category_ch" style="width:90%;" value="<?=$getRecord->main_category_en?>" required=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
             </tr>
            <tr>
                    <td align="right" valign="top">Menu Icon</td>
                    <td>
                     <input type="file" class="img_gksel_choose" name="menu_icon" >
                      <?php
                       if(!empty($getRecord->menu_icon))
                       {
                       ?>
                       <br /><br /><br />
                       <img style="width: 100px;height: 100px;" src="<?php echo str_replace('rojoipad/', '', base_url()) ?>/rojoipad/upload/<?=$getRecord->menu_icon?>">
                    <?php }
                    ?>
                    <input type="hidden" name="old_menu_icon" value="<?=$getRecord->menu_icon?>">
                     </td>
                </tr>
             <tr>
            <td width="150" align="right">Status</td>
            <td align="left">
                <div style="float:left;">
                    <input name="status" id="status_1" type="radio" <?=($getRecord->status == 'Online') ? 'checked' : ''?> value="Online">
                    <label for="status_1">Online</label>
                </div>
                <div style="float:left;margin-left:10px;">
                    <input name="status" id="status_0" type="radio" <?=($getRecord->status == 'Offline') ? 'checked' : ''?> value="Offline">
                    <label for="status_0">Offline</label>
                </div>
            </td>
        </tr>
             <tr>
                <td colspan="2">
                    <div style="float: left;width:100%;border-top:1px solid #ccc;margin:15px 0px;"></div>
                </td>
            </tr>
            <tr>
            <td>
             
            </td>
            <td align="left">
                <button class="gksel_btn_action_on" onclick="toadd_cmsinfo();"><?php echo lang('cy_save') ?></button>
            </td>
        </tr>
    </table>
</form>
<?php
$this->load->view('admin/footer')?>