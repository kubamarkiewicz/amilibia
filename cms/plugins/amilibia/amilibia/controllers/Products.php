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
        
        // list widget
        $list = $this->makeList('list');
        $list->bindEvent('list.injectRowClass', function ($record) use ($id) {
            return $record->id == $id ? 'selected' : '';
        });
        $this->vars['list'] = $list;
        $this->vars['toolbar'] = $this->toolbarWidgets[$this->primaryDefinition];

        // $this->makeLists();

        return parent::update($id);
    }
}