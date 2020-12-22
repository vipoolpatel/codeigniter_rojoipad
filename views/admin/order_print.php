<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<style>
    * {
        margin: 0;
        box-sizing: border-box;
    }

    b, ul {
        margin: 0;
        padding-left: 15px;
    }

    ul {
        margin-top: 1px;
    }

    td, li {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<body>

<div style="width: 100%;">
    <div style="width:100%;">
        <h1 style="margin:0;float:left;text-align:left;width:45%;"><?= $orderinformation['newclient_number'] ?></h1>
        <h1 style="margin:0;float:left;text-align:right;width:50%;"><?= $brand ?></h1>
    </div>
    <div style="width: 40%;float:left;">
        <table style="width: 100%;">
            <tr>
                <td><?= (($lang == '_ch') ? '名字' : 'Name') ?>:</td>
                <td><?= $clientinfo['user_realname'] ?></td>
            </tr>
            <tr>
                <td><?= (($lang == '_ch') ? '客户编号' : 'Cust#') ?>:</td>
                <td><?= $orderinformation['newclient_number'] ?></td>
            </tr>
            <tr>
                <td><?= (($lang == '_ch') ? 'In' : 'In') ?>:</td>
                <td><?= date('d/m') ?></td>
            </tr>
        </table>
    </div>

    <div style="width: 33%;float:left">
        <table style="width: 100%;">
            <?php
            if (!empty($categorylist)) {
                foreach ($orderinformation['order_list'] as $orderinfo) {
                    for ($c = 0; $c < count($categorylist); $c++) {
                        if (isset($orderinfo['design_list_' . $categorylist[$c]['category_id']]) && !empty($orderinfo['design_list_' . $categorylist[$c]['category_id']])) {
                            ?>
                            <tr>
                                <td><?= $categorylist[$c]['category_name' . $lang] . (($lang == '_ch') ? ' 面料' : ' CODE') ?>:</td>
                                <td><?= $orderinfo['code_' . str_replace(' ', '_', strtolower($categorylist[$c]['category_name_en']))] ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
            ?>
        </table>
    </div>

    <div style="width:25%;float:left">
        <table style="width:100%;">
            <tr>
                <td><?= (($lang == '_ch') ? '西装' : 'JA') ?> #:</td>
                <td><?= $orderinformation['order_list'][0]['ja_garment'] ?></td>
            </tr>
            <tr>
                <td><?= (($lang == '_ch') ? '衬衣' : 'SH') ?> #:</td>
                <td><?= $orderinformation['order_list'][0]['sh_garment'] ?></td>
            </tr>
            <tr>
                <td><?= (($lang == '_ch') ? '裤子' : 'TR') ?> #:</td>
                <td><?= $orderinformation['order_list'][0]['tr_garment'] ?></td>
            </tr>
            <tr>
                <td><?= (($lang == '_ch') ? '马夹' : 'WC') ?> #:</td>
                <td><?= $orderinformation['order_list'][0]['wc_garment'] ?></td>
            </tr>
        </table>
    </div>
</div>

<table border="1" style="width:100%;border:1px solid black;">
    <tr>
        <td width="25%"><?= (($lang == '_ch') ? '上身' : 'Upper') ?></td>
        <td width="25%"><?= (($lang == '_ch') ? '西装' : 'Jacket') ?></td>
        <td width="25%"><?= (($lang == '_ch') ? '衬衣' : 'Shirt') ?></td>
        <td width="25%"><?= (($lang == '_ch') ? '马夹' : 'Waistcoat') ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '衣长' : 'Length') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_length'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_length'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_length'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '肩宽' : 'Shoulder') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_shoulders'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_shoulders'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_shoulders'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '胸围' : 'Chest Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_chest'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_chest'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_chest'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '前胸' : 'Front Chest') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_chest_f'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_chest_f'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_chest_f'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '后背' : 'Back Chest') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_chest_b'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_chest_b'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_chest_b'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '腰围' : 'Waist Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_bust'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_bust'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_bust'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '臀围' : 'Hip Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_circumference'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_circumference'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_circumference'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '袖长' : 'Sleeve L') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_sleeve'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_sleeve'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_sleeve'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '袖肥围' : 'Bicep Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_bicep'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_bicep'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_bicep'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '袖口围' : 'Wrist Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_wrist'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_wrist'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_wrist'] ?></td>
    </tr>
    <tr>
        <td><?= (($lang == '_ch') ? '领围' : 'Neck Cir') ?></td>
        <td><?= $orderinformation['order_list'][0]['ja_neck'] ?></td>
        <td><?= $orderinformation['order_list'][0]['sh_neck'] ?></td>
        <td><?= $orderinformation['order_list'][0]['wc_neck'] ?></td>
    </tr>
</table>

<div style="width:50%;float:left;">
    <table border="1" style="width:100%;margin-top:10px;margin-bottom:5px;border:1px solid black;">
        <tr>
            <td width="50%"><?= (($lang == '_ch') ? '下身' : 'Lower') ?></td>
            <td width="50%"><?= (($lang == '_ch') ? '裤子' : 'Trouser') ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '裤长' : 'Outside leg') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_length'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '腰围' : 'Waist') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_waist'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '臀围' : 'Glutes') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_gluteus'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '大腿' : 'Thigh') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_thigh'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '值档' : 'Crotch') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_crotch_rise'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '前档' : 'Front Crotch') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_crotch_front'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '后档' : 'Back Crotch') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_crotch_back'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '中档围' : 'Hamstring') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_hamstring'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '小腿围' : 'Calf') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_calf'] ?></td>
        </tr>
        <tr>
            <td><?= (($lang == '_ch') ? '脚口围' : 'Ankle') ?></td>
            <td><?= $orderinformation['order_list'][0]['tr_ankle'] ?></td>
        </tr>
    </table>
</div>

<?php
foreach ($orderinformation['order_list'] as $orderinfo) {
    if (!empty($categorylist)) {
        for ($c = 0; $c < count($categorylist); $c++) {
            if (isset($orderinfo['design_list_' . $categorylist[$c]['category_id']]) && !empty($orderinfo['design_list_' . $categorylist[$c]['category_id']])) {
                ?>
                <div style="width:45%;float:left;<?= (!isset($mt) ? 'margin-top:10px;' : '') ?>margin-left:5px;margin-bottom:5px;">
                    <b><?= $categorylist[$c]['category_name' . $lang] ?>
                        - <?= $orderinfo['code_' . str_replace(' ', '_', strtolower($categorylist[$c]['category_name_en']))] ?></b>
                    <ul>
                        <?php
                        $strip_words = ['(i)', '(ii)', '(iii)', '(iv)', '(v)', '(vi)', '(vii)', '(viii)', '(ix)', 'A. ', 'B. ', 'C. ', 'D. ', 'E. ', 'F. '];
                        $design_list = $orderinfo['design_list_' . $categorylist[$c]['category_id']];
                        for ($i = 0; $i < count($design_list); $i++) {
                            if (isset($design_list[$i]['radio_value'])) {
                                if ($design_list[$i]['design_name_en'] == 'D. Monogram') {
                                    echo "<li>" . (($lang == '_ch' && isset($design_list[$i]['input2_value'])) ?
                                            "{$design_list[$i]['radio_name'.$lang]}: {$design_list[$i]['input_value']}  颜色 {$design_list[$i]['input2_value']}" :
                                            (($lang == '_en' && isset($design_list[$i]['input2_value'])) ?
                                                "{$design_list[$i]['radio_name'.$lang]}: {$design_list[$i]['input_value']}  ({$design_list[$i]['input2_value']})" :
                                                "{$design_list[$i]['radio_name'.$lang]}  {$design_list[$i]['input_value']}")) . "</li>";
                                    ?>
                                <?php } else { ?>
                                    <li><?= $design_list[$i]['radio_name' . $lang] . ' ' . $design_list[$i]['input_title' . $lang] . ' ' . $design_list[$i]['input_value'] . ' ' . $design_list[$i]['input2_title' . $lang] . ' ' . $design_list[$i]['input2_value'] ?></li>
                                <?php }
                            } elseif (isset($design_list[$i]['checkbox_value'])) { ?>
                                <li><?= str_replace($strip_words, '', $design_list[$i]['design_name' . $lang]) ?>
                                    : <?= $design_list[$i]['input_value'] . ' ' . $design_list[$i]['input2_value'] ?></li>
                                <?php
                            }
                            /*$html .='
                            <li><?=str_replace(['A?>,'B?>,'C?>,'D?>,'E?>,'F?>,'G?>,'H?>,],'',$design_list[$i]['design_name<?= $lang])?></li>
                            ';
                            if (isset($design_list[$i]['radio_value'])) {
                            $html .= '
                            <li><?= (($lang == '_ch') ? $design_list[$i]['radio_name_ch'] : $design_list[$i]['radio_name_en']) ?> <?= (($lang == '_ch') ?
                                $design_list[$i]['input_title_ch'] : $design_list[$i]['input_title_en']) ?> <?= $design_list[$i]['input_value'] ?>
                            </li>
                            ';
                            }elseif (isset($design_list[$i]['checkbox_value'])) {
                            $html .= '
                            <li><?= str_replace(['(i)','(ii)','(iii)','(iv)','(v)','(vi)','(vii)','(viii)','(ix)'],'',(($lang == '_ch') ?
                                $design_list[$i]['design_name_ch'] : $design_list[$i]['design_name_en'])) ?>: <?= $design_list[$i]['input_value'] ?>
                            </li>
                            ';
                            }*/
                        } ?>
                    </ul>
                </div>
                <?php
                $mt = true;
            }
        }
    }
}
?>
<div style="width:25%;float:left;"><?= $image ?></div>
</body>
</html>