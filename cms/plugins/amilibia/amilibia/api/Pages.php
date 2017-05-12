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
        $slugs = ['home', 'products', 'menu', 'footer'];

        Translator::instance()->setLocale($locale);

        $router = new Router(Theme::getActiveTheme());

        foreach ($slugs as $slug) {
            $page = $router->findByUrl('/'.$slug);
            if ($page) {
                $return[$slug] = $page->viewBag;
            }
        }
        
        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }


}