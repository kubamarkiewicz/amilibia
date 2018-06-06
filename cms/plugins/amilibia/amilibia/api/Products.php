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

        if ($result) foreach ($result as $i => $item) {
            if ($item->icon) {
                $result[$i]['icon']['path_resized'] = $item->icon->getThumb(null, 160);
            }
            if ($item->images) foreach ($item->images as $j => $image) {
                $result[$i]['images'][$j]['path_resized'] = $image->getThumb(null, 400);
                $result[$i]['images'][$j]['path_resized_2x'] = $image->getThumb(null, 800);
            }
        }

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}