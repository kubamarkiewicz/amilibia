<?php namespace Amilibia\Amilibia;

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
                'label'       => 'Settings',
                'description' => 'Manage custom settings.',
                'category'    => 'Amilibia Settings',
                'icon'        => 'icon-cog',
                'class'       => 'Amilibia\Amilibia\Models\Settings',
                'order'       => 0,
                'keywords'    => 'security location',
                'permissions' => ['products']
            ]
        ];
    }
}
