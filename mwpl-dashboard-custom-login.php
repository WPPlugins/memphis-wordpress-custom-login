<?php
function mwpl_customize_login_dashboard() {
	mwpl_dashboard_css();
?>
<div class="wrap">
	<?php mwpl_donate_button(); ?>
	<!--<div id="message" class="error" ><p>this is a test</p></div>-->
	<h2><?php _e(MWPL_NAME); ?></h2>
	<form enctype="multipart/form-data" method="post" action="options.php" style="">
		<style>
		  label {font-size: 10px;}
		  input {font-size: 13px;}
		</style>
		<?php settings_fields( 'mwpl-settings-group2' ); ?>
		<input type="hidden" name="mwpl_upgrade_224" value="<?php echo get_option('mwpl_upgrade_224'); ?>" />
		<input type="hidden" name="mwpl_upgrade_225" value="<?php echo get_option('mwpl_upgrade_225'); ?>" />
		<h3><?php _e( 'Enable Customization' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Check to customize login page'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_enable_custom_login" value="1" <?php checked('1', get_option('mwpl_enable_custom_login') ); ?>/>
			</td>
		</table>
		<br/>
		<h3><?php _e( 'Generic Customize of Login Page' ); ?></h3>
		<table class="form-table">
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Background Color'); ?></th>
			<td>
				<input type="text" value="<?php echo get_option('mwpl_custom_bgcolor'); ?>" name="mwpl_custom_bgcolor" id="bg-color-mwpl-picker" data-default-color="#fff" />
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Font Size'); ?></th>
			<td>
				<?php $mwpl_font_size = get_option('mwpl_font_size');
				echo '<select name="mwpl_font_size" id="mwpl_font_size" >';
				for($i=3;$i<80;$i++) {
					if($mwpl_font_size == $i) $selected = 'selected';
					else $selected = '';
					$default = '';
					if($i == 24) $default = 'Default';
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'px '.$default.'</option>';
				}
				echo '</select>';
				?>
				
			</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Text Color'); ?></th>
				<td>
					<input type="text" value="<?php echo get_option('mwpl_custom_textcolor'); ?>" name="mwpl_custom_textcolor" id="text-color-mwpl-picker" data-default-color="#777" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Link Colors'); ?></th>
				<td>
					<label><i><?php _e('Normal:'); ?></i></label><br>
					<input type="text" value="<?php echo get_option('mwpl_custom_linkcolor_normal'); ?>" name="mwpl_custom_linkcolor_normal" id="text-color-mwpl-picker" data-default-color="#999" /><br>
					<label><i><?php _e('Hover:'); ?></i></label><br>
					<input type="text" value="<?php echo get_option('mwpl_custom_linkcolor_hover'); ?>" name="mwpl_custom_linkcolor_hover" id="text-color-mwpl-picker" data-default-color="#337ab7" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
				  <?php _e('Custom Message'); ?>
				</th>
				<td>
					<textarea rows="10" cols="100" name="mwpl_custom_message"><?php echo htmlspecialchars(get_option('mwpl_custom_message')); ?></textarea>	
					<br/>
					<label><input type="checkbox" name="mwpl_custom_message_alert" value="1" <?php checked('1', get_option('mwpl_custom_message_alert') ); ?>/> <?php _e('Make it and Alert ');?></label>
				</td>
			</tr>

		</table>
		<br/>
		<h3><?php _e( 'Form Customization' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Form Colors'); ?></th>
			<td>
				<label><i><?php _e('Background Color'); ?>:</i></label><br>
				<input type="text" value="<?php echo get_option('mwpl_form_bg_color'); ?>" name="mwpl_form_bg_color" id="text-color-mwpl-picker" data-default-color="#fff" />
				<br>
				<label><i><?php _e('Border Color'); ?>: </i></label><br>
				<input type="text" value="<?php echo get_option('mwpl_form_border_color'); ?>" name="mwpl_form_border_color" id="text-color-mwpl-picker" data-default-color="#fff" />
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Form Width'); ?></th>
			<td>
				<?php $mwpl_form_width = get_option('mwpl_form_width'); 
				echo '<select name="mwpl_form_width" id="mwpl_form_width" >';
				echo '<option value="" selected>No Value</option>';
				for($i=1;$i<100;$i++) {
					if($mwpl_form_width == $i) $selected = 'selected';
					
					else $selected = '';
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'% '.$default.'</option>';
				}
				echo '</select>';
				?>
			</td>
			</tr>
			<tr>
			<th scope="row"><?php _e('Form Border Radius'); ?></th>
			<td>
				<?php $mwpl_form_border_radius = get_option('mwpl_form_border_radius'); 
				echo '<select name="mwpl_form_border_radius" id="mwpl_form_border_radius" >';
				echo '<option value="" selected>No Value</option>';
				for($i=1;$i<26;$i++) {
					if($mwpl_form_border_radius == $i) $selected = 'selected';
					
					else $selected = '';
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'px '.$default.'</option>';
				}
				echo '</select>';
				?>
			</td>
			</tr>
			<th scope="row"><?php _e('Form Glow Style'); ?></th>
			<td>
				<label style="margin-left: 8px;"><?php _e('Offset Right'); ?>: <input style="width:50px" type="text" name="mwpl_form_box_shadow_right" value="<?php echo get_option('mwpl_form_box_shadow_right'); ?>" /><b>px</b></label><br>
				<label style="margin-left: 8px;"><?php _e('Offset Top'); ?>: <input style="width:50px" type="text" name="mwpl_form_box_shadow_top" value="<?php echo get_option('mwpl_form_box_shadow_top'); ?>" /><b>px</b></label><br>
				<label style="margin-left: 8px;"><?php _e('Softness'); ?>: <input style="width:50px" type="text" name="mwpl_form_box_shadow_softness" value="<?php echo get_option('mwpl_form_box_shadow_softness'); ?>" /><b>px</b></label><br>
				<label style="margin-left: 8px;;"><i><?php _e('Color'); ?>: </i></label>
				<input type="text" value="<?php echo get_option('mwpl_form_box_shadow_color'); ?>" name="mwpl_form_box_shadow_color" id="text-color-mwpl-picker" data-default-color="#333" />
			</td>
			</tr>

		</table>
		<br/>
		<h3><?php _e( 'Logo Customization' ); ?></h3>
		<table class="form-table">
			<tr>
			  <th scope="row">
				  <?php _e('Custom Logo Position Left'); ?><br/>
			  </th>
			  <td>
					  <label><input style="width:50px"  type="text" name="mwpl_bgimage_left" value="<?php echo get_option('mwpl_bgimage_left'); ?>" /><b>px</b> <i><?php _e('eg(10, -54, 287)'); ?></i></label>

					  <br/>

			  </td>
			</tr>
			<tr>
			  <th scope="row">
				  <?php _e('Custom Logo Position Top'); ?><br/>
			  </th>
			  <td>
					  <label><input style="width:50px" type="text" name="mwpl_bgimage_top" value="<?php echo get_option('mwpl_bgimage_top'); ?>" /><b>px</b> <i><?php _e('eg(10, -54, 287)'); ?></i></label>

					  <br/>

			  </td>
			</tr>
			  <th scope="row">
				  <?php _e('Custom Logo Link'); ?><br/>
				  <label style="font-size: 10px;"><i><b><?php _e('Javascript must be enabled.'); ?></b></i></label>
			  </th>
			  <td>
					  <label><input type="text" name="mwpl_logo_link" value="<?php echo get_option('mwpl_logo_link'); ?>" /> <i><?php _e('eg(www.example.com)'); ?></i></label>
					  <br/>
					  <label style="font-size: 10px;"><i><b><?php _e('(default wordpress.org)'); ?></b></i></label>
			  </td>
			</tr>
			<tr>
			  <th scope="row">
				  <?php _e('Custom Logo Title'); ?><br/>
				  <label style="font-size: 10px;"><i><b><?php _e('Javascript must be enabled.'); ?></b></i></label>
			  </th>
			  <td>
					  <label><input type="text" name="mwpl_logo_title" value="<?php echo get_option('mwpl_logo_title'); ?>" /> <i><?php _e('eg(My Website Logo)'); ?></i></label>
					  <br/>

			  </td>
			</tr>
						<tr valign="top">
				<th scope="row"><?php _e('Enable Custom Logo'); ?></th>
				<td>
					<input type="checkbox" name="mwpl_enable_form_bg" value="1" <?php checked('1', get_option('mwpl_enable_form_bg') ); ?>/>
				<td>
			</tr>
		</table>

		<div id="bgimage_box" class="postbox" style="display:none; margin: 10px; width:80%; clear:both;"><h3 class='' style="padding:10px; margin: 0px; cursor:default;"><span><?php _e('Logos'); ?></span></h3>
			<div class="inside">
				<p><?php mwpl_get_bgimages() ?></p>
				<p  style="clear: both;"><br/></p>
			</div>
		</div>
		<p class="submit">
			<input style="margin:15px;" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	<div id="mwpl-uploader" style="display:none; border:  dotted 2px #7BAABC; background: #F1F1F1; padding: 5px; margin: 0; position: fixed; top: 35px; right:5px;">
	    <div>
	  <h2 style="padding:0;"><?php _e('Logo Uploader'); ?></h2>
	  <form id="upload_form" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
				<input style="margin: 0px;" type="file" name="image" id="image"/>
		  <input type="hidden" name="file_upload" value="add_file" />
		  <input type="submit" class="upload-primary" value="<?php _e('Upload File') ?>" />
	  </form>
	</div>
	<script>
		var value = jQuery(' :checkbox[name=mwpl_enable_form_bg]').is( ':checked');
		if(value) jQuery('#bgimage_box').css('display','block');
		if(value) jQuery('#mwpl-uploader').css('display','block');
		jQuery(' :checkbox[name=mwpl_enable_form_bg]').click(function() {
			var value = jQuery(this).is( ':checked');
			if(value) { jQuery('#bgimage_box').slideDown(500); jQuery('#mwpl-uploader').fadeIn(500); }
			else { jQuery('#bgimage_box').slideUp(500); jQuery('#mwpl-uploader').fadeOut(500); }
		});
	</script>
</div>
<?php
}
?>