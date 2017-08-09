var color_options = {
    change: function(event, ui) {
	var element = jQuery(this).prop('id');
	if (element == 'bg-color-mdocs-picker') {
	    button_bg_color_normal = ui.color.toString();
	    jQuery('.mdocs-download-btn-config').css('background', button_bg_color_normal);
	} else if (element == 'bg-hover-color-mdocs-picker') button_bg_color_hover = ui.color.toString();
	if (element == 'bg-text-color-mdocs-picker') {
	    button_text_color_normal = ui.color.toString();
	    jQuery('.mdocs-download-btn-config').css('color', button_text_color_normal);
	} else if (element == 'bg-text-hover-color-mdocs-picker') button_text_color_hover = ui.color.toString();
    }
}
jQuery('[id$="mwpl-picker"]').wpColorPicker(color_options);