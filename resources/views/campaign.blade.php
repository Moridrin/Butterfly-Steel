@extends('layouts.app')
@section('content')
    <div id="index-banner" style='background-image: url("{{ asset('images/ScreenShot_1.png') }}"); position: absolute; width: 100%; height: 100%;'>
        <div class="overlay-darken-2 valign-wrapper">
            <div style="width: 100%;">
                <br><br>
                <h1 class="header center white-text">{{ $campaign->title }}</h1>
                <div class="row center">
                    <h5 class="header col s12 white-text">{{ $campaign->description }}</h5>
                </div>
                <div class="row center">
                    <a href="/map/{{ $campaign->id }}" class="btn-large waves-effect waves-light">Open Map</a>
                    <a href="/map/{{ $campaign->id }}/edit" class="btn-large waves-effect waves-light">Edit Map</a>
                </div>
                <br><br>
            </div>
        </div>
    </div>
@endsection
