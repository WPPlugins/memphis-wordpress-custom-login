<?php
$mwpl_bgimages = array();
function mwpl_dashboard_init() {
	if(isset($_GET['page']) && $_GET['page'] == 'memphis-custom-login.php') {
		//WORDPRESS IRIS COLOR PICKER
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'mwpl-color-picker', plugins_url('mwpl-admin-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}
	
}
function mwpl_dashboard_menu() {
	add_menu_page( 'Memphis Custom Login', 'Memphis CL', 'administrator', 'memphis-wp-login.php', 'mwpl_blog_protection_dashboard', MWPL_PLUGIN_URL.'/assets/imgs/kon.ico'  );
	add_submenu_page( 'memphis-wp-login.php', 'Blog Protection', 'Blog Protection', 'administrator', 'memphis-wp-login.php', 'mwpl_blog_protection_dashboard' );
	add_submenu_page( 'memphis-wp-login.php', 'Customized Login', 'Customized Login', 'administrator', 'memphis-custom-login.php', 'mwpl_customize_login_dashboard' );
	add_submenu_page( 'memphis-wp-login.php', 'Google Analytics', 'Google Analytics', 'administrator', 'memphis-google-analytics.php', 'mwpl_google_analytics_dashboard' );
	add_action('admin_init','mwpl_register_settings');
}

function mwpl_register_settings() {
  global $mwpl_bgimages;
  $upload_dir = wp_upload_dir();
  //$expode = explode('uploads',$upload_dir['path']);
  //$upload_path = $expode[1];
  //var_dump($upload_path);
	// NONCE CHECK AND REQUEST HANDLING
	if(!empty($_GET['action']) && !empty($_GET['file'])) {
		$action = $_GET['action'];
		$file = $_GET['file'];
		$nonce = $_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce, 'my-nonce') ) die('Security checkss');
		check_admin_referer('my-nonce');
	} else $action = '';
	if(!empty($_POST['file_upload']))
		$action = $_POST['file_upload'];
	switch($action) {
		case 'add_file':
		  $image = $_FILES["image"]["name"];
		  $image_type = $_FILES["image"]["type"];
		  $image_type = str_replace('image/','',$image_type);
		  if($image != '') {
			  //$image = MWPL_BGIMAGE.date('YmdHis').'.'.$image_type;
			  $upload = wp_upload_bits($image, null, file_get_contents($_FILES["image"]["tmp_name"]));
			  if($upload['error'] == '') {
				$mwpl_bgimages = get_option('mwpl_custom_bgimage_list');
				$bg_image_array = array();
				list($width, $height, $type, $attr) = getimagesize($upload['file']);
				$explode = explode('/',$upload['url']);
				$imagename = $explode[count($explode)-1];
				$path = $upload['file'];
				array_push($mwpl_bgimages, array(
									   //imageurl=>$upload['url'],
									   //imagepath=>$upload['file'],
									   'imagename'=>$upload_dir['subdir'].'/'.$imagename,
									   'width'=>$width,
									   'height'=>$height,
									   'type'=>$type,
									   'attr'=>$attr
									   ));
				update_option('mwpl_custom_bgimage_list', $mwpl_bgimages);
			  } else {
			    function upload_error_notice() {
				$upload_error = get_option('mwpl_upload_error');
				?>
				<div class="updated" style="position: absolute; z-index: 2000;">
				    <p><?php _e($upload_error); ?></p>
				 </div>
				<?php
			    }
			    update_option('mwpl_upload_error', $upload['error']);
			    add_action('admin_notices', 'upload_error_notice');
			  }

		  }
		  break;
		case 'delete':
			$index = 0;
			$image = $_GET['file'];
			$images = get_option('mwpl_custom_bgimage_list');
			foreach($images as $k) {
				if($k['imagename'] == $image) break;
				$index++;
			}
			$bg_image = unserialize(get_option('mwpl_custom_bgimage'));
			if($image == $bg_image['imagename']) update_option('mwpl_custom_bgimage', serialize(array()));
			unset($images[$index]);
			$images = array_values($images);
			update_option('mwpl_custom_bgimage_list', $images);
			unlink($upload_dir['basedir'].$image);
			$location = get_site_url().'/wp-admin/admin.php?page=memphis-custom-login.php';
			wp_redirect( $location, '302' );
			break;
	}
	//************************************************************************************************* //
	//*******************************   [   REMOVED VERSION 2.0   ]   ******************************* //
	/*
	//[REMOVE] add_option('mwpl_form_height',100);
	//unregister_setting('mwpl-settings-group','mwpl_google_analytics');
	delete_option('mwpl_form_height');
	//[REMOVE] add_option('mwpl_form_offset_tb',0);
	//unregister_setting('mwpl-settings-group','mwpl_google_analytics');
	delete_option('mwpl_form_offset_tb');
	//[REMOVE] add_option('mwpl_form_offset_lr',0);
	//unregister_setting('mwpl-settings-group','mwpl_google_analytics');
	delete_option('mwpl_form_offset_lr');
	//[REMOVE]register_setting('mwpl-settings-group2','mwpl_form_offset_tb');
	unregister_setting('mwpl-settings-group2','mwpl_form_offset_tb');
	delete_option('mwpl_form_offset_tb');
	//[REMOVE]register_setting('mwpl-settings-group2','mwpl_form_offset_lr');
	unregister_setting('mwpl-settings-group2','mwpl_form_offset_lr');
	delete_option('mwpl_form_offset_lr');
	//[REMOVE]register_setting('mwpl-settings-group2','mwpl_form_height');
	unregister_setting('mwpl-settings-group2','mwpl_form_height');
	delete_option('mwpl_form_height');
	//[REMOVE]register_setting('mwpl-settings-group2','mwpl_bl_offset_tb');
	unregister_setting('mwpl-settings-group','mwpl_bl_offset_tb');
	delete_option('mwpl_bl_offset_tb');
	//[REMOVE]register_setting('mwpl-settings-group2','mwpl_bl_offset_lr');
	unregister_setting('mwpl-settings-group2','mwpl_bl_offset_lr');
	delete_option('mwpl_bl_offset_lr');
	*/
	//************************************************************************************************* //
	//************************************************************************************************* //

	// REGISTERING OPTIONS //
	//Login Protection
	add_option('mwpl_password_protected',null);
	register_setting( 'mwpl-settings-group1','mwpl_password_protected');
	register_setting( 'mwpl-settings-group1','mwpl_redirect_login');
	register_setting('mwpl-settings-group1','mwpl_custom_redirect_page');
	//Version 2.0
	register_setting('mwpl-settings-group1','mwpl_hide_lost_password');
	register_setting('mwpl-settings-group1','mwpl_hide_login_messages');
	//Version 2.0.4
	register_setting('mwpl-settings-group1','mwpl_disable_ie_compatibility_mode');

	//Customized Login
	register_setting('mwpl-settings-group2','mwpl_custom_bgcolor');
	register_setting('mwpl-settings-group2','mwpl_custom_textcolor');
	register_setting('mwpl-settings-group2','mwpl_custom_linkcolor_normal');
	register_setting('mwpl-settings-group2','mwpl_custom_linkcolor_hover');
	register_setting( 'mwpl-settings-group2','mwpl_enable_custom_login');
	register_setting( 'mwpl-settings-group2','mwpl_enable_form_bg');
	register_setting('mwpl-settings-group2','mwpl_custom_bgimage');
	register_setting('mwpl-settings-group2','mwpl_form_position_top');
	register_setting('mwpl-settings-group2','mwpl_form_width');
	register_setting('mwpl-settings-group2','mwpl_hide_top_bar');
	//Version 2.0
	register_setting('mwpl-settings-group2', 'mwpl_remove_text_shadow');
	register_setting('mwpl-settings-group2', 'mwpl_form_bg_color');
	register_setting('mwpl-settings-group2', 'mwpl_form_border_color');
	register_setting('mwpl-settings-group2', 'mwpl_form_border_radius');
	register_setting('mwpl-settings-group2', 'mwpl_form_box_shadow_right');
	register_setting('mwpl-settings-group2', 'mwpl_form_box_shadow_top');
	register_setting('mwpl-settings-group2', 'mwpl_form_box_shadow_softness');
	register_setting('mwpl-settings-group2', 'mwpl_form_box_shadow_color');
	register_setting('mwpl-settings-group2', 'mwpl_logo_link');
	register_setting('mwpl-settings-group2', 'mwpl_logo_title');
	register_setting('mwpl-settings-group2', 'mwpl_custom_message');
	register_setting('mwpl-settings-group2', 'mwpl_custom_message_alert');
	//Version 2.2
	register_setting('mwpl-settings-group2', 'mwpl_bgimage_left');
	register_setting('mwpl-settings-group2', 'mwpl_bgimage_top');
	//Version 2.2.4
	add_option('mwpl_upgrade_224',false);
	register_setting('mwpl-settings-group2', 'mwpl_upgrade_224');
	//Version 2.2.5
	add_option('mwpl_upgrade_225',false);
	register_setting('mwpl-settings-group2', 'mwpl_upgrade_225');
	//Version 2.2.8
	add_option('mwpl_font-size','24');
	register_setting('mwpl-settings-group2', 'mwpl_font_size');


	//SPECIAL REGISTERING OF OPTIONS
	if(get_option('mwpl_custom_bgimage_list') == '') {
		add_option('mwpl_custom_bgimage_list',array());
		register_setting('mwpl-settings-group2','mwpl_custom_bgimage_list');
	}

	//Google Analytics
	register_setting('mwpl-settings-group3','mwpl_google_analytics','mwpl_update_registry');

}

function mwpl_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	mwpl_dashBoardMenu();
}

function mwpl_blog_protection_dashboard() {
?>
<div class="wrap">
	<?php mwpl_donate_button(); ?>
	<h2><?php _e(MWPL_NAME); ?></h2>
	<form enctype="multipart/form-data" method="post" action="options.php">
		<?php settings_fields( 'mwpl-settings-group1' ); ?>
		<h3><?php _e( 'Login Page Settings' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Password Protected Blog'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_password_protected" value="1" <?php checked('1', get_option('mwpl_password_protected') ); ?>/></td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Hide Lost Password Link'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_hide_lost_password" value="1" <?php checked('1', get_option('mwpl_hide_lost_password') ); ?>/></td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Hide Login Messages/Errors'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_hide_login_messages" value="1" <?php checked('1', get_option('mwpl_hide_login_messages') ); ?>/></td>
			</tr>
			<?php
			$reg = get_option( 'mwpl_redirect_login' );
			if($reg == '') $reg = 'dashboard';
			?>
			<tr valign="top">
			<th scope="row"><?php _e( 'Redirect on login' ) ?></th>
			<td>
				<label><input name="mwpl_redirect_login" type="radio" id="redirect1" value="dashboard"<?php checked( $reg, 'dashboard') ?> /> <?php _e( 'Default Location. (<i>Dashboard is default</i>)' ); ?></label><br />
				<label><input name="mwpl_redirect_login" type="radio" id="redirect2" value="home"<?php checked( $reg, 'home') ?> /> <?php _e( 'Home Page.' ); ?></label><br />
				<label><input name="mwpl_redirect_login" type="radio" id="redirect3" value="profile"<?php checked( $reg, 'profile') ?> /> <?php _e( 'Profile Page.' ); ?></label><br />
				<!--<label><input name="mwpl_redirect_login" type="radio" id="redirect5" value="buddypress-profile"<?php checked( $reg, 'buddypress-profile') ?> /> <?php _e( 'BuddyPress Profile Page.' ); ?></label><br />-->
				<label><input name="mwpl_redirect_login" type="radio" id="redirect4" value="custom"<?php checked( $reg, 'custom') ?> /> <?php _e( 'Custom Page. ' ); ?></label>
				<input style="width:400px;" type="text" name="mwpl_custom_redirect_page" value="<?php echo get_option('mwpl_custom_redirect_page'); ?>" /><br />
				<p><?php _e( 'Changes the default redirect after a user logs in, to a different location you define.' ); ?></p>
			</td>
			</tr>

		</table>
		<p class="submit">
			<input style="margin:15px;" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
<?php
}



function mwpl_google_analytics_dashboard() {
	if (!get_option('mwpl_google_analytics')) update_option('mwpl_google_analytics',$mwpl_google_analytics);
	$google_registry = get_option('mwpl_google_analytics');
	//var_dump($google_registry);
	?>
	<div class="wrap">
		<?php mwpl_donate_button(); ?>
		<h2><?php _e(MWPL_NAME); ?></h2>
		<form enctype="multipart/form-data" method="post" action="options.php">
			<?php settings_fields( 'mwpl-settings-group3' ); ?>
				<h3><?php _e( 'Google Analytics Support' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Enable Google Analytics'); ?></th>
						<td>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_login]" value="1" <?php checked('1', $google_registry['enable_login'] ); ?>/> <?php _e('Login Page'); ?>&nbsp;&nbsp;&nbsp;</label>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_admin]" value="1" <?php checked('1', $google_registry['enable_admin'] ); ?>/> <?php _e('Admin Pages'); ?>&nbsp;&nbsp;&nbsp;</label>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_pages]" value="1" <?php checked('1', $google_registry['enable_pages'] ); ?>/> <?php _e('Everything Else'); ?>&nbsp;&nbsp;&nbsp;</label>
						<td>
					</tr>
					<tr valign="top">
						<th scope="row"></th>
						<td><label><i><?php _e('Your Goolge Analytics script can be found <a href=\'https://www.google.com/analytics/settings/\'>here</a>.');?></i></label></td>
					</tr>
					<tr>
						<th scope="row"><?php  _e('Google Analytics Script')?></th>
						<td>
							<textarea name="mwpl_google_analytics[google_script]" cols="60" rows="20"><?php echo $google_registry['google_script']; ?></textarea>
						</td>
					</tr>
				</table>
				<script>
					var value = jQuery(' :checkbox[name=mwpl_enable_form_bg]').is( ':checked');
					if(value) jQuery('#bgimage_box').css('display','block');
					jQuery(' :checkbox[name=mwpl_enable_form_bg]').click(function() {
						var value = jQuery(this).is( ':checked');
						if(value) jQuery('#bgimage_box').slideDown(500);
						else jQuery('#bgimage_box').slideUp(500);
					});
				</script>
			<p class="submit">
			<input style="margin:15px;" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
<?php
}

function mwpl_dashBoardMenu() {
global $mwpl_google_analytics;
mwpl_dashboard_css();
?>
<div class="wrap">
	<h2><?php _e(MWPL_NAME); ?></h2>
	<form enctype="multipart/form-data" method="post" action="options.php">
		<?php settings_fields( 'mwpl-settings-group' );?>
		<h3><?php _e( 'Login Page Settings' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Password Protected Blog'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_password_protected" value="1" <?php checked('1', get_option('mwpl_password_protected') ); ?>/></td>
			</tr>
			<?php
			if ( !get_site_option( 'mwpl_redirect_login' ) )
				update_site_option( 'mwpl_redirect_login', 'dashboard' );
			$reg = get_option( 'mwpl_redirect_login' );
			if (!get_option('mwpl_google_analytics'))
				update_option('mwpl_google_analytics',$mwpl_google_analytics);
			$google_registry = get_option('mwpl_google_analytics');

			?>
			<tr valign="top">
			<th scope="row"><?php _e( 'Redirect on login' ) ?></th>
			<td>
				<label><input name="mwpl_redirect_login" type="radio" id="redirect1" value="dashboard"<?php checked( $reg, 'dashboard') ?> /> <?php _e( 'Default Location. (<i>Dashboard is default</i>)' ); ?></label><br />
				<label><input name="mwpl_redirect_login" type="radio" id="redirect2" value="home"<?php checked( $reg, 'home') ?> /> <?php _e( 'Home Page.' ); ?></label><br />
				<label><input name="mwpl_redirect_login" type="radio" id="redirect3" value="profile"<?php checked( $reg, 'profile') ?> /> <?php _e( 'Profile Page.' ); ?></label><br />
				<label><input name="mwpl_redirect_login" type="radio" id="redirect4" value="custom"<?php checked( $reg, 'custom') ?> /> <?php _e( 'Custom Page. ' ); ?></label>
				<input style="width:400px;" type="text" name="mwpl_custom_redirect_page" value="<?php echo get_option('mwpl_custom_redirect_page'); ?>" /><br />
				<p><?php _e( 'Change the default redirect after a user logs in, to a different location in your blog.' ); ?></p>
			</td>
			</tr>
		</table>

		<h3><?php _e( 'Customize Login Page' ); ?></h3>
		<h5><i><?php _e( 'Warning: This part of the plugin uses javascript extensively to modify the WordPress login css file.  If you are worried about javascript being disabled this section is not for you.  Instead you could modify the plugins css file called memphis-wp-login.css in the plugin editor, which will have the same results.' ); ?></i></h5>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Enable Custom Login Page'); ?></th>
			<td>
				<input type="checkbox" name="mwpl_enable_custom_login" value="1" <?php checked('1', get_option('mwpl_enable_custom_login') ); ?>/>
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Background Color'); ?></th>
			<td>
				<label><input type="text" name="mwpl_custom_bgcolor" value="<?php echo get_option('mwpl_custom_bgcolor'); ?>" />  <i><?php _e('eg(#000000, #FFFFFF, #22FFCC, black, white, red)'); ?></i></label>
			</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Text Color'); ?></th>
				<td>
					<label><input type="text" name="mwpl_custom_textcolor" value="<?php echo get_option('mwpl_custom_textcolor'); ?>" />  <i><?php _e('eg(#000000, #FFFFFF, #22FFCC, black, white, red)'); ?></i></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Link Colors'); ?></th>
				<td>
					<label><i><?php _e('Normal:'); ?></i><input type="text" name="mwpl_custom_linkcolor_normal" value="<?php echo get_option('mwpl_custom_linkcolor_normal'); ?>" /> </label>
					<label><i><?php _e('Hover:'); ?></i><input type="text" name="mwpl_custom_linkcolor_hover" value="<?php echo get_option('mwpl_custom_linkcolor_hover'); ?>" /></label>
				</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Form Width'); ?></th>
			<td>
				<label><input style="width:50px" type="text" name="mwpl_form_width" value="<?php echo get_option('mwpl_form_width'); ?>" /><?php _e('%') ?></label>
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Form Height'); ?></th>
			<td>
				<label><input style="width:50px" type="text" name="mwpl_form_height" value="<?php echo get_option('mwpl_form_height'); ?>" /><?php _e('%') ?></label>
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Form Offset Left/Right'); ?></th>
			<td>
				<label><input style="width:50px" type="text" name="mwpl_form_offset_lr" value="<?php echo get_option('mwpl_form_offset_lr'); ?>" /><?php _e('px') ?></label>
			</td>
			</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Form Offset Top/Bottom'); ?></th>
			<td>
				<label><input style="width:50px" type="text" name="mwpl_form_offset_tb" value="<?php echo get_option('mwpl_form_offset_tb'); ?>" /><?php _e('px') ?></label>
			</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Hide Top Bar'); ?></th>
				<td>
					<input type="checkbox" name="mwpl_hide_top_bar" value="1" <?php checked('1', get_option('mwpl_hide_top_bar') ); ?>/>
				<td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Enable Form Background'); ?></th>
				<td>
					<input type="checkbox" name="mwpl_enable_form_bg" value="1" <?php checked('1', get_option('mwpl_enable_form_bg') ); ?>/>
				<td>
			</tr>
		</table>

	<div id="bgimage_box" class="postbox" style="display:none; margin: 10px; width:80%; clear:both;"><h3 class='' style="padding:10px; margin: 0px; cursor:default;"><span><?php _e('Background Images'); ?></span></h3>
		<div class="inside">
			<p><?php mwpl_get_bgimages() ?></p>
			<p  style="clear: both;"><br/></p>
			<form enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
				<input style="margin: 0 0 15px 15px;" type="file" name="image" id="image"/>
				<input type="hidden" name="file_upload" value="add_file" />
				<input type="submit" class="upload-primary" value="<?php _e('Upload File') ?>" />
			</form>
		</div>
	</div>
	<?php
		if (!get_option('mwpl_google_analytics'))
		update_option('mwpl_google_analytics',$mwpl_google_analytics);
	$google_registry = get_option('mwpl_google_analytics');
	//var_dump($google_registry);
	?>

				<h3><?php _e( 'Google Analytics Support' ); ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Enable Google Analytics'); ?></th>
						<td>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_login]" value="1" <?php checked('1', $google_registry['enable_login'] ); ?>/> <?php _e('Login Page'); ?>&nbsp;&nbsp;&nbsp;</label>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_admin]" value="1" <?php checked('1', $google_registry['enable_admin'] ); ?>/> <?php _e('Admin Pages'); ?>&nbsp;&nbsp;&nbsp;</label>
							<label><input type="checkbox" name="mwpl_google_analytics[enable_pages]" value="1" <?php checked('1', $google_registry['enable_pages'] ); ?>/> <?php _e('Everything Else'); ?>&nbsp;&nbsp;&nbsp;</label>
						<td>
					</tr>
					<tr valign="top">
						<th scope="row"></th>
						<td><label><i><?php _e('Your Goolge Analytics script can be found <a href=\'https://www.google.com/analytics/settings/\'>here</a>.');?></i></label></td>
					</tr>
					<tr>
						<th scope="row"><?php  _e('Google Analytics Script')?></th>
						<td>
							<textarea name="mwpl_google_analytics[google_script]" cols="60" rows="20"><?php echo $google_registry['google_script']; ?></textarea>
						</td>
					</tr>
				</table>
				<script>
					var value = jQuery(' :checkbox[name=mwpl_enable_form_bg]').is( ':checked');
					if(value) jQuery('#bgimage_box').css('display','block');
					jQuery(' :checkbox[name=mwpl_enable_form_bg]').click(function() {
						var value = jQuery(this).is( ':checked');
						if(value) jQuery('#bgimage_box').slideDown(500);
						else jQuery('#bgimage_box').slideUp(500);
					});
				</script>
			<p class="submit">
			<input style="margin:15px;" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
	</form>
<?php // WORK IN PROGRESS*** mwpl_css_editor(); ******////// ?>
</div>
<?php
}

function mwpl_get_bgimages() {
	$mwpl_bgimages = get_option('mwpl_custom_bgimage_list');
	array_multisort($mwpl_bgimages, SORT_DESC,SORT_NUMERIC);
	/*
	$index = 0;
	foreach($mwpl_bgimages as $image => $value) {
		$value['imagename'] = str_replace('/','',$value['imagename']);
		if(is_numeric($value['imagename'][0])) $value['imagename'] = substr($value['imagename'], 6);
		$mwpl_bgimages[$index]['imagename'] = $value['imagename'];
		$index++;
	}
	update_option('mwpl_custom_bgimage_list', $mwpl_bgimages);
	var_dump($mwpl_bgimages);
	*/
	foreach($mwpl_bgimages as &$key) {
		mwpl_get_bgimage_div($key);
	}

}

function mwpl_get_bgimage_div($image) {
	$imagename = $image['imagename'];
	$upload_dir = wp_upload_dir();
	//if(is_ssl() && !preg_match('/https/',$upload_dir['baseurl'])) $upload_dir['url'] = preg_replace('/http/','https',$upload_dir['url']);
	$reg = htmlspecialchars(get_option( 'mwpl_custom_bgimage' ));
	$image = htmlspecialchars(serialize($image));
	$nonce= wp_create_nonce  ('my-nonce');
	?>
		<div class="mwpl_bg_container">
			<p class="mwpl_bg_container_header">
				<label class="mwpl_bg_container_label">
				<input name="mwpl_custom_bgimage" type="radio" id="<?php echo $upload_dir['baseurl'].$imagename; ?>" value="<?php echo $image; ?>"<?php checked( $reg, $image); ?> /> <?php _e( 'Make This Your Background.' ); ?>
				</label><br />
			</p>
			<div class="mwpl_image_container"><img src='<?php echo $upload_dir['baseurl'].$imagename; ?>'/></div>
			<p class="mwpl_bg_container_footer">
				<table>
					<tr valign="top">
					<td>
						<label class="mwpl_bg_container_label">
						  <span class='delete'><a class='submitdelete' onclick='return showNotice.warn();' href='<?php bloginfo('siteurl'); echo '/wp-admin/admin.php?page=memphis-custom-login.php&amp;_wpnonce='; ?><?php echo $nonce ?>&amp;action=delete&amp;file=<?php echo $imagename; ?>'>Delete Permanently</a></span>
						   <br/>
						   <a class='submitdelete' href='<?php echo $upload_dir['baseurl'].$imagename; ?>'><?php _e('Download'); ?></a>
						</label>
					</td>
					</tr>
				</table>
			</p>
		</div>
	<?php
}
?>
