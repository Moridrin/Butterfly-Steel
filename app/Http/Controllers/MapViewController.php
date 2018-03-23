<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Map;

class MapViewController extends Controller
{
    public function show(int $id)
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::all()->keyBy('id')->get($id);
        /** @var Map $map */
        $map = Map::all()->keyBy('id')->get($campaign->map_id);
        return view('map')->with('map', $map);
    }

    public function getTile($id, $z, $x, $y)
    {
        $map       = Map::all()->keyBy('id')->get($id);
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
