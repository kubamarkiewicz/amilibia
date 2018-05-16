<?php namespace KubaMarkiewicz\Pages\Api;

use Illuminate\Routing\Controller;
use KubaMarkiewicz\Pages\Models\Page;
use RainLab\Translate\Classes\Translator;
use Input;

class Pages extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));

        $query = Page::where('published', '1')->with('gallery');
        $result = $query->get(); 
        $pages = $result[0]->scopeGetNested($query);

        // add slug as key
        $return = [];
        if ($pages) foreach ($pages as $page) {
            if (!$page->meta_title) {
                $page->meta_title = $page->name;
            }
            $return[$page->slug] = $page;
        }

        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }


}