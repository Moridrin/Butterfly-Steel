<?php
/** @var $campaigns \App\Campaign[] */
?>
@extends('layouts.app')
@section('content')
    <div id="index-banner" class="parallax-container">
        <div class="section overlay-darken-2">
            <div class="container">
                <br><br>
                <h1 class="header center white-text">Butterfly-Steel</h1>
                <div class="row center">
                    <h5 class="header col s12 white-text">A map-centered place to manage your campaign.</h5>
                </div>
                <div class="row center">
                    @if(count($campaigns) > 0)
                        <a href="{{ $campaigns }}" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
                    @else
                        <a href="/campaign/new" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
                    @endif
                </div>
                <br><br>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_1.png') }}" alt="Unsplashed background img 1"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                @if(count($campaigns) > 0)
                    @foreach ($campaigns as $campaign)
                        <div class="col s12 m4">
                            <div class="icon-block">
                                <h2 class="center brown-text"><i class="material-icons">group</i></h2>
                                <h5 class="center"><a href="/campaign/{{ $campaign->id }}">{{ $campaign->title }}</a></h5>
                                <p class="light">{{ $campaign->description }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>You do not have any campaigns ready.</p>
                    <p>Create your first campaign <a href="/campaign/new">here</a>.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h5 class="header col s12 white-text">Use it during and in between sessions</h5>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_2.png') }}" alt="Unsplashed background img 2"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 center primary">
                    <h3><i class="mdi-content-send brown-text"></i></h3>
                    <h4>During a Session</h4>
                    <p class="left-align light">When you start a session, you can use the "Enable Session" switch on the campaign page to enable the session features. With this feature enabled, it is possible to move the movable objects (player icons, creatures, etc), hidden layers can now be revealed, and it shows the movement radius.</p>
                    <ul class="collapsible">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">desktop_windows</i>Display</div>
                            <div class="collapsible-body"><span>If you have just one normal screen (like a TV) to display your important information on, you can just display the map and control all the objects yourself.</span></div>
                        </li>
                        <li>
                            <div class="collapsible-header"><i class="material-icons">touch_app</i>Touch Screen</div>
                            <div class="collapsible-body row">
                                <div class="col s8">
                                    If you have a touchscreen you can specify which movable objects can be dragged and dropped by the touchscreen and which can only be dragged and dropped by the use of a mouse (the DM). This way you could let the players drag and drop the player icons but prevent them from moving the monsters.
                                </div>
                                <div class="col s4">
                                    <img src="{{ asset('images/TouchScreen.jpg') }}" style="width: 100%; height: auto;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header"><i class="material-icons">devices</i>Personal Screens</div>
                            <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h5 class="header col s12 light white-text">A modern responsive front-end framework based on Material Design</h5>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_3.png') }}" alt="Unsplashed background img 3"></div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.parallax').parallax();
            $('.button-side-nav').sideNav();
        });
    </script>
@endsection