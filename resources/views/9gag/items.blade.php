@foreach($posts as $post)
<div class="home-item" data-post-id="{{ $post->id }}">
	
	<a href="{{ url('gag/'.$post->slug) }}">
		<h3 class="title">{{ $post->title }}</h3>
		<img class="img-responsive" src="{{ url('img/posts/460/'.$post->image) }}" alt="">
	</a>
	<div class="description">
		<a class="points-wrapper" href="{{ url('gag/') }}">
			<span class="points">{{count($post->points)}}</span> points 
		</a><span> &bull;</span>
		<a href="{{ url('gag'.'/'.$post->slug.'#comment') }}">
			{{ $post->comments->count() }} comments
		</a>
	</div>
	<div class="social-section">

		@if(Auth::check())
		<a href="" class="thumbs-up social-item @if( $post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id )->count()) active @endif">
			<i class="fa fa-arrow-up" aria-hidden="true"></i>
		</a>
		@else
		<a href="" class="thumbs-up social-item">
			<i class="fa fa-arrow-up" aria-hidden="true"></i>
		</a>
		@endif
	
		<a href="" class="thumbs-down social-item">
			<i class="fa fa-arrow-down" aria-hidden="true"></i>
		</a>
		<a href="{{ url('gag'.'/'.$post->slug.'#comment') }}" class="comment social-item">
			<i class="fa fa-comment" aria-hidden="true"></i>
		</a>
		<div class="pull-right">
			<a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/gag/'.$post->slug) }}" class="facebook social-link">
				<i class="fa fa-facebook" aria-hidden="true"></i> 
				<span>Facebook</span>
			</a>
			<a href="https://twitter.com/home?status={{ url('/gag/'.$post->slug) }}" class="twitter social-link">
				<i class="fa fa-twitter" aria-hidden="true"></i> 
				<span>Twitter</span>
			</a>
		</div>
	</div>
</div>
@endforeach