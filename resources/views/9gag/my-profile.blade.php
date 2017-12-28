@extends('layouts.app')

@section('content')

    @foreach($posts as $post)
    <div class="home-item" data-post-id="{{ $post->id }}">

        @if($post->is_gif)
        <a href="{{ url('gag/'.$post->slug) }}">
            <h3 class="title">{{ $post->title }}</h3>
        </a>
        <a class="gif-wrapper-link" href="{{ url('gag/'.$post->slug) }}">
            <div class="gif-wrapper">
                <?php
                    $post->image = substr($post->image, 0 , strpos($post->image, '.gif')).'.png';
                ?>
                <div class="gif-text">
                    GIF
                </div>
                <img src="{{ url('storage/posts/600/'.$post->image)  }}" alt="" class="img-responsive">
            </div>
        </a>
        @else
            @if($post->is_img_huge)
            <a href="{{ url('gag/'.$post->slug) }}">
                <div class="huge-image-wrapper">
                    <img class="img-responsive" src="{{ url('storage/posts/600/'.$post->image) }}" alt="">
                </div>
                <div class="huge-image-footer">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                    <span>
                        View Full Post
                    </span>
                </div>
            </a>
            @else
            <a href="{{ url('gag/'.$post->slug) }}">
                <img class="img-responsive" src="{{ url('storage/posts/600/'.$post->image) }}" alt="">
            </a>
            @endif
        @endif
        <div class="description">
            <a class="points-wrapper" href="{{ url('gag/'.$post->slug) }}">
                <span class="points">{{count($post->points)}}</span> points
            </a><span> &bull;</span>
            <a href="{{ url('gag'.'/'.$post->slug.'#comments') }}">
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
            <a href="{{ url('gag'.'/'.$post->slug.'#comments') }}" class="comment social-item">
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

    <input type="hidden" id="category-id" value="{{ $category_id or 0 }}">
    <input type="hidden" id="posts-category" value="{{ $posts_category or 0 }}">
    <div id="go-top" class="hidden">
        <i class="fa fa-step-forward" aria-hidden="true"></i>
    </div>

    <script id="home-item-template" type="x-tmpl-mustache">
        @{{#posts}}
        <div class="home-item" data-post-id="@{{ id }}">

            @{{ #is_gif }}
            <a href="{{ url('gag') }}/@{{ slug }}">
                <h3 class="title">@{{ title }}</h3>
            </a>
            <a class="gif-wrapper-link" href="{{ url('gag') }}/@{{slug) }}">
                <div class="gif-wrapper">
                    <div class="gif-text">
                        GIF
                    </div>
                    <img src="{{ url('storage/posts/600') }}/@{{ image }}" alt="" class="img-responsive">
                </div>
            </a>
            @{{ /is_gif}}
            @{{ #isnt_gif }}
            <a href="{{ url('gag') }}/@{{ slug }}">
                <img class="img-responsive" src="{{ url('storage/posts/600') }}/@{{ image }}" alt="">
            </a>
            @{{ /isnt_gif }}
            <div class="description">
                <a class="points-wrapper" href="{{ url('gag') }}/@{{ slug }}">
                    <span class="points">@{{ no_points }}</span> points
                </a><span> &bull;</span>
                <a href="{{ url('gag') }}/@{{ slug }}#comments">
                    @{{ no_comments }} comments
                </a>
            </div>
            <div class="social-section">

                @{{#auth}}
                <a href="#" class="thumbs-up social-item @{{#active_thumbs_up}} active @{{/active_thumbs_up}}">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                </a>
                @{{/auth}}
                @{{#no_auth}}
                <a href="#" class="thumbs-up social-item">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                </a>
                @{{/no_auth}}

                <a href="#" class="thumbs-down social-item">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </a>
                <a href="{{ url('gag') }}/@{{ slug }}#comments" class="comment social-item">
                    <i class="fa fa-comment" aria-hidden="true"></i>
                </a>
                <div class="pull-right">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/gag') }}/@{{ slug }}" class="facebook social-link">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/home?status={{ url('/gag') }}/@{{ slug }}" class="twitter social-link">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                        <span>Twitter</span>
                    </a>
                </div>
            </div>
        </div>
        @{{/posts}}
    </script>

    <div id="go-top" class="hidden">
        <i class="fa fa-step-forward" aria-hidden="true"></i>
    </div>

@endsection

@section('sidebar')
    @include('includes.sidebar')
@endsection
