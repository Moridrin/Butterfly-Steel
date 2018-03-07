<?php
/** @var $campaigns \App\Campaign[] */
?>
@extends('layouts.app')
@section('content')
    <div id="index-banner" class="parallax-container">
        <div class="section overlay-darken-2">
            <div class="container">
                <br><br>
                <h1 class="header center white-text">Moridrin Dashboard</h1>
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
            <!--   Icon Section   -->
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
                    <h5 class="header col s12 white-text">A modern responsive front-end framework based on Material Design</h5>
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
                    <h4>Contact Us</h4>
                    <p class="left-align light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque
                        id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut
                        ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem
                        neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu
                        mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum
                        ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum
                        primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
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