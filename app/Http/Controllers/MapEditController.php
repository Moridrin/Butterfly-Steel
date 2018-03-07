<?php

namespace App\Http\Controllers;

use App\Jobs\CreateImagePart;
use App\MapPart;
use Illuminate\Http\UploadedFile;
use Redirect;
use Validator;
use App\Map;
use Illuminate\Http\Request;

class MapEditController extends Controller
{
    public function show(int $mapId)
    {
        $map = Map::all()->keyBy('id')->get($mapId);
        return view('mapEditor')->with(['map' => $map]);
    }

    public function getTileForUpdate(int $id, Request $request)
    {
        $data = $request->validate([
            'zoom' => 'required|max:255',
            'x' => 'required|max:255',
            'y' => 'required|max:255',
            'depth' => 'required|max:255',
        ]);
        /** @var Map $map */
        $map = Map::all()->keyBy('id')->get($id);
        $sourceImage = $map->getImagePathFromCoordinates($data['zoom'], $data['x'], $data['y']);
        $zTarget = $data['zoom'] + $data['depth'];
        $leftEdges = [];
        $topEdges = [];
        $rightEdges = [];
        $bottomEdges = [];
        $tileCount = pow(2, $data['depth']);
        $leftEdgeX = ($data['x'] * pow(2, $data['depth'])) - 1;
        $topEdgeY = ($data['y'] * pow(2, $data['depth'])) - 1;
        $rightEdgeX = ($data['x'] * pow(2, $data['depth'])) + $tileCount;
        $bottomEdgeY = ($data['y'] * pow(2, $data['depth'])) + $tileCount;
        for ($i = 1; $i <= $tileCount; ++$i) {
            // Left Edge
            $image = $map->getImagePathFromCoordinates($zTarget, $leftEdgeX, $topEdgeY + $i);
            if ($image !== null) {
                $leftEdges[] = $image;
            }
            // Top Edge
            $image = $map->getImagePathFromCoordinates($zTarget, $leftEdgeX + $i, $topEdgeY);
            if ($image !== null) {
                $topEdges[] = $image;
            }
            // Right Edge
            $image = $map->getImagePathFromCoordinates($zTarget, $rightEdgeX, $topEdgeY + $i);
            if ($image !== null) {
                $rightEdges[] = $image;
            }
            // Bottom Edge
            $image = $map->getImagePathFromCoordinates($zTarget, $leftEdgeX + $i, $bottomEdgeY);
            if ($image !== null) {
                $bottomEdges[] = $image;
            }
        }

        $imageSize = 256 * $tileCount;
        $imageSizeWithEdge = $imageSize + 512;
        shell_exec('convert +repage "' . $sourceImage . '" -resize ' . $imageSize . 'x' . $imageSize . ' "start.png"');
        shell_exec('convert +repage "start.png" -gravity Center -extent ' . $imageSizeWithEdge . 'x' . $imageSizeWithEdge . ' "start.png"');
        shell_exec('convert -size ' . $imageSizeWithEdge . 'x' . $imageSizeWithEdge . ' xc:none "edges.png"');

        // Left Edge
        shell_exec('convert ' . implode(' ', $leftEdges) . ' -append "edge.jpg"');
        shell_exec('convert "edges.png" "edge.jpg" -gravity West -composite "edges.png"');
        // Top Edge
        shell_exec('convert ' . implode(' ', $topEdges) . ' +append "edge.jpg"');
        shell_exec('convert "edges.png" "edge.jpg" -gravity North -composite "edges.png"');
        // Right Edge
        shell_exec('convert ' . implode(' ', $rightEdges) . ' -append "edge.jpg"');
        shell_exec('convert "edges.png" "edge.jpg" -gravity East -composite "edges.png"');
        // Bottom Edge
        shell_exec('convert ' . implode(' ', $bottomEdges) . ' +append "edge.jpg"');
        shell_exec('convert "edges.png" "edge.jpg" -gravity South -composite "edges.png"');

        shell_exec('composite "edges.png" "start.png" -gravity Center "start.png"'); // TODO Replace with below
//    shell_exec('gimp -i -b \'(create-region-start-image "start.png" "edges.png" "start.xcf")\' -b \'(gimp-quit 0)\'');

        if (file_exists(public_path('edge.jpg'))) {
            unlink(public_path('edge.jpg'));
        }
        if (file_exists(public_path('edges.jpg'))) {
            unlink(public_path('edges.jpg'));
        }

        return response()->download(public_path('start.png'), implode('_', $data) . '.png');
    }


    public function uploadImage(int $mapId, Request $request)
    {
        $data = $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpeg',
                'max:200000',
                'dimensions:min_width=256,min_height=256,max_width=8192,max_height=8192',
            ],
            'z' => [
                'required',
                'digits_between:0,23',
            ],
            'x' => [
                'required',
                'digits_between:0,23',
            ],
            'y' => [
                'required',
                'digits_between:0,23',
            ],
        ]);
        /** @var UploadedFile $image */
        $image = $data['image'];
        list($width, $height) = getimagesize($image->getRealPath());
        dd($width);
        $depth = 1;
        $size = $width > $height ? $width : $height;
        while ($size >= 512) {
            $size /= 2;
            ++$depth;
        }
        $mapPart = tap(new MapPart(['depth' => $depth]))->save();
        $dir = resource_path('assets/images/map-parts/') . $mapPart->id;
        mkdir($dir.'/0/0/', 0777, true);
        $image->store($dir.'/0/0/', '0.jpg');
        /** @var Map $map */
        $map = Map::all()->keyBy('id')->get($mapId);
        $map->addMapPart($mapPart, $data['z'], $data['x'], $data['y'])->save();
        $this->dispatch(new CreateImagePart($mapPartId, $parts[4]));
        return view('mapPartCreationProgress')->with('mapPartId', $mapPartId)->with('mapId', $mapId);
    }

    public function removeMapPart(int $mapId, Request $request)
    {
        $data = $request->validate([
            'mapPartId' => 'required',
        ]);
        /** @var Map $map */
        $map = Map::all()->keyBy('id')->get($mapId);
        $map->removeMapPart($data['mapPartId'])->save();
        return Redirect::back();
    }

    public function getMapPartCreationProgress($mapPartId)
    {
        try {
            $overallMax = (int)file_get_contents(resource_path('assets/images/map-parts/' . $mapPartId . '/overallCountMax'));
            $overallCurrent = (int)file_get_contents(resource_path('assets/images/map-parts/' . $mapPartId . '/overallCurrent'));
            $depthMax = (int)file_get_contents(resource_path('assets/images/map-parts/' . $mapPartId . '/depthCountMax'));
            $depthCurrent = (int)file_get_contents(resource_path('assets/images/map-parts/' . $mapPartId . '/depthCurrent'));
            return json_encode(['overall' => (($overallCurrent / $overallMax) * 100) . '%', 'depth' => (($depthCurrent / $depthMax) * 100) . '%']);
        } catch (\Exception $exception) {
            return json_encode(['overall' => '0%', 'depth' => '0%']);
        }
    }

    public function finishMapPartCreation($mapPartId)
    {
        copy(resource_path('assets/images/map-parts/'.$mapPartId.'/0/0/0.jpg'), public_path('images/map-part-icons/'.$mapPartId.'.jpg'));
        unlink(resource_path('assets/images/map-parts/' . $mapPartId . '/overallCountMax'));
        unlink(resource_path('assets/images/map-parts/' . $mapPartId . '/overallCurrent'));
        unlink(resource_path('assets/images/map-parts/' . $mapPartId . '/depthCountMax'));
        unlink(resource_path('assets/images/map-parts/' . $mapPartId . '/depthCurrent'));
    }
}
