<?php namespace KubaMarkiewicz\Pages\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use KubaMarkiewicz\Translations\Widgets\TranslationsWidget;

class Pages extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.ReorderController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'manage_pages' 
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addJs('/plugins/kubamarkiewicz/pages/assets/js/functions.js');

        BackendMenu::setContext('KubaMarkiewicz.Pages', 'main-menu-item');

        $translationsWidget = new TranslationsWidget($this);
        $translationsWidget->alias = 'translationsWidget';
        $translationsWidget->bindToController();
    }


    public function formExtendModel($model)
    {
        // get parent ID from URL parameter
        if (isset($this->params[1])) {
            $model->parent_id = $this->params[1];
        }
    }




}