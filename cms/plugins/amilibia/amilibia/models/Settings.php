<?php namespace Amilibia\Amilibia\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'acme_demo_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

}