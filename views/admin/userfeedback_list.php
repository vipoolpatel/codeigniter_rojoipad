<?php $this->load->view('admin/header') ?>

<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME() ?>'></script>

<?php
$get_str = '';
if ($_GET) {
    $arr = geturlparmersGETS();
    for ($i = 0; $i < count($arr); $i++) {
        if (isset($_GET[$arr[$i]])) {
            if ($get_str != "") {
                $get_str .= '&';
            } else {
                $get_str .= '?';
            }
            $get_str .= $arr[$i] . '=' . $_GET[$arr[$i]];
        }
    }
}
$current_url = current_url();
$current_url_encode = str_replace('/', 'slash_tag', base64_encode($current_url . $get_str));

$keyword = $this->input->get('keyword');
?>
<table class="gksel_normal_tablist">
    <thead>
        <tr>
            <td width="50" align="center"><?php echo lang('cy_sn') ?></td>
            <td align="center"><?php echo lang('cy_title') ?></td>
            <td align="center"><p>&nbsp;&nbsp;&nbsp;<?php echo lang('cy_description') ?></p></td>
            
            <td align="center"><p><?php echo lang('cy_admin') ?></p></td>
        </tr>
    </thead>
    <tbody>
<?php if (isset($userfeedbacklist)) {
    for ($i = 0; $i < count($userfeedbacklist); $i++) { ?>
                        
                <tr style="background: #EFEFEF;">
                    <td align="center"><?php echo $i + 1 ?></td>
                    
                    <td align="center">	<?php echo $userfeedbacklist[$i]['fb_subject'];?></td>
                    <td align="center">	<?php echo $userfeedbacklist[$i]['fb_description'];?></td>
					<td align="center">	<?php echo $userfeedbacklist[$i]['fb_email'];?></td>
                </tr>
                        
    <?php }
} ?>
    </tbody>
</table>

<?php
$this->load->view('admin/footer')?>