
function saveAndCloseForms()
{
	$("#kubamarkiewicz-translations-widget > main article form input[name=lang]").val(window.sessionStorage.locale);
	$("#kubamarkiewicz-translations-widget > main article form").submit();
}


function widgetChangeLanguage(locale)
{
	if (!locale) {
		return;
	}

	// save language to session
	window.sessionStorage.locale = locale;

	// switch other switches
	$('ul.ml-dropdown-menu [data-switch-locale="'+locale+'"]').trigger('click', [true]);

	widgetSwitchLangSwitch(locale);

	// reload translations
	$('#kubamarkiewicz-translations-widget > main article section.preview').each(function(){
		var id = $(this).parent().data('id');
		$.request('onPreview', {data: {id: id, lang: locale}});
	});
}


function widgetSwitchLangSwitch(locale)
{
	$('#kubamarkiewicz-translations-widget .language-switch [data-switch-locale]').removeClass('active');
	$('#kubamarkiewicz-translations-widget .language-switch [data-switch-locale="'+locale+'"]').addClass('active');
}


function setFieldsLangFromSession() 
{
	if (window.sessionStorage.locale) {
		$('ul.ml-dropdown-menu [data-switch-locale="'+window.sessionStorage.locale+'"]').trigger('click', [true]);
	}
}


	
function onEditClick(ajaxHandler, id) 
{
	saveAndCloseForms();
	$.request(ajaxHandler, {data: {id: id}});
}


function onTreeItemClick(id)
{
	var item = $('#kubamarkiewicz-translations-widget > aside a[data-id='+id+']');
	item.addClass('selected');
	$('#kubamarkiewicz-translations-widget > aside a').not(item).removeClass('selected');
}



