<?php
function mwpl_custom_login_init() {
	$plugin_url = plugins_url('',__FILE__);
	wp_enqueue_script("jquery");
	wp_register_style( 'bootstrap.min.css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap.min.css' );
	wp_register_script( 'bootstrap.min.js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
	wp_enqueue_script( 'bootstrap.min.js' );
	wp_register_style( 'mwpl-style.css', $plugin_url.'/memphis-wp-login.css');
	wp_enqueue_style( 'mwpl-style.css' );
	wp_register_script('mwpl-script.js', $plugin_url.'/memphis-wp-login.js');
	wp_enqueue_script('mwpl-script.js');
	mwpl_add_inline_style('mwpl-style.css');
}
?>