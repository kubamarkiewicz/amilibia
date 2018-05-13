<?php namespace KubaMarkiewicz\Translations\Widgets;

use Backend\Classes\WidgetBase;
use KubaMarkiewicz\Translations\Models\Translation;
use Request;
use RainLab\Translate\Models\Locale;
use Config;
use Yaml;

class TranslationsWidget extends WidgetBase
{
	/**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'kubamarkiewicz_translations_widget';


    public function loadAssets()
    {
        $this->addCss('css/styles.css');
        $this->addJs('js/scripts.js');
    }


    public function render($pageSlug = null) 
    {
        $page = null;
        $id = null;
        $tree = null;
        if ($pageSlug) {
            // todo: add support for nested pages
            $parentId = Translation::where('code', 'pages')
                                    ->pluck('id')
                                    ->first();
            $page = Translation::where('code', $pageSlug)
                                ->where('parent_id', $parentId)
                                ->first();
            if ($page) {
                $tree = $page->children;
                $id = $page->id;
                $this->vars['children'] = $page->children;
                $this->vars['languages'] = Locale::listEnabled();
                $this->vars['lang'] = Request::input('lang') ? Request::input('lang') : Locale::getDefault()->code;
            }
        }
        else {
            $tree = Translation::select()->getNested();
        }
        $this->vars['tree'] = $tree;
        $this->vars['page'] = $page;

	    return $this->makePartial('widget');
    }



    public function onTreeItemSelect()
    {
        $model = Translation::find(Request::input('id'));
        if (!$model) {
            return;
        }

        $this->vars['children'] = $model->children;
        $this->vars['languages'] = Locale::listEnabled();
        $this->vars['lang'] = Request::input('lang') ? Request::input('lang') : Locale::getDefault()->code;

        return [
            '#kubamarkiewicz-translations-widget-children' => $this->makePartial('children')
        ];
    }



    public function onPreview()
    {
        $model = Translation::find(Request::input('id'));
        if (!$model) {
            return;
        }        
        
        $this->vars['item'] = $model;
        $this->vars['lang'] = Request::input('lang') ? Request::input('lang') : Locale::getDefault()->code;

        return [
            '#kubamarkiewicz-translations-widget-child-'.$model->id => $this->makePartial('preview')
        ];
    }



    public function onEdit()
    {
        $model = Translation::find(Request::input('id'));
        if (!$model) {
            return;
        }
        $this->vars['id'] = $model->id;

        /*
         * Make form widget
         */
        $config = new \stdClass;
        $config->model = $model;

        switch ($model->type) {
            case Translation::TYPE_RICHEDITOR: // rich editor
                $config->fields = [
                    'translation' => [
                        'label' => $model->code,
                        'type' => 'richeditor',
                        'size' => 'large',
                        'toolbarButtons' => 'paragraphFormat|bold|italic|clearFormatting|align|outdent|indent|formatOL|formatUL|insertHR|insertLink|insertFile|insertImage|insertVideo|insertTable|fullscreen|html'
                    ]
                ];
                $config->data = [
                    'translation' => $model->translation
                ];
                break;
            case Translation::TYPE_IMAGE_MEDIAFINDER:
                $config->fields = [
                    'translation' => [
                        'label' => $model->code,
                        'type' => 'mediafinder',
                        'mode' => 'image',
                        'imageWidth' => '200',
                        'imageHeight' => '100'
                    ]
                ];
                $config->data = [
                    'translation' => $model->translation
                ];
                break;
            case Translation::TYPE_IMAGE_UPLOAD: // image upload
                $config->fields = [
                    'image' => [
                        'label' => $model->code,
                        'type' => 'fileupload',
                        'mode' => 'image'
                    ]
                ];
                $config->data = [
                    'image' => $model->image
                ];
                break;
            case Translation::TYPE_REPEATER: 
                $fieldConfig = (array) Yaml::parse($model->config);
                $fieldConfig['type'] = 'repeater';
                $fieldConfig['label'] = $model->code;
                // dump($fieldConfig); exit;
                $config->fields = [
                    'translation' => $fieldConfig
                ];
                $config->data = [
                    'translation' => $model->translation
                ];
                break;
            default: // textarea
                $config->fields = [
                    'translation' => [
                        'label' => $model->code,
                        'type' => 'textarea',
                        'size' => 'tiny'
                    ]
                ];
                $config->data = [
                    'translation' => $model->translation
                ];
        }

        // $this->formWidget = $this->makeWidget('Backend\Widgets\Form');
        $form = $this->makeWidget('Backend\Widgets\Form', $config);
;
        $form->bindToController();
        $this->vars['form'] = $form;

        return [
            '#kubamarkiewicz-translations-widget-child-'.$model->id => $this->makePartial('edit')
        ];
    }



    public function onSave()
    {
        $data = post();

        // dump($data); exit;
        $model = Translation::find(Request::input('id'));

        if (!$model) {
            \Flash::error('Model not found');
            return;
        }

        // save non-translable value
        $model->translation = Request::input('translation');

        // save multilanguage values
        if (isset($data['RLTranslate'])) foreach ($data['RLTranslate'] as $lang => $translations) {
            $model->setTranslateAttribute('translation', $translations['translation'], $lang);
        }
        $model->save();

        \Flash::success(trans('backend::lang.form.update_success', ['name' => trans('kubamarkiewicz.pages::lang.page.tab_translations')]));


        $this->vars['item'] = $model;
        $this->vars['lang'] = Request::input('lang') ? Request::input('lang') : Locale::getDefault()->code;

        return [
            '#kubamarkiewicz-translations-widget-child-'.$model->id => $this->makePartial('preview')
        ];
    }
}