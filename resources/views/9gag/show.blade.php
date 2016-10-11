@extends('layouts.app')

@section('content')

	<div class="home-item detail-home-item">
		<h3 class="title">{{ $post->title }}</h3>
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
				<span>UP</span>
			</a>
			<a href="" class="thumbs-down social-item">
				<i class="fa fa-arrow-down" aria-hidden="true"></i>
			</a>
			<a href="" class="facebook social-link">
				<i class="fa fa-facebook" aria-hidden="true"></i> 
				<span>Facebook</span>
			</a>
			<a href="" class="twitter social-link">
				<i class="fa fa-twitter" aria-hidden="true"></i> 
				<span>Twitter</span>
			</a>
			<a href="" class="next-post">
				Next Post
			</a>
		</div>
		<img class="img-responsive" src="{{ url('img/posts/'.$post->image) }}" alt="">
		<div class="share-section row">
			<div class="col-sm-12">
				<a href="" class="share-network facebook">
					Share on Facebook
				</a>
			</div>
			<div class="col-sm-12">
				<a href="" class="share-network twitter">
					Share on Twitter
				</a>
			</div>
		</div>
		<a href="" class="report-post">REPORT</a>
	</div>
	<div class="comments-section">
		<div class="comments-head">
			<p class="no-comments">470 Comments</p>
			<div class="pull-right">
				<a href="" class="comment-sort active">Hot</a>
				<a href="" class="comment-sort">Fresh</a>
			</div>
		</div>
		<div class="comments-body">
			<div class="comments-avatar">
				<i class="fa fa-user" aria-hidden="true"></i>
			</div>
			<div class="comments-text">
				<textarea name="" placeholder="Write comments"></textarea>
				<div class="bottom-text">
					<i class="fa fa-smile-o" aria-hidden="true"></i>
					<div class="pull-right">
						<span class="no-characters">1000</span>
						<button class="btn btn-primary">Post</button>
					</div>
				</div>
			</div>
		</div>
		<div class="comments-list">

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


		</div>
	</div>
@endsection

@section('sidebar')
	@include('includes.sidebar')
@endsection