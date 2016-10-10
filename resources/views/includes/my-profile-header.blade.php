@if( $request->is('my-profile') )
<div class="my-profile-header">
	<div class="top">
		<img class="profile-image" src="http://avatars-cdn.9gag.com/avatar/default_82_100_v0.jpg" alt="" />
		<h1>{{ $user->name }}</h1>
		<p>My Funny Collection</p>
	</div>
	<div class="bottom container">
		<div class="row">
			<div class="col-sm-16 col-sm-offset-4 text-left">
				<a href="" class="profile-category-link active">Overview</a>
				<a href="" class="profile-category-link">Posts</a>
				<a href="" class="profile-category-link">Upvotes</a>
				<a href="" class="profile-category-link">Comments</a>
			</div>
		</div>
	</div>
</div>
@endif