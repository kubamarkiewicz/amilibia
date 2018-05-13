

function multilingualFix()
{
	
	$('ul.ml-dropdown-menu *[data-switch-locale]').click(function(e, stopPropagation){

		if (!stopPropagation) {
			var selectedLocale = $(this).data('switch-locale');

			// save language to session
			window.sessionStorage.locale = selectedLocale;

			// switch other switches
			$('ul.ml-dropdown-menu *[data-switch-locale="'+selectedLocale+'"]').not(this).trigger('click', [true]);
		}

	});

} 


$(function() {

	multilingualFix();

});
