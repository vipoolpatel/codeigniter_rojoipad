<?php $this->load->view('admin/header')?>
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

$keyword = $this->input->get('keyword');
?>
<div style="float: left;width:100%;margin-top:20px;font-size:28px;font-weight:bold;">
	Statistics
</div>
<div style="float: left;width:48%;">
	<div style="float: left;width:100%;">
	<table cellspacing="1" cellpadding="1" class="gksel_statistics_tablist">
		<thead>
			<tr>
				<td colspan="2" style="background: #111d35;"><span style="color:white;font-weight:bold;">&nbsp;&nbsp;&nbsp;User Distribution</span></td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Total number of users</td>
				<td align="center">200</td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Number of super administrator</td>
				<td align="center">1</td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Number of administrator assistant</td>
				<td align="center">5</td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Number of client shop vendor</td>
				<td align="center">120</td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Number of basic users</td>
				<td align="center">500</td>
			</tr>
		</thead>
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Number of content providers</td>
				<td align="center">5</td>
			</tr>
		</thead>
	</table>
	</div>
	<div style="float: left;width:100%;">
		<table cellspacing="1" cellpadding="1" class="gksel_statistics_tablist">
			<thead>
				<tr>
					<td colspan="2" style="background: #111d35;"><span style="color:white;font-weight:bold;">&nbsp;&nbsp;&nbsp;Most popular</span></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular categroy</td>
					<td align="center" width="150">&nbsp;</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular store</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular product</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular user</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular Article</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most popular banner</td>
					<td align="center"></td>
				</tr>
			</thead>
		</table>
	</div>
	<div style="float: left;width:100%;">
		<table cellspacing="1" cellpadding="1" class="gksel_statistics_tablist">
			<thead>
				<tr>
					<td colspan="2" style="background: #111d35;"><span style="color:white;font-weight:bold;">&nbsp;&nbsp;&nbsp;Most least</span></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least categroy</td>
					<td align="center" width="150">&nbsp;</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least store</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least product</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least user</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least Article</td>
					<td align="center"></td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Most least banner</td>
					<td align="center"></td>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div style="float: left;width:48%;margin-left:3%;">
	<div style="float: left;width:100%;">
	<table cellspacing="1" cellpadding="1" class="gksel_statistics_tablist">
			<tr>
				<td colspan="3" style="background: #111d35;"><p style="border-right: 1px solid #111d35;color:white;font-weight:bold;">&nbsp;&nbsp;&nbsp;Products</td>
			</tr>
			<tr>
				<td rowspan="5">&nbsp;&nbsp;&nbsp;Category 1 分类 1</td>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 1 子分类 1</td>
				<td align="center">200</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 2 子分类 2</td>
				<td align="center">200</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 2 子分类 2</td>
				<td align="center">200</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 4 子分类 4</td>
				<td align="center">200</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 5 子分类 5</td>
				<td align="center">200</td>
			</tr>
			<tr>
				<td rowspan="6">&nbsp;&nbsp;&nbsp;Category 2 分类 2</td>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 1 子分类 1</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 2 子分类 2</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 3 子分类 3</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 4 子分类 4</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 5 子分类 5</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 6 子分类 6</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td rowspan="5">&nbsp;&nbsp;&nbsp;Category 3 分类 3</td>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 1 子分类 1</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 2 子分类 2</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 3 子分类 3</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 4 子分类 4</td>
				<td align="center">1</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;Sub Category 5 子分类 5</td>
				<td align="center">1</td>
			</tr>
		</thead>
	</table>
	</div>
</div>
<?php $this->load->view('admin/footer')?>