<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Map
 *
 * @property int                 $id
 * @property mixed               $map_parts
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereMapParts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int                 $last_zoom
 * @property int                 $last_depth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereLastDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereLastZoom($value)
 */
class Map extends Model
{
    protected $fillable = ['map_parts'];

    public function getMinZ(): int
    {
        $mapParts = $this->getMapParts();
        $minZ     = 0;
        foreach ($mapParts as $mapPart) {
        }
        return $minZ;
    }

    public function getMapParts(): array
    {
        return json_decode($this->getAttribute('map_parts'), true);
    }

    public function getMaxZ(): int
    {
        $mapParts = $this->getMapParts();
        $maxZ     = 0;
        foreach ($mapParts as $mapPart) {
        }
        return $maxZ;
    }

    public function setMapParts(array $mapParts): self
    {
        $this->setAttribute('map_parts', json_encode($mapParts));

        return $this;
    }

    public function addMapPart(MapPart $mapPart, int $z, int $x, int $y): self
    {
        $mapParts               = json_decode($this->getAttribute('map_parts'), true);
        $mapParts[$mapPart->id] = [
            'id'          => $mapPart->id,
            'coordinates' => [
                'z' => $z,
                'x' => $x,
                'y' => $y,
            ],
            'depth'       => $mapPart->depth,
        ];
        $this->setAttribute('map_parts', json_encode($mapParts));

        return $this;
    }

    public function removeMapPart($id): self
    {
        $mapParts = json_decode($this->getAttribute('map_parts'), true);
        unset($mapParts[$id]);
        $this->setAttribute('map_parts', json_encode($mapParts));

        return $this;
    }

    public function getImagePathFromCoordinates($z, $x, $y): ?string
    {
        $mapParts = json_decode($this->getAttribute('map_parts'), true);
        foreach ($mapParts as $mapPart) {
            $zRelative = $z - $mapPart['coordinates']['z'];
            $partX     = $mapPart['coordinates']['x'] * pow(2, $zRelative);
            $partY     = $mapPart['coordinates']['y'] * pow(2, $zRelative);
            $xRelative = $x - $partX;
            $yRelative = $y - $partY;
            $filePath  = resource_path() . '/assets/images/map-parts/' . $mapPart['id'] . '/' . $zRelative . '/' . $xRelative . '/' . $yRelative . '.jpg';
            if (file_exists($filePath)) {
                return $filePath;
            }
        }
        return null;
    }
}
