<div class="top-menu row">
	<div class="col-sm-24">
		<div class="left-side">
				
			<div class="logo menu-item">
				
			</div>

			<div class="hot menu-item active">
				<a href="">
					Hot
				</a>
			</div>
			<div class="trending menu-item">
				<a href="">			
					Trending
				</a>
			</div>
			<div class="fresh menu-item">
				<a href="">				
					Fresh
				</a>
			</div>
			<div class="sections-wrapper menu-item">
				Sections <span class="caret"></span>
				<ul class="sections-list hidden">
					<li>
						<a href="">Funny</a>	
					</li>					
					<li>
						<a href="">Funny</a>	
					</li>					
					<li>
						<a href="">Funny</a>	
					</li>					
					<li>
						<a href="">Funny</a>	
					</li>					
					<li>
						<a href="">Funny</a>	
					</li>					
					<li>
						<a href="">Funny</a>	
					</li>
				</ul>
			</div>
			<div class="sections">
				<div class="menu-item">
					<a href="">
						Video
					</a>
				</div>				
				<div class="menu-item">
					<a href="">
						Cosplay
					</a>
				</div>				
				<div class="menu-item">
					<a href="">
						Girl
					</a>
				</div>				
				<div class="menu-item">
					<a href="">
						NSFW
					</a>
				</div>				
				<div class="menu-item">
					<a href="">
						GIF
					</a>
				</div>
			</div>
		</div> <!-- .left-side -->

		<div class="right-side pull-right">
			@if(!Auth::check())
				<div class="search menu-item">
					&#128269;
					<form action="{{ url('search') }}">
						<input type="text" name="query" class="menu-search-input hidden" placeholder="Type to search" />
					</form>
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
					&#128269;
					<form action="{{ url('search') }}">
						<input type="text" name="query" class="menu-search-input hidden" placeholder="Type to search" />
					</form>
				</div>
				<div class="menu-notifications">
					<a href="">
						<i class="fa fa-bell" aria-hidden="true"></i>
					</a>
				</div>
				<div class="menu-avatar">
					<img class="img-responsive" src="http://avatars-cdn.9gag.com/avatar/default_82_100_v0.jpg" alt="">
					<ul class="avatar-sub-menu">
						
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