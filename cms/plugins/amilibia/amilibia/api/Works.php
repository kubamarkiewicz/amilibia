<?php namespace Amilibia\Amilibia\Api;

use Illuminate\Routing\Controller;
use Input;
use DB;
use Amilibia\Amilibia\Models\Work;

class Works extends Controller
{

    public function index()
    {
        $query = Work::with('images')->orderBy('sort_order', 'asc');

        $result = $query->get(); 

        $images = [];

        if ($result) foreach ($result as $work) {
        	if ($work->images) foreach ($work->images as $image) {
        		$images[] = [
        						'title' => $work->name,
        						'path' => $image->path
        					];
        	}
        }

        return response()->json($images, 200, array(), JSON_PRETTY_PRINT);
    }

}