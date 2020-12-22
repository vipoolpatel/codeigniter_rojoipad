<?php
   $user_id = $this->session->userdata('user_id');
   if($user_id > 0){
       $this->load->view('admin/subheader');
   }else{
       $this->load->view('admin/header');
   
   }
           ?>

<style type="text/css">
   .gksel_normal_tablist thead tr td {
         padding: 10px;
   }   

   .reset_button {
    float: left;
    height: 35px;
    line-height: 35px;
    background: #111d35;
    border: none;
    border-radius: 3px;
    color: #fff;
    text-align: center;
    padding: 0px 20px;
    cursor: pointer;
    margin-right: 10px;
    font-weight: normal;
}
</style>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME()?>'></script>
<table class="gksel_normal_tabaction">
   <tr>
      <td>
         <h1>Training Center</h1>
         <h2>Main Category</h2>
      </td>
      <td>
         <div class="searcharea">
            <form action="" method="get">
               <input type="text" name="keyword" placeholder="Please enter keyword" value="<?=!empty($this->input->get('keyword')) ? $this->input->get('keyword') : ''?>">
               <input type="submit" value="Search">
               <a class="reset_button" href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/index">Reset</a>
            </form>
         </div>
      </td>
   </tr>
</table>
<table class="gksel_normal_tabaction">
   <tr>
      <td>
         <div class="searcharea">
            <a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/category_add"><font class="nav_on"><img class="plus" src="<?php echo base_url().'themes/default/images/plus.png'?>"/></font></a>
         </div>
      </td>
   </tr>
</table>
<table class="gksel_normal_tablist" >
   <thead>
      <tr>
         <td>#</td>
         <td>Main Category (English)</td>
         <td>Main Category (Chenese)</td>
         <td>Menu Icon</td>
         <td>Status</td>
         <td>Created Date</td>
         <td>Action</td>
      </tr>
   </thead>
   <tbody>

      <?php 
   if(!empty($getRecord))
   {
foreach ($getRecord as $value) {
       ?>
      <tr>
            <td><?=$value->id?></td>
            <td><?=$value->main_category_en?></td>
            <td><?=$value->main_category_ch?></td>
            <td>
               <?php
               if(!empty($value->menu_icon))
               {
               ?>
               <img style="width: 100px;height: 100px;" src="<?php echo str_replace('rojoipad/', '', base_url()) ?>/rojoipad/upload/<?=$value->menu_icon?>">
            <?php }
            ?>
            </td>
            <td><?=$value->status?></td>
            <td><?=date('Y-m-d', strtotime($value->created_date))?></td>
            <td style="margin-bottom: 10px;">
               <a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/category_edit/<?=$value->id?>" class="gksel_btn_action_on">Edit</a>
               <a onclick="return confirm('Are you sure you want to delete?')" href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/category_delete/<?=$value->id?>" class="gksel_btn_action_on">Delete</a>
               <a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/sub_category/<?=$value->id?>" class="gksel_btn_action_on">Add Sub-Category</a>
            </td>


      </tr>
        
      <?php }
      }
      else
      {
          ?>

          <tr>
             <td colspan="100%">Record not found.</td>
          </tr>
          <?php
      }
      ?>
     
   </tbody>

   

   
</table>
<?php $this->load->view('admin/footer')?>
