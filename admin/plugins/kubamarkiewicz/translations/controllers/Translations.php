<?php namespace KubaMarkiewicz\Translations\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use KubaMarkiewicz\Translations\Widgets\TranslationsWidget;
use KubaMarkiewicz\Translations\Models\Translation;
use Yaml;


class Translations extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.ReorderController',
        // 'Backend.Behaviors.RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('KubaMarkiewicz.Translations', 'main-menu-item');

        if (post('form_mode')) {
            $this->asExtension('FormController')->create();
        }

        $formWidget = new TranslationsWidget($this);
        $formWidget->alias = 'formWidget';
        $formWidget->bindToController();
    }



    public function formExtendFields($form)
    {
        if ($form->data->type == Translation::TYPE_REPEATER) {

            $config = (array) Yaml::parse($form->data->config);
            $config['type'] = 'mlrepeater';

            $form->addFields([
                'translation' => $config
            ]);

        }
    }


    public function section()
    {
        /*
         * Make widget
         */
        $myWidget = new TranslationsWidget($this);
        $myWidget->bindToController();
        $this->vars['myWidget'] = $myWidget;

/*
            if ($row->type == Translation::TYPE_REPEATER) {

                $slug = 'translation_'.$row->id;


                $fields = [];
                if ($row->children) foreach ($row->children as $item) {

                    $field = [];
                    $field['label'] = $item->code;
                    switch ($item->type) {
                        case Translation::TYPE_RICHEDITOR:
                            $field['type'] = 'richeditor';
                            $field['size'] = 'small';
                            $field['toolbarButtons'] = 'paragraphFormat|bold|italic|clearFormatting|align|outdent|indent|formatOL|formatUL|insertHR|insertLink|insertFile|insertImage|insertVideo|insertTable|fullscreen|html';
                            break;
                        case Translation::TYPE_IMAGE_MEDIAFINDER:
                            $field['type'] = 'mediafinder';
                            $field['mode'] = 'image';
                            $field['imageWidth'] = '200';
                            $field['imageHeight'] = '100';
                            $field['thumbOptions'] = [
                                'mode' => 'auto', 
                                'extension' => 'auto'
                            ];
                            break;
                        default: // textarea
                            $field['type'] = 'textarea';
                            $field['size'] = 'tiny';
                            break;
                    }

                    $fields[$item->code] = $field;
                }

                    
                $config->fields[$slug] = [
                    'label' => '',
                    'type' => 'repeater',
                    'prompt' => 'Add banner',
                    'form' => [
                        'fields' => $fields
                    ]
                ];

                $config->data[$slug] = $row->translation;
            }
            else {

                $this->vars['forms'] = [];

                if ($row->children) foreach ($row->children as $item) if (!count($item->children)) {
                    

                    $config = new \stdClass;
                    $config->model = $item;
                    $config->fields = [];
                    $config->data = [];


                    $slug = 'translation_'.$item->id;
                    
                    $config->fields[$slug] = [];
                    switch ($item->type) {
                        case Translation::TYPE_RICHEDITOR:
                            $config->fields[$slug]['type'] = 'richeditor';
                            $config->fields[$slug]['size'] = 'small';
                            $config->fields[$slug]['toolbarButtons'] = 'paragraphFormat|bold|italic|clearFormatting|align|outdent|indent|formatOL|formatUL|insertHR|insertLink|insertFile|insertImage|insertVideo|insertTable|fullscreen|html';
                            break;
                        case Translation::TYPE_IMAGE_MEDIAFINDER:
                            $config->fields[$slug]['type'] = 'mediafinder';
                            $config->fields[$slug]['mode'] = 'image';
                            $config->fields[$slug]['imageWidth'] = '200';
                            $config->fields[$slug]['imageHeight'] = '100';
                            break;
                        case Translation::TYPE_IMAGE_UPLOAD:
                            // $slug = 'file_'.$item->id;
                            $slug = 'file';
                            $field = [];
                            $field['type'] = 'fileupload';
                            $field['mode'] = 'image';
                            $field['useCaption'] = 1;
                            $field['thumbOptions'] = [
                                'mode' => 'auto', 
                                'extension' => 'auto'
                            ];
                            $field['imageWidth'] = '200';
                            $field['imageHeight'] = '100';
                            $config->fields[$slug] = $field;
                            $config->model->$slug = $config->model->file;
                            $config->model->attachOne[$slug] = 'System\Models\File';
                            break;
                        default: // textarea
                            $config->fields[$slug]['type'] = 'textarea';
                            $config->fields[$slug]['size'] = 'tiny';
                            $item->translation = str_replace(["<br>", "<br/>", "<br />"], "", $item->translation);
                            break;
                    }
                    $config->fields[$slug]['label'] = $item->code;
                    $config->data[$slug] = $item->translation;
                    $config->model->translatable[] = $slug;


                    $form = $this->makeWidget('Backend\Widgets\Form', $config);
                    $form->bindToController();

                    $this->vars['forms'][] = $form;
                }
            }
*/
    }



    // implement "add child" action
    public function formExtendModel($model)
    {
        // set parent based on URL parameter
        if (isset($this->params[1])) {
            $model->parent_id = $this->params[1];
        }
    }
}