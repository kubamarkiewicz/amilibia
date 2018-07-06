<?php namespace KubaMarkiewicz\CmsExtension;

use System\Classes\PluginBase;
use App;
use Event;
use Block;
use Backend\Models\BrandSetting;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
	{
	    // Check if we are currently in backend module.
	    if (!App::runningInBackend()) {
	        return;
	    }

	    // Listen for `backend.page.beforeDisplay` event and inject css to current controller instance.
	    Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
	        $controller->addCss('/plugins/kubamarkiewicz/cmsextension/assets/css/styles.css');
	        Block::append('head', '<style>:root { --secondary-color: '.BrandSetting::get('secondary_color').';}</style>');
    	});

    	
    	// BrandSetting::get('secondary_color')
    }
}
