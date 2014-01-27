/* global ajaxurl */
jQuery(document).on('acf/setup_fields', function (e, div) {
	"use strict";
	var field = jQuery('.field_key-field_52acd1e345d61 input', div);
	field.suggest(ajaxurl + "?action=my-ajax-acf", { delay: 0, minchars: 1 });
});