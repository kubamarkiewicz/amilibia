<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use Input;
use DB;
use Amilibia\Amilibia\Models\Product;
use RainLab\Translate\Classes\Translator;

class Products extends Controller
{

    public function index($locale)
    {
        Translator::instance()->setLocale($locale);

        $query = Product::with('icon')->with('image')->orderBy('sort_order', 'asc');

        $result = $query->get(); 

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}