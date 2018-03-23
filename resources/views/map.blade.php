<?php
$activeForm = 'addMapPartForm';
/** @var \Illuminate\Support\MessageBag $errors */
if ($errors->hasAny(['zoom', 'x', 'y', 'depth'])) {
    $activeForm = 'getTileForUpdate';
} elseif ($errors->has('mapPartId')) {
    $activeForm = 'removeMapPart';
}
?>
@extends('layouts.app')
@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{ asset('css/map.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/contextMenu.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/ol.css') }}" type="text/css">
    <script src="{{ asset('js/map/ol.js') }}" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@endsection
@section('content')
    <div id="fullScreen" class="fullScreen">
        <div id="map" class="map" style="background: black; width: 100%;"></div>
        <div class="ol-unselectable ol-control" style="top: 86px; left: 8px;">
            <button id="showScale" onclick="showScale(this)" type="button" title="Scale" style="width: 50px;">Scale
            </button>
            <button id="showGrid" onclick="showGrid(this)" type="button" title="Grid" style="width: 50px;">Grid</button>
        </div>
        <div id="coordinates"></div>
        <div id="scale-container" style="display: none" draggable="true">
            <div id="scale">50 miles</div>
        </div>
        <div style="display: block;" id="labels"></div>
        <div id="movableObjects"></div>
        <div id="developerToggle"></div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').material_select();
        });
    </script>
    <?php
    $x = isset($_GET['x']) ? $_GET['x'] : 21800322;
    $y = isset($_GET['y']) ? $_GET['y'] : 345130393;
    $z = isset($_GET['z']) ? $_GET['z'] : 0;
    $showScale = isset($_GET['showScale']) ? $_GET['showScale'] : 0;
    $develop = isset($_GET['develop']) ? $_GET['develop'] : 0;
    $grid = isset($_GET['grid']) ? $_GET['grid'] : 0;
    ?>
    <script src="{{ asset('js/map/contextMenu.js') }}"></script>
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
        let mapTileGrid = new ol.tilegrid.TileGrid({
            extent: [extendModifier * -1, extendModifier * -1, extendModifier, extendModifier],
            minZoom: mapMinZoom,
            resolutions: mapResolutions
        });

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
    <script src="{{ asset('js/map/hiddenLayers.js') }}"></script>
    <script src="{{ asset('js/map/map-tools.js') }}"></script>
    <script src="{{ asset('js/map/movableObjects.js') }}"></script>
    @if ($grid)
        <script type="application/javascript">
            showGrid(document.getElementById('showGrid'));
        </script>
    @endif
@endsection
