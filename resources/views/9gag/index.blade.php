@extends('layouts.app')

@section('content')

	@foreach($posts as $post)
	<div class="home-item">
		<a href="{{ url('gag/'.$post->slug) }}">
			<h3 class="title">{{ $post->title }}</h3>
			<img class="img-responsive" src="{{ url('img/posts/460/'.$post->image) }}" alt="">
		</a>
		<div class="description">
			<a href="{{ url('gag/') }}">
				{{ $post->points }} points 
			</a><span> &bull;</span>
			<a href="{{ url('gag'.''.'#comment') }}">
				216 comments
			</a>
		</div>
		<div class="social-section">
			<a href="" class="thumbs-up social-item">
				<i class="fa fa-arrow-up" aria-hidden="true"></i>
			</a>
			<a href="" class="thumbs-down social-item">
				<i class="fa fa-arrow-down" aria-hidden="true"></i>
			</a>
			<a href="" class="comment social-item">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</a>
			<div class="pull-right">
				<a href="" class="facebook social-link">
					<i class="fa fa-facebook" aria-hidden="true"></i> 
					<span>Facebook</span>
				</a>
				<a href="" class="twitter social-link">
					<i class="fa fa-twitter" aria-hidden="true"></i> 
					<span>Twitter</span>
				</a>
			</div>
		</div>
	</div>
	@endforeach
	
	<div id="go-top" class="hidden">
		<i class="fa fa-step-forward" aria-hidden="true"></i>
	</div>

@endsection

@section('sidebar')
	@include('includes.sidebar')
@endsection