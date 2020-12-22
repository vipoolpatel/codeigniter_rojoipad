<?php $this->load->view('admin/header')?>

<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_product.js?date=<?php echo CACHE_USETIME()?>'></script>
	
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
$current_url = current_url();
$current_url_encode=str_replace('/','slash_tag',base64_encode($current_url.$get_str));

$product_type = $this->input->get('product_type');
$keyword = $this->input->get('keyword');
?>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td align="left">
				<div style="float: left;width:100%;text-indent:10px;">
					<?php echo $categoryinfo['category_name'.$this->langtype];?>
				</div>
			</td>
			<td align="right">
				<div style="float: left;width:100%;text-indent:10px;">
					<?php echo '<a href="'.base_url().'index.php/admins/product/toadd_design/'.$parent.'/'.$category_id.'/?backurl='.$backurl.'&subbackurl='.$subbackurl.'&thirdbackurl='.$current_url_encode.'" class="gksel_btn_action_on">Add</a>'; ?>
				</div>
			</td>
		</tr>
	</thead>
</table>
<table class="gksel_normal_tablist">
	<thead>
		<tr>
			<td width="50" align="center"><?php echo lang('cy_sn')?></td>
			<td><p>&nbsp;&nbsp;&nbsp;<?php echo lang('dz_product_category_name')?></p></td>
			<td width="350" align="center"><p><?php echo lang('cy_actions')?></p></td>
		</tr>
	</thead>
	<tbody id="tasks">
		<tr>
			<td width="50" align="center" style="padding:0px;border: none;"></td>
			<td style="border: none;"></td>
			<td width="350" align="center" style="padding:0px;border: none;"></td>
		</tr>
       
	<?php if(isset($designlist)){for ($i = 0; $i < count($designlist); $i++) { ?>

        <tr data-type="main" id="<?php echo $designlist[$i]['design_id'] ?>" class="designlist" style="background-color: #EFEFEF;">
            <td width="50" align="center" style="padding:0px;border: none;"><?php echo($i + 1) ?></td>
            <td style="padding:0px;border: none;">
                <div style="float:left;width:100%;">
                    <?php echo $designlist[$i]['design_name' . $this->langtype]; ?>
                </div>
            </td>
            <td width="350" align="center" style="padding:0px;border: none;">
                <div style="float:right;">
                    <?php
                    echo '<a href="' . base_url() . 'index.php/admins/product/delete_design/' . $parent . '/' . $category_id . '/' . $designlist[$i]['design_id'] . '?backurl=' . $backurl . '&subbackurl=' . $subbackurl . '&thirdbackurl=' . $current_url_encode . '" class="gksel_btn_action_on">' . lang('cy_delete') . '</a>';
                    ?>
                </div>
                <div style="float:right;">
                    <?php
                    echo '<a href="' . base_url() . 'index.php/admins/product/toedit_design/' . $parent . '/' . $category_id . '/' . $designlist[$i]['design_id'] . '?backurl=' . $backurl . '&subbackurl=' . $subbackurl . '&thirdbackurl=' . $current_url_encode . '" class="gksel_btn_action_on">' . lang('cy_edit') . '</a>';
                    ?>
                </div>
            </td>
        </tr>
        <?php
        if (isset($designlist[$i]['sublist'])) {
            $sublist = $designlist[$i]['sublist'];
            for ($j = 0; $j < count($sublist); $j++) {
                ?>
                        <tr class="subdesign parent_<?php echo $designlist[$i]['design_id']?>" id="<?php echo $sublist[$j]['design_id']?>" data-type="sub">
						<td width="50" align="center" style="padding:0px;border: none;"></td>
						<td style="padding:0px;border: none;">
							<?php if(isset($sublist[$j]['ishave_checkbox'])){?>
								<div style="float:left;margin-left:10px;margin-top:12px;">
									<input class="mgc mgc-info" type="checkbox" disabled/>
								</div>
							<?php }else if(isset($sublist[$j]['ishave_radio'])){?>
								<div style="float:left;margin-left:10px;margin-top:12px;">
									<input class="mgr mgr-success" type="radio" disabled/>
								</div>
							<?php }?>
							
							<?php if(isset($sublist[$j]['design_pic'])){?>
								<div style="float:left;margin-left:10px;">
									<img style="float: left;height:40px;" src="<?php echo base_url().$sublist[$j]['design_pic']?>"/>
								</div>
							<?php }?>
							<div style="float:left;margin-left:10px;line-height:36px;">
								<?php echo $sublist[$j]['design_name'.$this->langtype];?>
							</div>
							<?php if(isset($sublist[$j]['ishave_input'])){?>
								<?php if(isset($sublist[$j]['input_title'.$this->langtype])){?>
									<div style="float:left;margin-left:10px;width:80px;">
										<div style="float:left;width:100%;margin-top:0px;">
											<?php echo $sublist[$j]['input_title'.$this->langtype]?>
										</div>
										<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
											
										</div>
									</div>
								<?php }else{?>
									<div style="float:left;margin-left:10px;margin-top:30px;width:80px;border-bottom:1px solid black;">
										
									</div>
								<?php }?>
							<?php }?>
							<?php if(isset($sublist[$j]['ishave_input2'])){?>
								<?php if(isset($sublist[$j]['input2_title'.$this->langtype])){?>
									<div style="float:left;margin-left:10px;width:80px;">
										<div style="float:left;width:100%;margin-top:0px;">
											<?php echo $sublist[$j]['input2_title'.$this->langtype]?>
										</div>
										<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
											
										</div>
									</div>
								<?php }else{?>
									<div style="float:left;margin-left:10px;margin-top:30px;width:80px;border-bottom:1px solid black;">
										
									</div>
								<?php }?>
							<?php }?>
						</td>
						<td width="350" align="center" style="padding:0px;border: none;">
                                                        <div style="float:right;">
								<?php 
									echo '<a href="'.base_url().'index.php/admins/product/delete_design/'.$parent.'/'.$category_id.'/'.$sublist[$j]['design_id'].'?backurl='.$backurl.'&subbackurl='.$subbackurl.'&thirdbackurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_delete').'</a>';
								?>
							</div>
							<div style="float:right;">
								<?php 
									echo '<a href="'.base_url().'index.php/admins/product/toedit_design/'.$parent.'/'.$category_id.'/'.$sublist[$j]['design_id'].'?backurl='.$backurl.'&subbackurl='.$subbackurl.'&thirdbackurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
								?>
							</div>
						</td>
					</tr>
					
					<?php 
						if(isset($designlist[$i]['sublist'][$j]['thirdlist'])){
							$thirdlist = $designlist[$i]['sublist'][$j]['thirdlist'];
							for ($k = 0; $k < count($thirdlist); $k++) {
					?>
						<tr>
							<td width="50" align="center" style="padding:0px;border: none;"></td>
							<td style="padding:0px;border: none;padding-left:40px;">
								<?php if(isset($thirdlist[$k]['ishave_checkbox'])){?>
									<div style="float:left;margin-left:10px;margin-top:12px;">
										<input class="mgc mgc-info" type="checkbox" disabled/>
									</div>
								<?php }else if(isset($thirdlist[$k]['ishave_radio'])){?>
									<div style="float:left;margin-left:10px;margin-top:12px;">
										<input class="mgr mgr-success" type="radio" disabled/>
									</div>
								<?php }?>
								
								<?php if(isset($thirdlist[$k]['design_pic'])){?>
									<div style="float:left;margin-left:10px;">
										<img style="float: left;width:40px;height:40px;" src="<?php echo base_url().$thirdlist[$k]['design_pic']?>"/>
									</div>
								<?php }?>
								<div style="float:left;margin-left:10px;line-height:36px;">
									<?php echo $thirdlist[$k]['design_name'.$this->langtype];?>
								</div>
								<?php if(isset($thirdlist[$k]['ishave_input'])){?>
									<?php if(isset($thirdlist[$k]['input_title'.$this->langtype])){?>
										<div style="float:left;margin-left:10px;width:80px;">
											<div style="float:left;width:100%;margin-top:0px;">
												<?php echo $thirdlist[$k]['input_title'.$this->langtype]?>
											</div>
											<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
												
											</div>
										</div>
									<?php }else{?>
										<div style="float:left;margin-left:10px;margin-top:30px;width:80px;border-bottom:1px solid black;">
											
										</div>
									<?php }?>
								<?php }?>
								<?php if(isset($thirdlist[$k]['ishave_input2'])){?>
									<?php if(isset($thirdlist[$k]['input2_title'.$this->langtype])){?>
										<div style="float:left;margin-left:10px;width:80px;">
											<div style="float:left;width:100%;margin-top:0px;">
												<?php echo $thirdlist[$k]['input2_title'.$this->langtype]?>
											</div>
											<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
												
											</div>
										</div>
									<?php }else{?>
										<div style="float:left;margin-left:10px;margin-top:30px;width:80px;border-bottom:1px solid black;">
											
										</div>
									<?php }?>
								<?php }?>
							</td>
							<td width="350" align="center" style="padding:0px;border: none;">
								<div style="float:right;">
									<?php 
										echo '<a href="'.base_url().'index.php/admins/product/toedit_design/'.$parent.'/'.$category_id.'/'.$thirdlist[$k]['design_id'].'?backurl='.$backurl.'&subbackurl='.$subbackurl.'&thirdbackurl='.$current_url_encode.'" class="gksel_btn_action_on">'.lang('cy_edit').'</a>';
									?>
								</div>
							</td>
						</tr>
					<?php }}?>
				<?php }}?>
				
				<?php if(isset($designlist[$i]['ishave_input'])){?>
					<tr>
						<td width="50" align="center" style="padding:0px;border: none;"></td>
						<td style="padding:0px;border: none;padding-left:40px;">
							<div style="float:left;margin-left:10px;width:80px;">
								<div style="float:left;width:100%;margin-top:0px;">
									<?php echo $designlist[$i]['input_title'.$this->langtype]?>
								</div>
								<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
									
								</div>
							</div>
						</td>
						<td width="350" align="center" style="padding:0px;border: none;">
							
						</td>
					</tr>
				<?php }?>
				
				<?php if(isset($designlist[$i]['ishave_input2'])){?>
					<tr>
						<td width="50" align="center" style="padding:0px;border: none;"></td>
						<td style="padding:0px;border: none;padding-left:40px;">
							<div style="float:left;margin-left:10px;width:80px;">
								<div style="float:left;width:100%;margin-top:0px;">
									<?php echo $designlist[$i]['input2_title'.$this->langtype]?>
								</div>
								<div style="float:left;width:100%;margin-top:20px;border-bottom:1px solid black;">
									
								</div>
							</div>
						</td>
						<td width="350" align="center" style="padding:0px;border: none;">
							
						</td>
					</tr>
				<?php }?>
    
		<?php }}?>
       
	</tbody>
</table>
<script src="<?php echo base_url()?>themes/default/js/jquery-ui-1.10.3.custom.min.js"></script>
<script>
    	jQuery(function($) {
		
		$('#tasks').sortable({
			opacity:0.8,
			revert:true,
			forceHelperSize:true,
			placeholder: 'draggable-placeholder',
			forcePlaceholderSize:true,
			tolerance:'pointer',
			stop: function( event,ui) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
				$(ui.item).css('z-index', 'auto');
				let newsrot=[];
				let idarr=[];
				let i=0;
				$('.designlist').each(function (){
					newsrot.push(++i);
					idarr.push($(this).attr('id'));
                                        
                                        let x = 0;
                                        $(".parent_" + $(this).attr('id')).each(function() {
                                            newsrot.push(++x);
                                            idarr.push($(this).attr('id'));
                                        });
				})
				$.post(baseurl+'index.php/admins/product/editdesign_sort',{idarr:idarr,newsrot:newsrot},function (data){
					
				})
			},
			scroll: true,
		});
		
	})
</script>
<?php $this->load->view('admin/footer')?>