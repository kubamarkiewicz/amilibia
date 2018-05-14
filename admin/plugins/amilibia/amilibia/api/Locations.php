<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use Input;
use DB;
use Amilibia\Amilibia\Models\Location;
use RainLab\Translate\Classes\Translator;


class Locations extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));
        
        $query = Location::where('published', '1');

        $result = $query->get(); 

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}