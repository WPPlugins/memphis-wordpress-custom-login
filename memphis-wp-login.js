function mwpl_Edit_Login($custom_link, $custom_title, $custom_message, custom_message_type) {
    if($custom_link != '') {
	$custom_link = $custom_link.replace(/http:\/\//g, '');
	jQuery("#login h1 a").attr("href", "//"+$custom_link);
    }
    if ($custom_title != '') jQuery("#login h1 a").attr("title", $custom_title);
    if($custom_message != '') {
	var msg_type = 'info';
	if(custom_message_type == '1') msg_type = 'danger';
	jQuery("#login").append('\
	<br>\
	<div class="alert alert-'+msg_type+' alert-dismissible" role="alert">\
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
	    '+$custom_message+'\
	</div>'
	);
    }

}