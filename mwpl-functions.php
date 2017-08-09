<?php
function mwpl_donate_button() {
	?>
<div class="mwpl-donate-btn">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input name="cmd" type="hidden" value="_s-xclick" />
		<input name="encrypted" type="hidden" value="-----BEGIN PKCS7-----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-----END PKCS7----- " />
		<input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" type="image" />
		<img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1" border="0" />
	</form>
</div>
	<?php
}
function mwpl_find_bgimages($path, $pattern, $callback) {
  $path = rtrim(str_replace("\\", "/", $path), '/') . '/*';
  foreach (glob ($path) as $fullname) {
    if (is_dir($fullname)) {
      mwpl_find_bgimages($fullname, $pattern, $callback);
    } else if (preg_match($pattern, $fullname)) {
      call_user_func($callback, $fullname);
    }
  }
}
function mwpl_update_registry($input) {
	global $mwpl_google_analytics;
	$registry = get_option('mwpl_google_analytics');
	if($registry != '') {
	foreach ($mwpl_google_analytics  as $option => $option_value) {
		if(isset($input[$option])) {
			if($input[$option]) {
				//echo "value: " .$input[$option]."<br/>";
				$registry[$option] = $input[$option]; }
			else $registry[$option] = $mwpl_google_analytics[$option];
		} else $registry[$option] = false;
	}
	//print_r($input);
	return $registry;
	} else return $mwpl_google_analytics;
}
function mwpl_init_google_analytics() {
  $google_reg = get_option('mwpl_google_analytics');
  echo $google_reg['google_script'];
}
?>