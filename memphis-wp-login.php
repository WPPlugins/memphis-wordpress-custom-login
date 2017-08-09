<?php
/*
Plugin Name: Memphis Custom Login
Plugin URI: http://www.kingofnothing.net
Description: A simple way to control your WordPress Login Page, features include Password Protected Blog, Custom Redirect after login, Changing the look of the Login Screen.
Author: Ian Howatson
Version: 3.2.7
Author URI: http://www.kingofnothing.net/
Date: 6/05/2017

Copyright 2017 Ian Howatson  (email : ian@howatson.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
include 'localization.php';
include 'mwpl-dashboard.php';
include 'mwpl-dashboard-custom-login.php';
include 'mwpl-init.php';
include 'mwpl-functions.php';
include 'mwpl-upgrade.php';
include 'mwpl-inline-style.php';
add_action('login_enqueue_scripts', 'mwpl_custom_login_init');
add_action( 'admin_enqueue_scripts', 'mwpl_dashboard_init' );
add_action('admin_menu', 'mwpl_dashboard_menu');
// REDIRECT AFTER LOGIN TO DIFFERENT PAGE
function mwpl_change_login_redirect() {
	global $redirect_to;
	$site_url = site_url();
	$redirect = get_option('mwpl_redirect_login');
	$custom_page = get_option('mwpl_custom_redirect_page');
	//echo $custom_page;
	switch($redirect) {
		case 'dashboard':
			break;
		case 'home':
			//if(!FORCE_SSL_LOGIN || FORCE_SSL_LOGIN == null) $site_url = preg_replace('/https/','http',MWPL_HOME_PAGE);
			//else $site_url = MWPL_HOME_PAGE;
			if ($redirect_to == $site_url.'/wp-admin/') { $redirect_to = $site_url; }
			break;
		case 'profile':
			if ($redirect_to == $site_url.'/wp-admin/') { $redirect_to = MWPL_PROFILE_PAGE; }
			break;
		//case 'buddypress-profile':
			//if ($redirect_to == $site_url.'/wp-admin/') { $redirect_to = bp_loggedin_user_domain($user->ID); }
			//break;
		case 'custom':
			//if(!FORCE_SSL_LOGIN && !preg_match('/wp-admin/',$custom_page)) $site_url = preg_replace('/https/','http',$site_url);
			//if(!FORCE_SSL_ADMIN) $site_url = preg_replace('/https/','http',$site_url);
			if ($custom_page != '') { $redirect_to = ($site_url.'/'.$custom_page); }
			break;
		default:
			break;
	}
}
add_action('login_form','mwpl_change_login_redirect');
//////////
//PASSWORD PROTECT SITE//
function mwpl_password_protected() {
	//Password Protected Blog
	$mwpl_password_protected = get_option('mwpl_password_protected',null);
	if(is_ssl()) $site_url = preg_replace('/http/','https',get_option('siteurl'));
	else $site_url == get_option('siteurl');
    if($mwpl_password_protected) {
	if (!is_user_logged_in() && $_SERVER['REQUEST_URI'] != "/") {

		wp_safe_redirect(get_bloginfo('wpurl').'/wp-login.php?redirect_to='.urlencode($_SERVER['REQUEST_URI']));
	} else if (!is_user_logged_in()) {
		wp_safe_redirect($site_url .'/wp-login.php');
	}
    }
}
function mwpl_bp_password_protected() {
	global $bp, $bp_unfiltered_uri;
	if(defined('BP_MEMBERS_SLUG') && defined('BP_GROUPS_SLUG')) {
		if (!is_user_logged_in() && (BP_MEMBERS_SLUG == $bp_unfiltered_uri[0] || BP_GROUPS_SLUG == $bp->current_component  )) {
			bp_core_redirect(get_bloginfo('wpurl') . '/wp-login.php');
		}
	}
}
add_action('login_head', 'rsd_link');
add_action('login_head', 'wlwmanifest_link');
add_action('template_redirect', 'mwpl_password_protected');
add_action('do_feed', 'mwpl_password_protected');
add_action( 'wp', 'mwpl_bp_password_protected', 3 );
///////// ADD GOOGLE ANALYTICS ///////
$google_reg = get_option('mwpl_google_analytics');
if($google_reg['enable_pages']) add_action('wp_head', 'mwpl_init_google_analytics');
if($google_reg['enable_login']) add_action('login_head', 'mwpl_init_google_analytics');
if($google_reg['enable_admin']) add_action('admin_head', 'mwpl_init_google_analytics');
////////////////////////////////////////
////////////////////////////////////////
///////// ADD CUSTOM DASHBOARD MESSAGE ///////
function my_admin_notice(){
?>
<div class="updated">
   <p><?php _e('<b>Important!!!</b><br/> Memphis Custom Wordpress Login Version 2.0 has been complete overhaul, you will need to redo your custom login screen.  This change was made to better match Wordpress functionality and style for easy of customization and easier updating in the future.'); ?></p>
</div>
<?php
}
//update_option('mwpl_admin_notice_00000001', false);
if(get_option('mwpl_admin_notice_00000001') != true) {
	add_action('admin_notices', 'my_admin_notice');
	update_option('mwpl_admin_notice_00000001', true);
}
////////////////////////////////////////
?>