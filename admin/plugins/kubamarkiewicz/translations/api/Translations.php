<?php namespace KubaMarkiewicz\Translations\Api;

use Illuminate\Routing\Controller;
use KubaMarkiewicz\Translations\Models\Translation;
use RainLab\Translate\Classes\Translator;
use DB;
use Input;
use ToughDeveloper\ImageResizer\Classes\Image;

class Translations extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));

        $query = Translation::select();
        $result = $query->get(); 

        $return = [];

        foreach ($result as $item) {
            // echo '<br>id: '.$item->id;
            $path = explode('.', $item->key);
            $parent = &$return;
            foreach ($path as $slug) if ($slug) { 
                $parent = (array) $parent;
                $parent = &$parent[$slug];
            }
            $value = $item->translation;
            switch ($item->type) {
                case Translation::TYPE_IMAGE_MEDIAFINDER:
                    $file = \Config::get('cms.storage.media.path').$item->translation;
                    if (file_exists(base_path().$file) && $item->parameters && $item->parameters['width'] && $item->parameters['height']) {
                        $image = new Image($file);
                        $image->resize($item->parameters['width'], $item->parameters['height'], ['mode' => isset($item->parameters['mode']) ? $item->parameters['mode'] : 'auto']);
                        $value = (string) $image;
                    }
                    else {
                        $value = url($file);
                    }
                    break;
/*                case Translation::TYPE_IMAGE_UPLOAD:
                    $value = $item->file ? $item->file->getPath() : '';
                    break;*/
            }
            $parent = $value;
        }

        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }



    public function add()
    {
        // dump(post()); exit;

        $codes = post('codes');
        $types = post('types');
        $translations = post('translations');
        $parameters = post('parameters');


        if ($codes) foreach ($codes as $i => $code) {

            // find ancestors
            $parent_id = 0;
            $parts = explode('.', $code);
            $slug = array_pop($parts);
            if ($parts) foreach ($parts as $part) {
                $parent = Translation::where('code', $part)->where('parent_id', $parent_id)->first();

                if ($parent) {
                    $parent_id = $parent->id;
                }
                else {
                    $parent = new Translation();
                    $parent->code = $part;
                    $parent->parent_id = $parent_id;
                    $parent->save();
                    $parent_id = $parent->id;
                }
            }      

            $translation = Translation::where('code', $part)->where('parent_id', $parent_id)->first();
            if (!$translation) {
                $translation = new Translation();
                $translation->code = $slug;
                $translation->parent_id = $parent_id;
                $translation->translation = $translations[$i];
                $translation->type = $types[$i];
                $translation->parameters = isset($parameters[$i]) ? $parameters[$i] : null;
                $translation->save();
            }

        }


    }



}