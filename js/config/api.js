
/* This file has to loaded before app.js */

window.config = window.config || {};

window.config.defaultLanguage = 'es';

window.config.api = {

	"urls" : {
        "getPages"              : "admin/api/pages",
        "getTranslations"		: "admin/api/translations",
        "missingTranslations"	: "admin/api/translations",
        "getProducts"           : "admin/api",
        "getWorks"           	: "admin/api/works",
        "sendContact"          	: "admin/api/contact"
	}

}