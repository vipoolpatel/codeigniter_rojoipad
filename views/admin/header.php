<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">

	<title>Rojo Clothing</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/default/magic-input/dist/magic-input.min.css">
	<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/jquery-1.7.2.min.js?date=<?php echo CACHE_USETIME()?>'></script>
	<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/lan<?php echo $this->langtype?>.js?date=<?php echo CACHE_USETIME()?>'></script>
	<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_common.js?date=<?php echo CACHE_USETIME()?>'></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/default/admin.css?date=<?php echo CACHE_USETIME()?>"/>
	<link rel="shortcut icon" href="<?php echo base_url()?>themes/default/images/rojo.ico?date=<?php echo CACHE_USETIME()?>" type="image/x-icon"/>
</head>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 45px;
        height: 43px;
        float: right;
        margin-right: 15px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        margin: 0 !important;
        height: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #111d35;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #111d35;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(18px);
        -ms-transform: translateX(18px);
        transform: translateX(18px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<?php
$get_str='';
if($_GET){
	$arr = geturlparmersGETS();
	for($i=0;$i<count($arr);$i++){
		if(isset($_GET[$arr[$i]])){
			if($get_str!=""){$get_str .='&';}else{$get_str .='?';}
			$get_str .=$arr[$i].'='.$_GET[$arr[$i]];
		}
	}
}
$current_url = current_url().$get_str;
$current_url_encode = str_replace('/','slash_tag',base64_encode(current_url().$get_str));
$menu = $this->session->userdata('menu');
?>
<script type="text/javascript">
	var baseurl='<?php echo base_url()?>';
	var cdnurl='<?php echo CDN_URL()?>';
	var currenturl='<?php echo $current_url?>';
	var current_url_encode='<?php echo $current_url_encode?>';
</script>


<body>
<?php
if(isset($_COOKIE['admin'])){
	$admin = unserialize($_COOKIE['admin']);
	$admin_id = $admin ['admin_id'];
	$admin_username = $admin ['admin_username'];
}else{
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
        <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>index.php/admin/autologin';"
             style="cursor:pointer;float:left;background:#F8F6F5;padding:5px 15px;color:black;margin-top:20px;">
            Wechat Store
        </div>
        <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>qr/index.php/admin/autologin';"
             style="cursor:pointer;float:left;background:#F8F6F5;padding:5px 15px;color:black;margin-top:20px;">
            QR code
        </div>
        <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admin/autologin';"
             style="cursor:pointer;float:left;background:#111d35;padding:5px 15px;color:white;margin-top:20px;">
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
				<div class="userinfo"><?php echo $admin_username;?></div>
				<div class="logout"><a href="<?php echo base_url().'index.php/admin/logout'?>">【<?php if($this->langtype == '_ch'){echo '退出';}else{echo 'Logout';}?>】</a></div>
			</div>
		</div>
		<div class="languagearea">
			<div class="language">
				<a href="<?php echo base_url().'index.php/welcome/changelanguage/en/'.$current_url_encode?>"><img src="<?php echo base_url().'themes/default/images/header_lan_en.png'?>"/></a>
				<a href="<?php echo base_url().'index.php/welcome/changelanguage/ch/'.$current_url_encode?>"><img src="<?php echo base_url().'themes/default/images/header_lan_ch.png'?>"/></a>
			</div>
		</div>
		<!--
		<div style="float:left;width:100%;">
			<img onclick="torefreshpage()" style="cursor:pointer;float:right;width:30px;height:30px;margin-top:3px;margin-right:80px;" src="<?php echo base_url().'themes/default/images/refresh_small.png'?>"/>
		</div>
		-->

	</div>
</div>
<script>
function torefreshpage(){
// 	location.reload() 或者是 history.go(0) 来做。
	location.reload();
}

</script>

<div class="Frame_Leftmenu">
	<div class="title">
        

		<?php if($menu == 'order') { ?>
            <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admin/autologin';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #F8F6F5;padding:5px 10px;color:black;font-size:16px;text-indent:0px;margin-left:20px;min-width:60px;text-align:center;">
                Ipad settings
            </div>
            <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipadqrcode/index.php/admin/autologin';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #111d35;padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                Orders
            </div>
            <div onclick="location.href='<?php echo base_url() ?>../index.php/admins/measurement';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #F8F6F5;padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                Default Measurements
            </div>
        <?php } else { ?>
            <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admin/autologin';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #111d35;padding:5px 10px;color:black;font-size:16px;text-indent:0px;margin-left:20px;min-width:60px;text-align:center;">
                Ipad settings
            </div>
            <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipadqrcode/index.php/admin/autologin';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #F8F6F5;padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                Orders
            </div>
            <div onclick="location.href='<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipadqrcode/index.php/admin/autologin';"
                 style="cursor:pointer;float:left;border-bottom:2px solid #F8F6F5;padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                Default Measurements
            </div>

        <?php }?>
       

           <a href="<?php echo str_replace('rojoipad/', '', base_url()) ?>rojoipad/index.php/admins/training_center/index" style="cursor:pointer;float:left;border-bottom:2px solid #F8F6F5;padding:5px 10px;color:black;font-size:16px;text-indent:0px;">
                 Training Center
          </a>    
       
        
	</div>
	<?php if($menu == 'order'){?>
		<div class="list">
			<?php
				$group_id = 4;
				$isonthissection = 0;
				if($menu == 'order'){
					$isonthissection = 1;
				}
			?>
			<ul group_id = "<?php echo $group_id?>" class="menugroup">
				<li>
					<a class="active">
						Orders
						<img class="arr_up <?php if($isonthissection != 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_up.png'?>"/>
						<img class="arr_do <?php if($isonthissection == 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_do.png'?>"/>
					</a>
				</li>
			</ul>
			<ul id = "groupsublist_<?php echo $group_id?>" class="<?php if($isonthissection != 1){echo 'displaynone';}?>">
				<li><span><img src="<?php if($menu == 'order'){echo base_url().'themes/default/images/icon_wallet_on.png';}else{echo base_url().'themes/default/images/icon_wallet_off.png';}?>"/></span><font><a <?php if($menu == 'order'){echo 'class="subactive" ';}?>href="<?php echo base_url().'index.php/admins/order/index'?>">Orders</a></font></li>
				<!-- 
				<li><span><img src="<?php echo base_url().'themes/default/images/icon_wallet_off.png';?>"/></span><font><a href="<?php echo str_replace('rojoipad/', '', base_url()).'rojoipadqrcode/index.php/admins/product/index'?>">Orders (old)</a></font></li>
				 -->
				<li><span><img src="<?php echo base_url().'themes/default/images/icon_wallet_off.png';?>"/></span><font><a href="<?php echo str_replace('rojoipad/', '', base_url()).'rojoipadqrcode/index.php/admins/product/gant2'?>" target="_blank">GANT</a></font></li>
			</ul>
			<?php
				$group_id = 100;
				$isonthissection = 0;
				if($menu == 'backup'){
					$isonthissection = 1;
				}
			?>
			<ul group_id = "<?php echo $group_id?>" class="menugroup">
				<li>
					<a class="active">
						<?php if($this->langtype == '_ch'){echo '备份数据库';}else{echo 'Backup database';}?>
						<img class="arr_up <?php if($isonthissection != 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_up.png'?>"/>
						<img class="arr_do <?php if($isonthissection == 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_do.png'?>"/>
					</a>
				</li>
			</ul>
			<ul id = "groupsublist_<?php echo $group_id?>" class="<?php if($isonthissection != 1){echo 'displaynone';}?>">
				<li><span><img src="<?php echo base_url().'themes/default/images/icon_wallet_off.png';?>"/></span><font><a href="<?php echo str_replace('rojoipad/', '', base_url()).'rojoipadqrcode/index.php/admins/backup/index'?>"><?php if($this->langtype == '_ch'){echo '备份数据库';}else{echo 'Backup database';}?></a></font></li>
			</ul>
		</div>
	<?php }else{?>
		<div class="list">
			<?php
				$group_id = 1;
				$isonthissection = 0;
				if($menu == 'productcategory' || $menu == 'designlist' || $menu == 'keyword' || $menu == 'cms'){
					$isonthissection = 1;
				}
			?>
			<ul group_id = "<?php echo $group_id?>" class="menugroup">
				<li>
					<a class="active">
						<?php echo lang('cy_cms_manage')?>
						<img class="arr_up <?php if($isonthissection != 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_up.png'?>"/>
						<img class="arr_do <?php if($isonthissection == 1){echo 'displaynone';}?>" src="<?php echo base_url().'themes/default/images/arrow_do.png'?>"/>
					</a>
				</li>
			</ul>
			<ul id = "groupsublist_<?php echo $group_id?>" class="<?php if($isonthissection != 1){echo 'displaynone';}?>">
				<li><span><img src="<?php if($menu == 'cms'){echo base_url().'themes/default/images/icon_id-card_on.png';}else{echo base_url().'themes/default/images/icon_id-card_off.png';}?>"/></span><font><a <?php if($menu == 'cms'){echo 'class="subactive" ';}?>href="<?php echo base_url().'index.php/admins/cms/cmslist'?>"><?php echo lang('cy_commoncontent_manage')?></a></font></li>
				
				
				<li><span><img src="<?php if($menu == 'productcategory'){echo base_url().'themes/default/images/icon_wallet_on.png';}else{echo base_url().'themes/default/images/icon_wallet_off.png';}?>"/></span><font><a <?php if($menu == 'productcategory'){echo 'class="subactive" ';}?>href="<?php echo base_url().'index.php/admins/product/categorylist'?>"><?php echo lang('dz_product_category_manage')?></a></font></li>
				<li><span><img src="<?php echo base_url().'themes/default/images/icon_wallet_off.png';?>"/></span><font><a href="<?php echo str_replace('rojoipad/', '', base_url()).'rojoipadqrcode/index.php/admins/product/factorylist'?>"><?php echo lang('dz_product_factory_manage')?></a></font></li>
				
				<li><span><img src="<?php if($menu == 'userfeedback'){echo base_url().'themes/default/images/icon_wallet_on.png';}else{echo base_url().'themes/default/images/icon_wallet_off.png';}?>"/></span><font><a <?php if($menu == 'userfeedback'){echo 'class="subactive" ';}?>href="<?php echo base_url().'index.php/admins/userfeedback/userfeedbacklist'?>"><?php echo lang('cy_user_feedbacklist')?></a></font></li>
				<!-- <li><span><img src="<?php echo base_url().'themes/default/images/icon_wallet_off.png';?>"/></span><font><a href="<?php echo base_url().'index.php/admins/userfeedback/userfeedbacklist'?>"><?php echo lang('cy_user_feedbacklist')?></a></font></li> -->
			</ul>
			<?php
				$group_id = 2;
				$isonthissection = 0;
				if($menu == 'user' || $menu == 'client' || $menu == 'pointsetting' || $menu == 'providers' || $menu == 'superadmin' || $menu == 'adminassistant' || $menu == 'wechatautoreply' || $menu == 'wechatmenu'){
					$isonthissection = 1;
				}
			?>
            <ul group_id="<?php echo $group_id ?>" class="menugroup">
                <li>
                    <a class="active">
                        <?php if ($this->langtype == '_ch') {
                            echo '管理员';
                        } else {
                            echo 'Administrator';
                        } ?>
                        <img class="arr_up <?php if ($isonthissection != 1) {
                            echo 'displaynone';
                        } ?>" src="<?php echo base_url() . 'themes/default/images/arrow_up.png' ?>"/>
                        <img class="arr_do <?php if ($isonthissection == 1) {
                            echo 'displaynone';
                        } ?>" src="<?php echo base_url() . 'themes/default/images/arrow_do.png' ?>"/>
                    </a>
                </li>
            </ul>
            <ul id="groupsublist_<?php echo $group_id ?>" class="<?php if ($isonthissection != 1) {
                echo 'displaynone';
            } ?>">
                <?php
                $this->db->from('settings');
                $this->db->where('name', 'tinify_api');
                $query = $this->db->get();
                $tinify_api = $query->row();
                ?>
                <li><span><img src="<?php if ($menu == 'user') {
                            echo base_url() . 'themes/default/images/icon_id-card_on.png';
                        } else {
                            echo base_url() . 'themes/default/images/icon_id-card_off.png';
                        } ?>"/></span><font><a <?php if ($menu == 'user') {
                            echo 'class="subactive" ';
                        } ?>href="<?php echo base_url() . 'index.php/admins/user/index?user_type=1' ?>"><?php if ($this->langtype == '_ch') {
                                echo '管理员';
                            } else {
                                echo 'Administrator';
                            } ?></a></font></li>
                <li><span><img src="<?php if ($menu == 'user') {
                            echo base_url() . 'themes/default/images/icon_id-card_on.png';
                        } else {
                            echo base_url() . 'themes/default/images/icon_id-card_off.png';
                        } ?>"/></span><font><a <?php if ($menu == 'user') {
                            echo 'class="subactive" ';
                        } ?>href="<?php echo base_url() . 'index.php/admins/user/wallet?user_type=1' ?>"><?php if ($this->langtype == '_ch') {
                                echo '管理錢包';
                            } else {
                                echo 'Manage Wallet';
                            } ?></a></font></li>
                <li>
                    <span><img src="<?php if ($menu == 'user') {
                            echo base_url() . 'themes/default/images/icon_id-card_on.png';
                        } else {
                            echo base_url() . 'themes/default/images/icon_id-card_off.png';
                        } ?>"/></span>
                    <font>
                        <a <?php if ($menu == 'user') {
                            echo 'class="subactive" ';
                        } ?> href="javascript:void(0)">Toggle Tinify Api</a>
                    </font>
                    <label class="switch">
                        <input id="tinify_api" type="checkbox" <?= ($tinify_api->status == 1) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </li>
            </ul>
            <script>
                (function () {
                    $('body').on('change', 'input#tinify_api', function () {
                        $.ajax({
                            type: "POST", url: "<?=base_url('index.php/admin/update_setting_status')?>", data: {
                                name: 'tinify_api',
                                status: $(this).is(':checked')
                            }, success: function (result) {
                                console.log(result);
                            }
                        });
                    })
                })();
            </script>
        </div>
    <?php }?>
	
</div>


<div class="Frame_Body">

<?php if(isset($url)){?><div class="gksel_navigation"><?php echo $url;?></div><?php }?>

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
						<div class="yes" onclick="del()"><?php if($this->langtype == '_ch'){echo '确定';}else{echo 'OK';}?></div>
						<div class="no" onclick="toclose_deletebox()"><?php if($this->langtype == '_ch'){echo '关闭';}else{echo 'Cancel';}?></div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>