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
				<div class="sign-up menu-item" data-toggle="modal" data-target="#signup-modal">
					<a href="#">
						+ Upload
					</a>
				</div>
			@endif
		</div>
		<!-- .right-side -->
	</div>
</div>

<!-- Login Modal -->
<div class="modal fade " id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h1 class="modal-title" id="loginModalLabel">Login</h1>
				<p>Connect with a social network</p>
				<div class="row social-buttons">
					<div class="col-sm-12 social-btn-wrapper">
						<div class="social-btn social-btn-fb">
							<i class="fa fa-facebook" aria-hidden="true"></i> 
							<p class="social-btn-txt">
								Facebook
							</p>
						</div>
					</div>
					<div class="col-sm-12 social-btn-wrapper">
						<div class="social-btn social-btn-gp">
							<i class="fa fa-google-plus" aria-hidden="true"></i> 
							<p class="social-btn-txt">
								Google
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<p>Login with your email address</p>
				<form method="POST" action="{{ url('/login') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">Email</label>
						<input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password</label>
						<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					</div>
					<button type="submit" class="btn btn-primary">Log in</button>
					<a class="pull-right" href="{{ url('/password/reset') }}">Forgot Password</a>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h1 class="modal-title" id="signUpModalLabel">Hey there!</h1>
				<p>
					9LARAVEL is your best source of fun. Share anything you find interesting, get  real responses from people all over the world and discover what makes you code.
				</p>
				<div class="row social-buttons">
					<div class="col-sm-12 social-btn-wrapper">
						<div class="social-btn social-btn-fb">
							<i class="fa fa-facebook" aria-hidden="true"></i> 
							<p class="social-btn-txt">
								Facebook
							</p>
						</div>
					</div>
					<div class="col-sm-12 social-btn-wrapper">
						<div class="social-btn social-btn-gp">
							<i class="fa fa-google-plus" aria-hidden="true"></i> 
							<p class="social-btn-txt">
								Google
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<p>Sign up with your <a href="{{ url('/register') }}">Email Address</a></p>
				<p>Have an account? <a href="{{ url('/login') }}">Login</a></p>
			</div>
		</div>
	</div>
</div>