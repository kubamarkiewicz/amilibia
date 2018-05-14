<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use Input;
use DB;
use Amilibia\Amilibia\Models\Location;

class Locations extends Controller
{

    public function index()
    {
        $query = Location::where('published', '1');

        $result = $query->get(); 

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}