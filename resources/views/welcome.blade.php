<?php
/** @var $campaigns \App\Campaign[] */
?>
@extends('layouts.app')
@section('content')
    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <h1 class="header center white-text">Butterfly-Steel</h1>
                <div class="row center">
                    <h5 class="header col s12 white-text">A map-centered place to manage your campaign.</h5>
                </div>
                <div class="row center">
                    <a href="/campaign/new" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_1.png') }}" alt="Screenshot"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 l4" style="padding: 0;">
                    <div class="hide-on-med-and-down" style="height: 25px;"></div>
                    <div class="card sticky-action hoverable" style="position: relative;">
                        <a href="#prepaid" class="card-content center-align modal-trigger">
                            <span class="card-title">Prepaid</span>
                            <div class="card secondary">
                                <p style="padding: 5px;">$0.50 / hour</p>
                            </div>
                            <p class="light">For parties that only play once a decade.</p>
                            <ul class="checkedList left-align">
                                <li>No monthly cost</li>
                                <li>Pay only for what you need</li>
                            </ul>
                        </a>
                        <div class="card-action"><a href="" class="">Buy Now</a></div>
                    </div>
                </div>
                <div id="prepaid" class="modal">
                    <div class="modal-content">
                        <h4>Prepaid</h4>
                        <p>If you don't want to be tied down to a monthly subscription, you can use this prepaid option to buy time to use the service.</p>
                        <p>You can buy time per 8 hours for $4.00 ($0.50 per hour).</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Buy Now</a>
                    </div>
                </div>
                <div class="col s12 l4" style="padding: 0;">
                    <div class="card z-depth-2 hoverable hover-default" style="z-index: 100;">
                        <a href="#prepaid" class="card-content center-align modal-trigger">
                            <span class="card-title">Single Campaign</span>
                            <div class="card secondary">
                                <p style="padding: 5px;">$8.00 / month</p>
                            </div>
                            <p class="light">With this package you can create one campaign and you won't have any time limitations.</p>
                            <ul class="checkedList left-align">
                                <li>One campaign</li>
                                <li>Unlimited play time</li>
                                <li>Unlimited edit time</li>
                            </ul>
                        </a>
                        <div class="card-action"><a href="" class="">Buy Now</a></div>
                    </div>
                </div>
                <div class="col s12 l4" style="position: relative; padding: 0;">
                    <div class="hide-on-med-and-down" style="height: 25px;"></div>
                    <div class="card sticky-action hoverable">
                        <a href="#prepaid" class="card-content center-align modal-trigger">
                            <span class="card-title">DM Unlimited</span>
                            <div class="card secondary">
                                <p style="padding: 5px;">$14.00 / month</p>
                            </div>
                            <p class="light">If you hate limitations, than is this the best plan for you!</p>
                            <ul class="checkedList left-align">
                                <li>Everything in Single Campaign</li>
                                <li>But with unlimited campaigns</li>
                            </ul>
                        </a>
                        <div class="card-action"><a href="" class="">Buy Now</a></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Referral Program</span>
                    <p>If you refer a friend, you can get some benefit:</p>
                    <p>For each friend you refer you get $2.00 discount on your plan*.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h3 class="header col s12 white-text">Use it during and in between sessions</h3>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_2.png') }}" alt="Unsplashed background img 2"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 center">
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
                            <div class="collapsible-body"><span>It will also be possible for all the players to have their own screen. For this they all need to login with their own account and that way the DM is also able to specify which players are allowed to move which objects.</span></div>
                        </li>
                    </ul>
                    <h4>In between Sessions</h4>
                    <p class="left-align light">As DM, you'll also be able to specify what areas the players are able to see (on a group and a per player basis) so players are able to view the content outside the sessions. As DM, you can also choose to disable all content in between sessions.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h3 class="header col s12 white-text">About the Project</h3>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_3.png') }}" alt="Unsplashed background img 3"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 center">
                    <h4>For Nerds, By Nerds</h4>
                    <p class="left-align light">
                        When I started creating my first campaign I wanted to create a world where my players and I decided to start with a map. Having also played Warhammer, I knew that that world was already highly detailed and had maps of the world, and more detailed maps of the continents.
                        After searching a bit, I found out that even quite a lot of cities where also mapped and I eventually found the inspiration for this project: <a href="http://www.gitzmansgallery.com/shdmotwow.html">The Super Huge Detailed Map of the Warhammer Old World</a>.
                    </p>
                    <p class="left-align light">
                        After I had the map of the region, I wanted to add more detailed maps of the cities my players where visiting and I found a generator that generated both a city map with buildings but also the people (with a short description).
                        <br/>
                        The only decent tools I could find to add these to my map where way to expensive (the version I would need would be almost $3.000) so I decided I'd write my own scripts and when I finished those, I figured that I would share this with the wold.
                    </p>
                    <h4>But also for Everyone Else</h4>
                    <p class="left-align light">
                        Even though I've made the code available for free for everyone to use I noticed that most people don't have the technical expertise and hardware (or even just time) to do everything themselves. That is why I decided to create this service so everyone can use it.
                        <br/>
                        Unfortunately with hosting a service like this there is a lot of cost (server hardware, domain name, internet services, etc) therefore we have to charge a small fee for using this service.
                        However, there is also good news. This project isn't something we thought of to make a lot of money and therefore we'll try to provide a few different options that fit best with the way you want to use it.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h3 class="header col s12 white-text">Personal Customer Support</h3>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_3.png') }}" alt="Unsplashed background img 3"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 center">
                    <h4>Better Feedback > Better Products</h4>
                    <p class="left-align light">
                        We believe that the best way to make a product better is by listening to what the users have to say. Therefore we've added a feedback form where you can request new features, subscribe to get a notification when a feature is implemented, etc.<br/>
                        {{--<a href="{{ route('feedback') }}" class="btn">Feedback Page</a>--}}
                    </p>
                    <a href="" class="btn">Feedback Page</a>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container">
        <div class="section overlay-darken-2 valign-wrapper">
            <div class="container">
                <div class="row center">
                    <h3 class="header col s12 white-text">Pricing</h3>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/ScreenShot_3.png') }}" alt="Unsplashed background img 3"></div>
    </div>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 center">
                    <div class="row" style="height: 500px;">
                        <div class="col s12 l4" style="margin: 50px 0; height: calc(100% - 100px);">
                            <div class="card">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="{{ asset('images/ScreenShot_3.png') }}">
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>
                                    <p><a href="#">This is a link</a></p>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4" style="height: 100%;">
                            <div class="card z-depth-5">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="{{ asset('images/ScreenShot_3.png') }}">
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>
                                    <p><a href="#">This is a link</a></p>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4" style="margin: 50px 0; height: calc(100% - 100px);">
                            <div class="card sticky-action">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="{{ asset('images/ScreenShot_3.png') }}">
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>
                                    <p><a href="#">This is a link</a></p>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                                </div>
                                <div class="card-action">More Info</div>
                                <div class="card-reveal">Buy</div>
                            </div>
                        </div>
                    </div>
                    <h4>For Nerds, By Nerds</h4>
                    <p class="left-align light">
                        When I started creating my first campaign I wanted to create a world where my players and I decided to start with a map. Having also played Warhammer, I knew that that world was already highly detailed and had maps of the world, and more detailed maps of the continents.
                        After searching a bit, I found out that even quite a lot of cities where also mapped and I eventually found the inspiration for this project: <a href="http://www.gitzmansgallery.com/shdmotwow.html">The Super Huge Detailed Map of the Warhammer Old World</a>.
                    </p>
                    <p class="left-align light">
                        After I had the map of the region, I wanted to add more detailed maps of the cities my players where visiting and I found a generator that generated both a city map with buildings but also the people (with a short description).
                    </p>
                    <p class="left-align light">
                        The only decent tools I could find to add these to my map where way to expensive (the version I would need would be almost $3.000) so I decided I'd write my own scripts and when I finished those, I figured that I would share this with the wold.
                        <br/>
                        Even though I've made the code available for free for everyone to use I noticed that most people don't have the technical expertise and hardware (or even just time) to do everything themselves. That is why I decided to create this service so everyone can use it.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.parallax').parallax();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            let hoverDefault = $('.hover-default');
            $('.hoverable').hover(
                function () {
                    hoverDefault.css('z-index', '10');
                    $(this).css('z-index', '100');
                },
                function () {
                    $(this).css('z-index', '5');
                    hoverDefault.css('z-index', '100');
                }
            );
            $('.modal').modal();

        });
    </script>
@endsection