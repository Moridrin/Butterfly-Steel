<?php

namespace App\Http\Controllers;

use App\Map;
use Illuminate\Http\Request;

class MapViewController extends Controller
{
    public function show(int $id)
    {
        /** @var Map $map */
        $map = Map::all()->keyBy('id')->get($id);
        return view('map')->with('map', $map);
    }

    public function getTile($id, $z, $x, $y)
    {
        $map = Map::all()->keyBy('id')->get($id);
        $imagePath = $map->getImagePathFromCoordinates($z, $x, $y);
        if ($imagePath) {
            header("content-type: image/jpg");
            readfile($imagePath);
        } else {
            http_response_code(404);
            die();
        }
    }
}
