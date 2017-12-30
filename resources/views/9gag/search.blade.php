@extends('layouts.app')

@section('content')
    <div id="big-search-wrapper">
        <form action="{{ url('posts/search') }}" method="get">
            <div class="icon">&#128269;</div>
            <input name="keyword" type="text" id="big-search-input" value="{{ $keyword or '' }}"/>
        </form>
    </div>

    <p class="search-results">{{ $posts->count() }} results</p>

    @foreach($posts as $post)
        <a class="row search-item" href="{{ url('/posts/'.$post->slug) }}">
            <div class="col-xs-12">
                <img class="left-side img-responsive" src="{{ url('/storage/posts/400/'.$post->image) }}" alt="">
            </div>
            <div class="col-xs-12">
                <div class="right-side">
                    <h4>{{ $post->title }}</h4>
                    <p>{{ $post->points_count }} points</p>
                </div>
            </div>
        </a>
    @endforeach

    {{ $posts->links() }}

    <div id="go-top" class="hidden">
        <i class="fa fa-step-forward" aria-hidden="true"></i>
    </div>
@endsection

@section('sidebar')
    @include('includes.sidebar')
@endsection
