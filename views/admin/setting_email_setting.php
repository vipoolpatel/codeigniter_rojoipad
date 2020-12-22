<?php $this->load->view('admin/header')?>
<script type="text/javascript" src='<?php echo CDN_URL();?>themes/default/js/admin/admin_setting_email.js?date=<?php echo CACHE_USETIME()?>'></script>
<table class="gksel_normal_tabaction">
	<tr>
		<td>
			<div class="searcharea">
				<div class="ma_actions">
					<ul>
						<li>
							<a href="<?php echo base_url().'index.php/admins/email/index'?>"><font class="nav_off">Manage Auto Response</font></a>
						</li>
						<li>
							<a href="<?php echo base_url().'index.php/admins/email/tosetting_email'?>"><font class="nav_on">Email Settings</font></a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
</table>
<form method="post">
	<table class="gksel_normal_tabpost">
		<?php 
			$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'email_type'";
			$info = $this->db->query($sql)->row_array();
		?>
		<tr>
			<td align="right" width="150">Send Email Type</td>
			<td>
				<div style="float: left;"><input onclick="tochangeemailtype('mail')" type="radio" name="email_type" value="mail" <?php if($info['value'] == 'mail'){echo 'checked';}?>/></div>
				<div style="float: left;">Mail</div>
				<div style="float: left;"><input onclick="tochangeemailtype('smtp')" type="radio" name="email_type" value="smtp" <?php if($info['value'] == 'smtp'){echo 'checked';}?>/></div>
				<div style="float: left;">SMTP</div>
			</td>
		</tr>
		<tbody class="smtp_area <?php if($info['value'] == 'mail'){echo 'displaynone';}?>">
			<?php 
				$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'smtp_server'";
				$info = $this->db->query($sql)->row_array();
			?>
			<tr>
				<td align="right">SMTP Server</td>
				<td>
					<input type="text" name="smtp_server" value="<?php echo $info['value'];?>"/>
					<div class="tipsgroupbox"><div class="request">*</div></div>
				</td>
			</tr>
			<?php 
				$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'smtp_serverport'";
				$info = $this->db->query($sql)->row_array();
			?>
			<tr>
				<td align="right">SMTP Server Port</td>
				<td>
					<input type="text" name="smtp_serverport" value="<?php echo $info['value'];?>"/>
				</td>
			</tr>
			<?php 
				$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'smtp_usermail'";
				$info = $this->db->query($sql)->row_array();
			?>
			<tr>
				<td align="right">SMTP User Mail </td>
				<td>
					<input type="text" name="smtp_usermail" value="<?php echo $info['value'];?>"/>
				</td>
			</tr>
			<?php 
				$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'smtp_user'";
				$info = $this->db->query($sql)->row_array();
			?>
			<tr>
				<td align="right">SMTP User </td>
				<td>
					<input type="text" name="smtp_user" value="<?php echo $info['value'];?>"/>
				</td>
			</tr>
			<?php 
				$sql = "SELECT * FROM ".DB_PRE()."email_setting WHERE name = 'smtp_pass'";
				$info = $this->db->query($sql)->row_array();
			?>
			<tr>
				<td align="right">SMTP Pass </td>
				<td>
					<input type="text" name="smtp_pass" value="<?php echo $info['value'];?>"/>
				</td>
			</tr>
		</tbody>
		<tr>
			<td>
			
			</td>
			<td align="left">
				<div class="gksel_btn_action_on" onclick="tosave_emailsetting()"><?php echo lang('cy_save')?></div>
			</td>
		</tr>
	</table>
</form>
<?php $this->load->view('admin/footer')?>