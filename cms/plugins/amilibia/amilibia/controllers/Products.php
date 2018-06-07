<?php namespace Amilibia\Amilibia\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Products extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'products' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Amilibia.Amilibia', 'main-menu-item', 'side-menu-item');
    }


    public function update($id = null)
    {
        /*
         * Prepare the list widget
         */
        $listWidget = $this->makeList('list');
        $listWidget->bindEvent('list.injectRowClass', function ($record) use ($id) {
            return $record->id == $id ? 'selected' : '';
        });
        $this->vars['list'] = $listWidget;
        
        /*
         * Prepare the toolbar widget
         */
        $toolbarConfig = $this->makeConfig($this->listGetConfig('list')->toolbar);
        $toolbarConfig->alias = $listWidget->alias . 'Toolbar';
        $toolbarWidget = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);
        $toolbarWidget->bindToController();
        // $toolbarWidget->cssClasses[] = 'list-header';
        $this->vars['toolbar'] = $toolbarWidget;

        parent::update($id);
    }


}