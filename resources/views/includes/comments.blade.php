<div id="comments" class="comments-section">

  <div class="comments-head">
    <p class="no-comments">{{ $no_comments }} Comments</p>
    <div class="pull-right">
      <a href="" class="comment-sort active">Fresh</a>
    </div>
  </div>
  <div class="comments-body">

    @if(Auth::check())
      <img class="comment-img" src="{{ url( 'storage/avatars/'.Auth::user()->avatar_image ) }}" alt="">
    @else
      <div class="comments-avatar">
        <i class="fa fa-user" aria-hidden="true"></i>
      </div>
    @endif

    <form action="{{ url('comments') }}" method="POST" class="comments-text">
      {{ csrf_field() }}
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <input type="hidden" id="comment-id" name="parent_id" value="0">
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

      <div class="comment" data-comment-id="{{ $comment->id }}">

        <img class="comment-avatar" src="{{ url('storage/avatars/'.$comment->user->avatar_image) }}" alt="" />

        <div class="comment-description">
          <p class="desc">
            <a href="#" class="author">{{ $comment->user->username }}</a>
            <span>
              <span class="comment-points">{{ $comment->points->count() }}</span> points &bull;
            </span>
            <span>
              {{ time_since($comment->created_at->getTimestamp()) }}
            </span>
          </p>
          <p class="message">
            {{ $comment->comment }}
          </p>
          <div class="reply">

            <a class="reply-anchor" href="#">Reply</a>
            @if(Auth::check())
              <a href="#" class="up-vote-comment @if( $comment->points->where('user_id', Auth::id())->count() ) active @endif ">
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

      @include('includes.subcomments')

    @endforeach

  </div>
</div>
