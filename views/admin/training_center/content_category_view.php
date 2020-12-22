<?php $this->load->view('admin/header') ?>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME() ?>'></script>
    <script type='text/javascript' src='<?php echo base_url() ?>ckeditor/ckeditor.js'></script>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_cms_cms.js?date=<?php echo CACHE_USETIME() ?>'></script>

   

<div class="gksel_navigation"><a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/content_category_list/<?=$sub_category_id?>">Sub Category Content</a> &gt; View Sub Category Content</div>


    <form action="" method="post" enctype="multipart/form-data">
        <table class="gksel_normal_tabpost">
            <?php
               foreach ($getRecord as $valuekey) {
            ?>

            <tr>
               <td align="right" width="150">Tag Name :</td>
                <td align="left">
                    <?=$valuekey->tag_name?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="float: left;width:100%;border-top:1px solid #ccc;margin:15px 0px;"></div>
                </td>
            </tr>

            <?php
               }
            ?>
             
            <tr>
            <td>
             
            </td>
             <td align="left">
                <a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/content_category_list/<?=$sub_category_id?>" class="gksel_btn_action_on" onclick="toadd_cmsinfo();">Back</a>
            </td>
            
        </tr>
    </table>
</form>


    <script type="text/javascript">
  
</script>

<?php
$this->load->view('admin/footer')
?>


               
              
                 
                  
                    
               

            