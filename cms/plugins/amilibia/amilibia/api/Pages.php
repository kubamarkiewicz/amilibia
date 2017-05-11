<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use RainLab\Pages\Classes\Router;
use Cms\Classes\Theme;
use App;
use RainLab\Translate\Classes\Translator;

class Pages extends Controller
{

    public function index($locale)
    {
        Translator::instance()->setLocale($locale);

        $router = new Router(Theme::getActiveTheme());

        $slugs = ['home', 'products', 'menu', 'footer'];

        foreach ($slugs as $slug) {
            $page = $router->findByUrl('/'.$slug);
            if ($page) {
                $return[$slug] = $page->viewBag;
            }
        }
        
        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }



    public function find($locale, $slug = "")
    {
        Translator::instance()->setLocale('es');

        $router = new Router(Theme::getActiveTheme());
        $page = $router->findByUrl('/'.$slug);
        if (!$page) {
            return response()->json(null, 404);
        } 

        $return = $page->viewBag;

        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }


}