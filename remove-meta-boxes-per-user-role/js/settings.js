/**
 * Managing "Check all"
 */
jQuery(document).ready(function() {
	jQuery('.check-all').click(function() {
		var rel = jQuery(this).attr("rel");
		var cases = jQuery("input[type='checkbox'][rel='" + rel + "']");
		if (jQuery(this).html() == rmbpur_check_all_label) {
			cases.attr('checked', true);
			jQuery(this).html(rmbpur_uncheck_all_label); 
		} else { 
			cases.attr('checked', false);
			jQuery(this).html(rmbpur_check_all_label);
		}
		return false;
	});
	jQuery('.check-all').each(function() {
		var rel = jQuery(this).attr("rel");
		if (jQuery("input[type='checkbox'][rel='" + rel + "']").length == jQuery("input[type='checkbox'][rel='" + rel + "']:checked").length)
			jQuery(this).trigger("click");
	});
});		

