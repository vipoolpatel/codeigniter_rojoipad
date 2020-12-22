<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8">

            <title>Rojo Clothing</title>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/default/magic-input/dist/magic-input.min.css">
                <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME() ?>'></script>
                <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/lan<?php echo $this->langtype ?>.js?date=<?php echo CACHE_USETIME() ?>'></script>
                <script type="text/javascript" src='<?php echo CDN_URL(); ?>themes/default/js/admin/admin_common.js?date=<?php echo CACHE_USETIME() ?>'></script>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/default/admin.css?date=<?php echo CACHE_USETIME() ?>"/>
                <link rel="shortcut icon" href="<?php echo base_url() ?>themes/default/images/rojo.ico?date=<?php echo CACHE_USETIME() ?>" type="image/x-icon" />
                </head>
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
                $current_url = current_url() . $get_str;
                $current_url_encode = str_replace('/', 'slash_tag', base64_encode(current_url() . $get_str));
                $menu = $this->session->userdata('menu');
                
                $type =  $this->uri->segment(3);
                ?>
                <script type="text/javascript">
                    var baseurl = '<?php echo base_url() ?>';
                    var cdnurl = '<?php echo CDN_URL() ?>';
                    var currenturl = '<?php echo $current_url ?>';
                    var current_url_encode = '<?php echo $current_url_encode ?>';
                </script>


                <body>
                    <?php
                    if (isset($_COOKIE['admin'])) {
                        $admin = unserialize($_COOKIE['admin']);
                        $admin_id = $admin ['admin_id'];
                        $admin_username = $admin ['admin_username'];
                    } else {
                        $admin_id = 0;
                        $admin_username = '';
                    }

                    $color_1_1 = '#d3f3f8';
                    $color_1_2 = '#7cfdbf';
                    $color_1_3 = '#626dfb';
                    $color_1_4 = '#f7d0fa';
                    $color_1_5 = '#3d177c';
                    $color_2_1 = '#7a027e';
                    $color_3_1 = '#62f9fb';
                    $color_4_1 = '#f9fb62';
                    $color_4_2 = '#fbe462';
                    $color_4_3 = '#fa22e3';
                    $color_5_1 = '#fb8e62';
                    $color_6 = '#fa22e3';
                    ?>
                    <div class="Frame_Header">
                        <div style="float:left;border-bottom:2px solid #111d35;margin-left:20px;">

                            <div  style="cursor:pointer;float:left;background:#111d35;padding:5px 15px;color:white;margin-top:20px;">
                                Ipad
                            </div>
                        </div>
                        <!--
                        <img class="logo" src="<?php echo CDN_URL() . $cmsinfo['pic_1'] ?>"/>
                        -->
                        <div class="infomation" style="width:160px;margin-right:15px;">
                            <div class="infoarea" style="width:160px;">
                                <div class="inforight">
                                    <div class="info">Hello!</div>
                                    <div class="userinfo"><?php echo $this->session->userdata('user_realname'); ?></div>
                                    <div class="logout"><a href="<?php echo base_url() . 'index.php/admin/logout' ?>">【<?php if ($this->langtype == '_ch') {
                        echo '退出';
                    } else {
                        echo 'Logout';
                    } ?>】</a></div>
                                </div>
                            </div>
                            <div class="languagearea">
                                <div class="language">
                                    <a href="<?php echo base_url() . 'index.php/welcome/changelanguage/en/' . $current_url_encode ?>"><img src="<?php echo base_url() . 'themes/default/images/header_lan_en.png' ?>"/></a>
                                    <a href="<?php echo base_url() . 'index.php/welcome/changelanguage/ch/' . $current_url_encode ?>"><img src="<?php echo base_url() . 'themes/default/images/header_lan_ch.png' ?>"/></a>
                                </div>
                            </div>
                            <!--
                            <div style="float:left;width:100%;">
                                    <img onclick="torefreshpage()" style="cursor:pointer;float:right;width:30px;height:30px;margin-top:3px;margin-right:80px;" src="<?php echo base_url() . 'themes/default/images/refresh_small.png' ?>"/>
                            </div>
                            -->

                        </div>
                    </div>
                    <script>
                        function torefreshpage() {
                    // 	location.reload() 或者是 history.go(0) 来做。
                            location.reload();
                        }

                    </script>

                    <div class="Frame_Leftmenu">
                        <div class="title">
                            
                                <div  style="cursor:pointer;float:left; <?= ($menu == 'user')?'border-bottom:2px solid #111d35;':'';?> padding:5px 10px;color:black;font-size:16px;text-indent:0px;margin-left:20px;min-width:60px;text-align:center;">
                                    <a href="<?php echo base_url() . 'index.php/admins/client/index?user_type=1' ?>">Ipad settings</a>
                                </div>
                                <div  style="cursor:pointer;float:left; <?= ($menu == 'order')?'border-bottom:2px solid #111d35;':'';?> padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                                    <a href="<?php echo base_url() . 'index.php/admins/order/index' ?>">Orders</a>
                                </div>
                            
                        </div>
 
                            <div class="list">
    <?php
    $group_id = 1;
    $isonthissection = 0;
    if ($menu == 'productcategory' || $menu == 'designlist' || $menu == 'keyword' || $menu == 'cms') {
        $isonthissection = 1;
    }
    ?>
                                
                                <?php
                                if($menu == 'user'){
                                ?>
                                <ul group_id = "<?php echo $group_id ?>" class="menugroup">
                                    <li>
                                        <a class="active">
    <?php echo $this->session->userdata('user_brandname') ?>
                                            <img class="arr_up <?php if ($isonthissection != 1) {
        echo 'displaynone';
    } ?>" src="<?php echo base_url() . 'themes/default/images/arrow_up.png' ?>"/>
                                            <img class="arr_do <?php if ($isonthissection == 1) {
        echo 'displaynone';
    } ?>" src="<?php echo base_url() . 'themes/default/images/arrow_do.png' ?>"/>
                                        </a>
                                    </li>
                                </ul>
                                <ul>
                                    <li ><span><img src="<?php echo base_url() . 'themes/default/images/icon_wallet_on.png'; ?>"/></span><font><a style="<?= ($type == 'language')?'border-bottom:2px solid #111d35;':'';?>" href="<?php echo base_url() . 'index.php/admins/settings/language' ?>"><?php echo lang('cy_language') ?></a></font></li>
                                    <li><span><img src="<?php echo base_url() . 'themes/default/images/icon_wallet_on.png'; ?>"/></span><font><a style="<?= ($type == 'logo')?'border-bottom:2px solid #111d35;':'';?>" href="<?php echo base_url() . 'index.php/admins/settings/logo' ?>"><?php echo lang('cy_logo') ?></a></font></li>
                                    <li><span><img src="<?php echo base_url() . 'themes/default/images/icon_wallet_on.png'; ?>"/></span><font><a style="<?= ($type == 'currency')?'border-bottom:2px solid #111d35;':'';?>" href="<?php echo base_url() . 'index.php/admins/settings/currency' ?>"><?php echo lang('cy_curr') ?></a></font></li>
                                    <li><span><img src="<?php echo base_url() . 'themes/default/images/icon_wallet_on.png'; ?>"/></span><font><a style="<?= ($type == 'measurement')?'border-bottom:2px solid #111d35;':'';?>" href="<?php echo base_url() . 'index.php/admins/settings/measurement' ?>"><?php echo lang('cy_measurements') ?></a></font></li>
                                    <li><span><img src="<?php echo base_url() . 'themes/default/images/icon_wallet_on.png'; ?>"/></span><font><a style="<?= ($type == 'design')?'border-bottom:2px solid #111d35;':'';?>" href="<?php echo base_url() . 'index.php/admins/settings/design' ?>"><?php echo lang('cy_designs') ?></a></font></li>
                                </ul>
                                <?php 
                                }
                                
                                ?>
                            </div>


                    </div>


                    <div class="Frame_Body">

<?php if (isset($url)) { ?><div class="gksel_navigation"><?php echo $url; ?></div><?php } ?>

                        <div class="gksel_delete_box_bg"></div>
                        <div class="gksel_delete_box">
                            <table>
                                <tr>
                                    <td>
                                        <div class="gksel_delete_content">
                                            <div class="close"><img onclick="toclose_deletebox()" src="<?php echo base_url() . 'themes/default/images/close.png' ?>"></div>
                                            <div class="title"></div>
                                            <div class="subtitle"></div>
                                            <div class="control">
                                                <div class="yes" onclick="del()"><?php if ($this->langtype == '_ch') {
    echo '确定';
} else {
    echo 'OK';
} ?></div>
                                                <div class="no" onclick="toclose_deletebox()"><?php if ($this->langtype == '_ch') {
    echo '关闭';
} else {
    echo 'Cancel';
} ?></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>