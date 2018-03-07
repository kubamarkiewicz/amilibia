<?php namespace Amilibia\Amilibia;

use System\Classes\PluginBase;
use Event;

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

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->removeMainMenuItem('October.Cms', 'cms');
                //$manager->removeMainMenuItem('October.Cms', 'media');
            $manager->removeMainMenuItem('October.Backend', 'media');
            $manager->removeMainMenuItem('October.Backend', 'dashboard');
        });
    }
}
