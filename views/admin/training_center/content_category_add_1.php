<?php $this->load->view('admin/header') ?>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME() ?>'></script>
    <script type='text/javascript' src='<?php echo base_url() ?>ckeditor/ckeditor.js'></script>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_cms_cms.js?date=<?php echo CACHE_USETIME() ?>'></script>

   <style type="text/css">
        .grid-tag-form {
            display: grid;
         /*  grid-template-columns: 50% 50%;*/
            grid-gap: 1%;
            margin-bottom: 7px;
        }

   </style>

<div class="gksel_navigation"><a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/content_category_list/<?=$sub_category_id?>">Sub Category Content</a> &gt; Add Sub Category Content</div>


    <form action="" method="post" enctype="multipart/form-data">
        <table class="gksel_normal_tabpost">
            <tr>
               <td align="right" width="150">Name</td>
                <td align="left">
                    <input type="text" name="content_name" style="width:90%;" required=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>

         <tr>
               <td align="right" width="150">Add Link</td>
                <td align="left">
                    <input type="text" name="add_link" style="width:90%;" required=""/>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
            </tr>
            <tr>
               <td align="right" width="150" valign="top">Description</td>
                <td align="left">
                    
                    <textarea name="description" style="width:90%;" required=""/></textarea>
                    <div class="tipsgroupbox"><div class="request">*</div></div>
                </td>
             </tr>

           <tr>
                <td align="right" width="150">Tags</td>
                <td align="left">
                    <input type="text" name="tag_name[]" style="width:240px;">
                    <div class="tipsgroupbox"><div class="request"></div></div>
                    <button type="button" class="nav_on" id="add_row" style="border: none;" ><img class="plus" src="<?php echo base_url().'themes/default/images/plus.png'?>"/></button>
                </td>

            </tr>
           
            
            <tr>
                <td align="right" width="150"></td>
                <td align="left">
                    <div id="tag_below_row" class="grid-tag-form">
                        
                    </div>
                </td>
            </tr>

             <tr>
            <td width="150" align="right">Status</td>
            <td align="left">
                <div style="float:left;">
                    <input name="status" id="status_1" type="radio" value="Online">
                    <label for="status_1">Online</label>
                </div>
                <div style="float:left;margin-left:10px;">
                    <input name="status" id="status_0" type="radio" value="Offline" checked="">
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


 <script type="text/javascript">
 
    $(document).ready(function() {
    
      var tag_row = 1;
   
      $('body').delegate('#add_row','click',function(){
            var html = '';
             html = '<div style="margin-bottom: 8px;" id="RemoveMainTag'+tag_row+'">\n\
             <input type="text" name="tag_name[]" style="width:240px;">\n\
                 <div class="tipsgroupbox"><div class="request"></div></div>\n\
                 <button style="border: none;"  type="button" class="nav_on RemoveNewTag" id="'+tag_row+'"><img class="plus" src="<?php echo base_url().'themes/default/images/msg_1.png'?>"/></button>\n\
            </div>';
            $("#tag_below_row").append(html);
         tag_row++;
      });
   
      $('body').delegate('.RemoveNewTag','click',function(){
           var id = $(this).attr('id');
           $('#RemoveMainTag'+id).remove();
      });
   
   });

   
</script>

<?php
$this->load->view('admin/footer')
?>


               
               
                    
                  
              
                 
                  
                    
               

            