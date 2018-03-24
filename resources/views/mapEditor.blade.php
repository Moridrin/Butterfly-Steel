<?php
$hasMapParts = !empty($map->getMapParts());
$activeForm = !$hasMapParts ? 'addMapPartForm' : 'getTileForUpdate';
/** @var \Illuminate\Support\MessageBag $errors */
if ($errors->hasAny(['z', 'x', 'y', 'depth'])) {
    $activeForm = 'addMapPartForm';
} elseif ($errors->has('mapPartId')) {
    $activeForm = 'removeMapPart';
}
?>
@extends('layouts.app')
@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/map.css') }}" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@endsection
@section('content')
    <div class="row" style="height: 100%; margin-bottom: 0; width: 100%;">
        <div class="col s12 m8" style="position: absolute; height: 100%; padding: 0;">
            <div id="map" class="map" style="background: black; width: 100%;"></div>
        </div>
        <div id="mapEditor" class="col s12 m4" style="float: right;">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header{{ $activeForm === 'getTileForUpdate' ? ' active' : '' }}">
                        <i class="material-icons">place</i>Get Tile for Update
                    </div>
                    <div class="collapsible-body">
                        @if ($hasMapParts)
                            <form id="getTileForUpdate" action="/map/{{ $map->id }}/get-tile-for-update" method="post">
                                {!! csrf_field() !!}
                                <label>Z Range</label><br/><br/>
                                <div id="zSlider" class=""></div>
                                <br/>
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div class="input-field{{ $errors->has('x') ? ' invalid' : '' }} validate">
                                            <input type="number" class="form-control" id="x" name="x" value="{{ old('x') }}" min="{{ $map->getMinZ() }}" max="{{ $map->getMaxZ() }}" required>
                                            <label for="x">X</label>
                                            @if($errors->has('x'))
                                                <span class="help-block">{{ $errors->first('x') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <div class="input-field{{ $errors->has('y') ? ' invalid' : '' }} validate">
                                            <input type="number" class="form-control" id="y" name="y" value="{{ old('y') }}" min="{{ $map->getMinZ() }}" max="{{ $map->getMaxZ() }}" required>
                                            <label for="y">Y</label>
                                            @if($errors->has('y'))
                                                <span class="help-block">{{ $errors->first('y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-default">Download</button>
                            </form>
                        @else
                            <em>Start by adding a map part first.</em>
                        @endif
                    </div>
                </li>
                <li>
                    <div class="collapsible-header{{ $activeForm === 'addMapPartForm' ? ' active' : '' }}">
                        <i class="material-icons">place</i>Add Map Part
                    </div>
                    <div class="collapsible-body">
                        <h5 style="margin-top: 0;">Browse</h5>
                        // TODO
                        <h5>From File</h5>
                        <form id="addMapPartForm" action="/map/{{ $map->id }}/map-part/upload-image" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="image">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate{{ $errors->has('image') || $errors->has('filename') ? ' invalid' : '' }}" type="text" required>
                                    @if($errors->has('image'))
                                        <span class="help-block">{{ $errors->first('image') }}</span>
                                    @endif
                                    @if($errors->has('width'))
                                        <span class="help-block">{{ $errors->first('width') }}</span>
                                    @endif
                                    @if($errors->has('height'))
                                        <span class="help-block">{{ $errors->first('height') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 l4">
                                    <div class="input-field{{ $errors->has('z') ? ' invalid' : '' }} validate">
                                        <label for="z">Z</label><br/>
                                        <input class="form-control" id="z" name="z" value="{{ old('z') }}" required>
                                        @if($errors->has('z'))
                                            <span class="help-block">{{ $errors->first('z') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col s12 l4">
                                    <div class="input-field{{ $errors->has('x') ? ' invalid' : '' }} validate">
                                        <label for="x">X</label><br/>
                                        <input class="form-control" id="x" name="x" value="{{ old('x') }}" required>
                                        @if($errors->has('x'))
                                            <span class="help-block">{{ $errors->first('x') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col s12 l4">
                                    <div class="input-field{{ $errors->has('y') ? ' invalid' : '' }} validate">
                                        <label for="y">Y</label><br/>
                                        <input class="form-control" id="y" name="y" value="{{ old('y') }}" required>
                                        @if($errors->has('y'))
                                            <span class="help-block">{{ $errors->first('y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Add</button>
                        </form>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header{{ $activeForm === 'removeMapPart' ? ' active' : '' }}">
                        <i class="material-icons">place</i>Remove Map Part
                    </div>
                    <div class="collapsible-body">
                        @if ($hasMapParts)
                            <form id="removeMapPart" action="/map/{{ $map->id }}/remove-map-part" method="post" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="input-field">
                                    <select class="icons validate{{ $errors->has('mapPartId') ? ' invalid' : '' }}" name="mapPartId">
                                        @foreach($map->getMapParts() as $mapPart)
                                            <?php $coordinatesString = $mapPart['coordinates']['x'] . ' ; ' . $mapPart['coordinates']['y'] . ' ; ' . $mapPart['coordinates']['z']; ?>
                                            <option value="{{ $mapPart['id'] }}" data-icon="{{ '/images/map-part-icons/'.$mapPart['id'].'.jpg' }}" class="">
                                                [{{ $coordinatesString }}]
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Images in select</label>
                                    @if($errors->has('mapPartId'))
                                        <span class="help-block">{{ $errors->first('mapPartId') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-default red">Remove</button>
                            </form>
                        @else
                            <em>Start by adding a map part first.</em>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="ol-unselectable ol-control" style="top: 86px; left: 8px;">
        <button id="showScale" onclick="showScale(this)" type="button" title="Scale" style="width: 50px;">Scale</button>
        <button id="showGrid" onclick="showGrid(this)" type="button" title="Grid" style="width: 50px;">Grid</button>
    </div>
    <div id="coordinates"></div>
    <div id="scale-container" style="display: none" draggable="true">
        <div id="scale">50 miles</div>
    </div>
    <div style="display: block;" id="labels"></div>
    <div id="movableObjects"></div>
    <div id="developerToggle"></div>
@endsection
@section('js')
    <script>
        var slider = document.getElementById('zSlider');
        if (slider) {
            noUiSlider.create(slider, {
                start: [<?= $map->last_zoom ?>, <?= $map->last_depth ?>],
                connect: true,
                step: 1,
                orientation: 'horizontal',
                margin: 1,
                limit: 6,
                range: {
                    'min': 0,
                    'max': 23
                },
                format: wNumb({
                    decimals: 0
                })
            });
        }
    </script>
    <?php
    $x = isset($_GET['x']) ? $_GET['x'] : 21800322;
    $y = isset($_GET['y']) ? $_GET['y'] : 345130393;
    $z = isset($_GET['z']) ? $_GET['z'] : 0;
    $showScale = isset($_GET['showScale']) ? $_GET['showScale'] : 0;
    $develop = isset($_GET['develop']) ? $_GET['develop'] : 1;
    $grid = isset($_GET['grid']) ? $_GET['grid'] : 1;
    ?>
    {{--    <script src="{{ asset('js/map/contextMenu.js') }}"></script>--}}
    <script type="text/javascript">
        let sessionActive = false;
        // Resolution
        let mapMinZoom = 0;
        let mapMaxZoom = 23;
        let mapMaxResolution = 1.00000000;
        let mapResolutions = [];
        for (let z = mapMinZoom; z <= mapMaxZoom; z++) {
            mapResolutions.push(Math.pow(2, mapMaxZoom - z) * mapMaxResolution);
        }
        let extendModifier = Math.pow(2, mapMaxZoom - 1) * 256;

        let mapId = <?= $map->id ?>;
        let centerZ = <?= $z ?>;
        let centerX = <?= $x ?>;
        let centerY = <?= $y ?>;
        let develop = <?= $develop ?>;
        let scale = <?= $showScale ?>;
        let serverName = "<?= $_SERVER['SERVER_NAME'] ?>";
        let gridLayer = null;
        let movableObjects = [];
    </script>
    {{--<script src="{{ asset('js/map/hiddenLayers.js') }}"></script>--}}
    {{--<script src="{{ asset('js/map/map-tools.js') }}"></script>--}}
    {{--<script src="{{ asset('js/map/movableObjects.js') }}"></script>--}}
    <script src="{{ asset('js/map.js') }}" type="text/javascript"></script>
    @if ($grid)
        <script type="application/javascript">
            // showGrid(document.getElementById('showGrid'));
        </script>
    @endif
@endsection
