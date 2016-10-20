<div class="top-menu row">
	<div class="col-sm-24">
		<div class="left-side">
				
			<a href="{{ url('/') }}" class="logo menu-item">
				<img src="{{ url('/img/logo.png') }}" alt="" />
			</a>

			<div class="hot menu-item @if($request->is('/')) active @endif">
				<a href="{{ url('/') }}">
					Hot
				</a>
			</div>
			<div class="trending menu-item @if($request->is('trending')) active @endif">
				<a href="{{ url('/trending') }}">			
					Trending
				</a>
			</div>
			<div class="fresh menu-item @if($request->is('fresh')) active @endif">
				<a href="{{ url('/fresh') }}">				
					Fresh
				</a>
			</div>
			<div class="sections-wrapper menu-item has-submenu">
				Sections <span class="caret"></span>
				<ul class="sub-menu hidden">
					@foreach ($menuPostCategories as $cat)
					<li>
						<a href="{{ url($cat->slug) }}">{{ $cat->title }}</a>	
					</li>
					@endforeach
				</ul>
			</div>
			<div class="sections hidden-xs hidden-sm">
				@foreach ($menuVisiblePostCategories as $cat)
				<div class="menu-item">
					<a href="{{ url($cat->slug) }}">
						{{ $cat->title }}
					</a>
				</div>
				@endforeach
			</div>
		</div> <!-- .left-side -->

		<div class="right-side pull-right">
			@if(!Auth::check())
				<div class="search menu-item">
					<p class="text-right">
						&#128269;
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
						&#128269;
					</p>
					<form action="{{ url('search') }}">
						<input type="text" name="query" class="menu-search-input hidden" placeholder="Type to search" autocomplete="off" />
					</form>
					<div id="search-results">
						
					</div>
				</div>
				<div class="menu-notifications">
					<a href="">
						<i class="fa fa-bell" aria-hidden="true"></i>
					</a>
					<div class="notifications-wrapper hidden">
						<div class="notifications-header">
							Activities
						</div>
						<div class="notifications-body empty">
							You don't have any notifications
						</div>
						<a href="{{ url('/notifications') }}" class="notifications-footer">
							See All
						</a>
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
						+ Upload
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