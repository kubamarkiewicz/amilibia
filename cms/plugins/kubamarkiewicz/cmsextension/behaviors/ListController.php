<?php namespace KubaMarkiewicz\CmsExtension\Behaviors;

use Backend\Behaviors\ListController as BaseListController;


class ListController extends BaseListController
{

    /**
     * Select record on the list
     * @return void
     */
    public function listSelectRecord($recordId, $definition = null)   
    {
        if (!$definition || !isset($this->listDefinitions[$definition])) {
            $definition = $this->primaryDefinition;
        }

        $widget = $this->listWidgets[$definition];
        $widget->bindEvent('list.injectRowClass', function ($record) use ($recordId) {
            return $record->getKey() == $recordId ? 'active' : '';
        });  
    }

}
