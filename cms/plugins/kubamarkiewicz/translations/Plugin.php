<?php namespace KubaMarkiewicz\Translations;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerFormWidgets()
	{
	    return [
	        'KubaMarkiewicz\Translations\FormWidgets\TranslationsSection' => 'kubamarkiewicz_translations_section'
	    ];
	}


    public function boot()
    {
        // Check if we are currently in backend module.
        if (!\App::runningInBackend()) {
            return;
        }

        // Listen for `backend.page.beforeDisplay` event and inject js to current controller instance.
        \Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            $controller->addJs('/plugins/kubamarkiewicz/translations/assets/js/multilingual-fix.js');
        });
    }

}
