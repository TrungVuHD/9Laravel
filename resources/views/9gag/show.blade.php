@extends('layouts.app')

@section('content')

	<div class="home-item detail-home-item" data-post-id="{{ $post->id }}">
		<h3 class="title">{{ $post->title }}</h3>
		<div class="description">
			<a class="points-wrapper" href="{{ url('gag/'.$post->slug) }}">
				<span class="points">{{ $points }}</span> points
			</a><span> &bull;</span>
			<a href="#comments">
				{{$no_comments}} comments
			</a>
		</div>
		<div class="social-section">
			<a href="#" class="thumbs-up social-item @if(isset($thumb_up->id)) active @endif ">
				<i class="fa fa-arrow-up" aria-hidden="true"></i>
				<span>UP</span>
			</a>
			<a href="#" class="thumbs-down social-item">
				<i class="fa fa-arrow-down" aria-hidden="true"></i>
			</a>
			<a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/gag/'.$post->slug) }}" class="facebook social-link">
				<i class="fa fa-facebook" aria-hidden="true"></i> 
				<span>Facebook</span>
			</a>
			<a href="https://twitter.com/home?status={{ url('/gag/'.$post->slug) }}" class="twitter social-link">
				<i class="fa fa-twitter" aria-hidden="true"></i> 
				<span>Twitter</span>
			</a>
			@if( $next_post != '' )
			<a href="{{ $next_post->slug }}" class="next-post">
				Next Post
			</a>
			@endif
		</div>
		<img class="img-responsive" src="{{ url('img/posts/'.$post->image) }}" alt="">
		<div class="share-section row">
			<div class="col-sm-12">
				<a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/gag/'.$post->slug) }}" class="share-network facebook">
					Share on Facebook
				</a>
			</div>
			<div class="col-sm-12">
				<a href="https://twitter.com/home?status={{ url('/gag/'.$post->slug) }}" class="share-network twitter">
					Share on Twitter
				</a>
			</div>
		</div>
		<a href="" class="report-post">REPORT</a>
	</div>
	<div id="comments" class="comments-section">
		<div class="comments-head">
			<p class="no-comments">{{$no_comments}} Comments</p>
			<div class="pull-right">
				<a href="" class="comment-sort active">Hot</a>
				<a href="" class="comment-sort">Fresh</a>
			</div>
		</div>
		<div class="comments-body">
			@if(Auth::check())
			<img class="comment-img" src="{{ url( 'img/avatars/'.Auth::user()->avatar_image ) }}" alt="">
			@else
			<div class="comments-avatar">
				<i class="fa fa-user" aria-hidden="true"></i>
			</div>
			@endif
			<form action="{{ url('comments') }}" method="POST" class="comments-text">
				{{ csrf_field() }}
				<input type="hidden" name="post_id" value="{{ $post->id }}">
				<textarea name="comment" placeholder="Write comments"></textarea>
				<div class="bottom-text">
					<a target="_blank" href="http://memeful.com/">
						<i class="fa fa-smile-o" aria-hidden="true"></i>
					</a>
					<div class="pull-right">
						<span class="no-characters">1000</span>
						<button class="btn btn-primary">Post</button>
					</div>
				</div>
			</form>
		</div>
		<div class="comments-list">
			@foreach($comments as $comment)
			<div class="comment" data-comment-id="{{ $comment->id }}" data-parent-id="{{ $comment->parent_id or 0 }}">
				<img class="comment-avatar" src="{{ url('img/avatars/'.$comment->user->avatar_image) }}" alt="" />
				<div class="comment-description">
					<p class="desc">
						<a href="" class="author">{{ $comment->user->username }}</a>
						<span>
							<span class="comment-points">{{ $comment->points->count() }}</span> points &bull;
						</span> 
						<span>
							<?php 

							$last_date = date('y-m-d H:i:s', $comment->created_at->getTimestamp());
							$current_date = date('y-m-d H:i:s');

							$date_diff = strtotime($current_date) - strtotime($last_date);
							$months_diff = floor($date_diff / (60*60*24*30));
							$days_diff = floor($date_diff / (60*60*24));
							$hours_diff = floor($date_diff / (60*60));
							$minutes_diff = floor($date_diff / (60));

							if($minutes_diff < 60) 
							{
								echo $minutes_diff.' minutes';
							} elseif($hours_diff != 0 && $hours_diff<24)
							{
								echo $hours_diff.' hours';
							} elseif( $hours_diff>=24 || $days_diff>0) 
							{
								echo $days_diff.' days';
							} elseif ($days_diff > 31) {

								echo $months_diff.' months';
							} 
							
							?>
						</span>
					</p>
					<p class="message">
						{{ $comment->comment }}
					</p>
					<div class="reply">
						<!--
						<a href="">Reply</a>
						-->
						@if(Auth::check())
						<a href="#" class="up-vote-comment @if( $comment->points->where('user_id', Auth::user()->id)->count() ) active @endif ">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
						</a>
						@else
						<a href="#" class="up-vote-comment">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
						</a>
						@endif
						<a href="#" class="down-vote-comment">
							<i class="fa fa-arrow-down" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			@endforeach
	
			<!--
			<div class="comment">
				<img class="comment-avatar" src="http://accounts-cdn.9gag.com/media/avatar/7707104_100_5.jpg" alt="" />
				<div class="comment-description">
					<p class="desc">
						<a href="" class="author">evlil_noob</a>
						<span>1128 points &bull;</span> 
						<span>12 h</span>
					</p>
					<p class="message">
						Lorem ipsum dolor sit ammet
					</p>
					<div class="reply">
						<a href="">Reply</a>
						<a href="">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
						</a>
						<a href="">
							<i class="fa fa-arrow-down" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="comment comment-small">
				
				<img class="comment-avatar" src="http://accounts-cdn.9gag.com/media/avatar/7707104_100_5.jpg" alt="" />
				<div class="comment-description">
					<p class="desc">
						<a href="" class="author">evlil_noob</a>
						<span>1128 points &bull;</span> 
						<span>12 h</span>
					</p>
					<p class="message">
						Lorem ipsum dolor sit ammet
					</p>
					<div class="reply">
						<a href="">Reply</a>
						<a href="">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
						</a>
						<a href="">
							<i class="fa fa-arrow-down" aria-hidden="true"></i>
						</a>
					</div>
				</div>

			</div>
			<div class="comment">
				
				<img class="comment-avatar" src="http://accounts-cdn.9gag.com/media/avatar/7707104_100_5.jpg" alt="" />
				<div class="comment-description">
					<p class="desc">
						<a href="" class="author">evlil_noob</a>
						<span>1128 points &bull;</span> 
						<span>12 h</span>
					</p>
					<p class="message">
						Lorem ipsum dolor sit ammet
					</p>
					<div class="reply">
						<a href="">Reply</a>
						<i class="fa fa-arrow-up" aria-hidden="true"></i>
						<i class="fa fa-arrow-down" aria-hidden="true"></i>
					</div>
				</div>

			</div>
			<div class="comment">
				
				<img class="comment-avatar" src="http://accounts-cdn.9gag.com/media/avatar/7707104_100_5.jpg" alt="" />
				<div class="comment-description">
					<p class="desc">
						<a href="" class="author">evlil_noob</a>
						<span>1128 points &bull;</span> 
						<span>12 h</span>
					</p>
					<p class="message">
						Lorem ipsum dolor sit ammet
					</p>
					<div class="reply">
						<a href="">Reply</a>
						<i class="fa fa-arrow-up" aria-hidden="true"></i>
						<i class="fa fa-arrow-down" aria-hidden="true"></i>
					</div>
				</div>

			</div>
			-->


		</div>
	</div>
@endsection

@section('sidebar')
	@include('includes.sidebar')
@endsection