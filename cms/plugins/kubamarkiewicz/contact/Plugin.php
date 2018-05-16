<?php namespace KubaMarkiewicz\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }



    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'kubamarkiewicz.contact::lang.settings.label',
                'description' => '',
                'category'    => 'kubamarkiewicz.contact::lang.settings.category',
                'icon'        => 'icon-envelope-o',
                'class'       => 'KubaMarkiewicz\Contact\Models\Settings',
                'order'       => 0,
                'keywords'    => ''
            ]
        ];
    }
}
