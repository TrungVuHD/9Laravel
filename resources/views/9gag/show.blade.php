@extends('layouts.app')

@section('content')
    <div class="home-item detail-home-item" data-post-id="{{ $post->id }}">
        <h3 class="title">{{ $post->title }}</h3>
        <div class="description">
            <a class="points-wrapper" href="{{ url('gag/'.$post->slug) }}">
                <span class="points">{{ $no_points }}</span> points
            </a><span> &bull;</span>
            <a href="#comments">
                {{$no_comments}} comments
            </a>
        </div>
        <div class="social-section fixed-social-section">
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
        <img class="img-responsive" src="{{ url('storage/posts/'.$post->image) }}" alt="">
        <div class="share-section row">
            <div class="col-sm-6">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/gag/'.$post->slug) }}" class="share-network facebook">
                    Share on Facebook
                </a>
            </div>
            <div class="col-sm-6">
                <a href="https://twitter.com/home?status={{ url('/gag/'.$post->slug) }}" class="share-network twitter">
                    Share on Twitter
                </a>
            </div>
        </div>
        <a href="#" class="report-post" data-toggle="modal" data-target="#report-modal">REPORT</a>
    </div>

    @include('includes.comments')

@endsection

@section('sidebar')
    @include('includes.sidebar')
@endsection
