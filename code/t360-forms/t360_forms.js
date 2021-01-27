function pretty_select() {
	jQuery('select').each(function() {
		$(this).wrap('<div class="t360-select"></div>');
		$(this).parent('.t360-select').append('<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve"><path d="M7.668 10.771L3.138 6.17c-.184-.184-.184-.48 0-.664l.277-.277c.184-.184.48-.184.664 0L8 9.224l3.921-3.991c.184-.184.48-.184.664 0l.277.277c.184.184.184.48 0 .664l-4.53 4.601c-.184.179-.48.179-.664-.004z"/></svg>');
	});
};

function pretty_checkbox() {
	jQuery('input[type="checkbox"]').each(function() {
		$(this).wrap('<div class="t360-checkbox"></div>');
		$(this).after('<label class="t360-checkbox-control" for="' + $(this).attr('id') + '"></label>');
		$(this).next('label').html('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 20 20" xml:space="preserve"><path d="M18 2v16H2V2h16m0-2H2C.895 0 0 .895 0 2v16c0 1.105.895 2 2 2h16c1.105 0 2-.895 2-2V2c0-1.105-.895-2-2-2z"/><path class="checkmark" d="M16.326 5.817l-.377-.38c-.208-.21-.548-.211-.758-.003l-7.296 7.238-3.08-3.105c-.208-.21-.548-.211-.758-.003l-.38.377c-.21.208-.211.548-.003.758l3.834 3.865c.208.21.548.211.758.003l8.057-7.993c.21-.208.211-.547.003-.757z"/></svg>');
	});
};

(function($) {

	pretty_select();
	pretty_checkbox();

})(jQuery);
