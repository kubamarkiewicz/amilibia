<?php namespace Amilibia\Amilibia\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Locations extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Amilibia.Amilibia', 'main-menu-item', 'side-menu-item3');
        $this->addCss('/plugins/amilibia/amilibia/assets/css/styles.css');
    }
}
