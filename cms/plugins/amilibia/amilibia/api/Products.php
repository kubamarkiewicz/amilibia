<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use Input;
use DB;
use Amilibia\Amilibia\Models\Product;
use RainLab\Translate\Classes\Translator;

class Products extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));
        
        $query = Product::where('published', '1')->with('icon')->with('images')->orderBy('sort_order', 'asc');

        $result = $query->get(); 

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}