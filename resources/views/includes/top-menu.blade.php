<div class="top-menu row">
    <div class="col-sm-24">
        <div class="left-side">
            <a href="{{ url('/') }}" class="logo menu-item">
                <img src="{{ url('/img/logo.png') }}" alt="" />
            </a>

            <div class="hot menu-item @if(active_route('/')) active @endif">
                <a href="{{ url('/') }}">
                    Hot
                </a>
            </div>
            <div class="trending menu-item @if(active_route('trending')) active @endif">
                <a href="{{ url('/trending') }}">
                    Trending
                </a>
            </div>
            <div class="fresh menu-item @if(active_route('fresh')) active @endif">
                <a href="{{ url('/fresh') }}">
                    Fresh
                </a>
            </div>
        </div>
        <!-- .left-side -->

        <div class="right-side pull-right">
            @if(!Auth::check())
                <div class="search menu-item">
                    <p class="text-right">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </p>
                    <form action="{{ url('search') }}">
                        <input type="text" name="query" class="menu-search-input hidden" placeholder="Type to search" autocomplete="off" />
                    </form>
                    <div id="search-results">

                    </div>
                </div>
                <div class="log-in menu-item" data-toggle="modal" data-target="#login-modal">
                    Log in
                </div>
                <div class="sign-up menu-item" data-toggle="modal" data-target="#signup-modal">
                    <a href="#">
                        Sign up
                    </a>
                </div>
            @else
                <div class="search menu-item">
                    <p class="text-right">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </p>
                    <form action="{{ url('search') }}">
                        <input type="text" name="query" class="menu-search-input hidden" placeholder="Type to search" autocomplete="off" />
                    </form>
                    <div id="search-results">

                    </div>
                </div>
                <div class="menu-avatar has-submenu">
                    <img class="img-responsive" src="{{ url( 'img/avatars/'.Auth::user()->avatar_image ) }}" alt="">
                    <ul class="sub-menu hidden">
                        <li>
                            <a href="{{ url('/my-profile') }}">My Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/settings') }}">Settings</a>
                        </li>
                        <li>
                            <a href="{{ url('logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="sign-up menu-item" data-toggle="modal" data-target="#upload-modal">
                    <a href="#">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span>Upload</span>
                    </a>
                </div>
            @endif
        </div>
        <!-- .right-side -->
    </div>
</div>

<!-- search template -->
<script id="search-template" type="x-tmpl-mustache">
    @{{#results}}
    <a class='search-result' href="{{ url('/gag') }}/@{{slug}}">
        @{{title}}
    </a>
    @{{/results}}
</script>
