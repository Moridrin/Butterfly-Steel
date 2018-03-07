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
    <div id="spinner" class="center-align">
        <h3>Initializing</h3>
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="progress" class="center-align" style="display: none;">
        <h3>Progress</h3>
        <div class="progress" id="addMapPartOverallProgress">
            <div class="determinate" style="width: 0"></div>
        </div>
        <div class="progress" id="addMapPartDepthProgress">
            <div class="determinate" style="width: 0"></div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        let initializing = true;
        setInterval(function () {
            $.ajax({
                url: "/map-part/{{ $mapPartId }}/get-creation-progress",
                success: function (percentages) {
                    percentages = JSON.parse(percentages);
                    if (initializing && percentages['overall'] !== '0%') {
                        $('#spinner').hide();
                        $('#progress').show();
                        initializing = false;
                    }
                    $('#addMapPartOverallProgress').find('.determinate').css('width', percentages['overall']);
                    if (percentages['overall'] === '100%') {
                        $.ajax({
                            url: "/map-part/{{ $mapPartId }}/finish-creation",
                            success: function () {
                                window.location = '/map/{{ $mapId }}/edit';
                            }
                        });
                    }
                    $('#addMapPartDepthProgress').find('.determinate').css('width', percentages['depth']);
                }
            });
        }, 500);
    </script>
@endsection
