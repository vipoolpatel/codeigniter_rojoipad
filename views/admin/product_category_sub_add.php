<?php $this->load->view('admin/header') ?>
    <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME() ?>'></script>
    <form method="post">
        <table class="gksel_normal_tabpost">
            <tr>
                <td align="right" width="150"><?php echo lang('dz_product_category_name') ?> (English)</td>
                <td align="left"><input type="text" name="category_name_en" value=""/>
                    <div class="tipsgroupbox">
                        <div class="request">*</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('dz_product_category_name') ?> (中文)</td>
                <td align="left"><input type="text" name="category_name_ch" value=""/>
                    <div class="tipsgroupbox">
                        <div class="request">*</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right" width="150"><?php echo lang('cy_status') ?></td>
                <td align="left">
                    <div style="float:left;">
                        <input name="status" id="status_1" type="radio" value="1"/>
                        <label for="status_1"><?php echo lang('cy_online') ?></label>
                    </div>
                    <div style="float:left;margin-left:10px;">
                        <input name="status" id="status_0" type="radio" value="0"/>
                        <label for="status_0"><?php echo lang('cy_offline') ?></label>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input name="backurl" type="hidden" value="<?php echo $backurl ?>"/> <input name="subbackurl" type="hidden"
                                                                                                value="<?php echo $subbackurl ?>"/></td>
                <td align="left">
                    <div class="gksel_btn_action_on" onclick="toadd_productsubcategoryinfo(<?php echo $parent; ?>)"><?php echo lang('cy_save') ?></div>
                </td>
            </tr>
        </table>
    </form><?php $this->load->view('admin/footer') ?>