<?php $this->load->view('admin/subheader') ?>
<script type='text/javascript' src='<?php echo base_url() ?>themes/default/js/fileuploader.js'></script>
<script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_user.js?date=<?php echo CACHE_USETIME() ?>'></script>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 99%;
        margin-top: 60px;
    }

    #customers input {
        width: 80%;
    }

    customers th {
        border: 1px solid #ddd;
        padding: 8px;
        width: 23%;
    }

    #td1 {
        border: 1px solid #ddd;
        padding: 8px;
        width: 10%;
    }

    #td2 {
        border: 1px solid #ddd;
        padding: 8px;
        width: 35%;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    #customers1 {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        float: left;
    }

    #customers1 td,
    #customers1 th {
        padding: 8px;
    }

    #customers1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
<form method="post">
    <?php
//if ($count > 0) {
    ?>
    <table id="customers1">
        <tr>
            <td colspan="6">
                <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                    <table id="customers1" style="width:100%;">
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
                            $categorylist = $this->db->query($sql)->result_array();
                            for ($c = 0; $c < count($categorylist); $c++) {
                                echo '<tr>';
                                if ($this->langtype == '_ch') {
                                    echo '<td><b>' . $categorylist[$c]['category_name_ch'] . '</b></td>';
                                } else {
                                    echo '<td><b>' . $categorylist[$c]['category_name_en'] . '</b></td>';
                                }
                                $sql1 = "SELECT * FROM " . DB_PRE() . "category_design WHERE parent=0 and category_id=" . $categorylist[$c]['category_id'] . " order by sort asc";
                                $subcategorylist = $this->db->query($sql1)->result_array();
                                /* echo '<pre>';
                                  print_r($subcategorylist);
                                  exit; */
                                ?>
                                <tr>
                                    <td>
                                        <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                                            <table style="width:96%;">
                                                <?php
                                                for ($d = 0; $d < count($subcategorylist); $d++) {
                                                    echo '<tr>';
                                                    if ($this->langtype == '_ch') {
                                                        echo '<td><b>' . $subcategorylist[$d]['design_name_ch'] . '</b></td>';
                                                    } else {
                                                        echo '<td><b>' . $subcategorylist[$d]['design_name_en'] . '</b></td>';
                                                    }
                                                    echo '</tr>';

                                                    $sql2 = "SELECT cd.* FROM " . DB_PRE() . "category_design cd WHERE cd.parent=" . $subcategorylist[$d]['design_id'] . " and cd.category_id=" . $categorylist[$c]['category_id'] . "  order by cd.sort asc";
                                                    $designlist = $this->db->query($sql2)->result_array();
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div style="width:97%;float:left;border:1px solid #ddd; margin-top: 10px; padding: 10px;">
                                                                <table style="width:100%; ">
                                                                    <?php
                                                                    for ($a = 0; $a < count($designlist); $a++) {

                                                                        $res = $this->db->query("select cust_points,points from " . DB_PRE() . "user_details where userid=" . $user_id . " and cat_id=" . $designlist[$a]['category_id'] . " and design_id=" . $designlist[$a]['design_id']);
                                                                        $points = ($res->num_rows() > 0) ? $res->row()->points : 0;
                                                                        $cust_points = ($res->num_rows() > 0) ? $res->row()->cust_points : 0;

                                                                        echo '<tr >';
                                                                        if ($this->langtype == '_ch') {
                                                                            echo '<td style="width:25%!important; float:left;"><b>' . $designlist[$a]['design_name_ch'] . '</b></td>';
                                                                        } else {
                                                                            echo '<td style="width:25%!important; float:left;"><b>' . $designlist[$a]['design_name_en'] . '</b></td>';
                                                                        }
                                                                        echo '<td style="width:25%!important; float:left;"><img style="float:left;max-width:40px;max-height:40px;" src="' . base_url() . $designlist[$a]['design_pic'] . '"/></td>';
                                                                        echo '<td style="width:15%!important; float:left;">Cost  : </td>';
                                                                        echo '<td style="width:15%!important; float:left;">' . $points
                                                                        . '</td>';
                                                                        echo '<td style="width:15%!important; float:left;"><input type="text" name="cust_points[]" value="'.$cust_points.'"/>'
                                                                        . '<input type="hidden" name="category[]" value="' . $designlist[$a]['category_id'] . '"/>'
                                                                        . '<input type="hidden" name="design[]" value="' . $designlist[$a]['design_id'] . '"/>'
                                                                        . '</td>';
                                                                        echo '</tr>';
                                                                        echo '<tr><td><hr></hr></td></tr>';
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>    
                                                    <?php
                                                }
                                                ?>


                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>

    </table>
    <?php
    /* }else{
      echo "<h4><center>No Design is Selected !!..</center></h4>";
      } */
    ?>
    <table style="width:100%;float:left; ">
        <tr>
            <td>
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>"/>
                <input name="uid" type="hidden" value="<?php echo $userinfo['uid']; ?>"/>
            </td>
            <td align="left">
                <div class="gksel_btn_action_on" onclick="tosave_userinfo_update(<?php echo $userinfo['uid'] ?>)"><?php echo lang('cy_save') ?></div>
            </td>
        </tr>
    </table>


</form> 
<script type="text/javascript">
    $(document).ready(function () {
        var button_gksel1 = $('#img1_gksel_choose'), interval;
        if (button_gksel1.length > 0) {
            new AjaxUpload(button_gksel1, {
                action: baseurl + 'index.php/welcome/upfile',
                name: 'logo', onSubmit: function (file, ext) {
                    if (ext && /^(pdf)$/.test(ext)) {
                        button_gksel1.text('Uploading');
                        this.disable();
                        interval = window.setInterval(function () {
                            var text = button_gksel1.text();
                            if (text.length < 13) {
                                button_gksel1.text(text + '.');
                            } else {
                                button_gksel1.text('Uploading');
                            }
                        }, 200);
                    } else {
                        $('#img1_gksel_error').html('Upload Fail');
                        return false;
                    }
                },
                onComplete: function (file, response) {
                    button_gksel1.text('Upload PDF');
                    window.clearInterval(interval);
                    this.enable();
                    if (response == 'false') {
                        $('#img1_gksel_error').html('Upload Fail');
                    } else {
                        var pic = eval("(" + response + ")");
                        $('#img1_gksel_show').html('<a target="_blank" href="' + baseurl + pic.logo + '">Download</a>');
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