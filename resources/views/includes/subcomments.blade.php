@foreach($comment->subcomments as $sub_comment)
  <div class="comment comment-small" data-comment-id="{{ $sub_comment->id }}" data-parent-id="{{ $sub_comment->parent_id or 0 }}">
    <img class="comment-avatar" src="{{ url('storage/avatars/'.$sub_comment->user->avatar_image) }}" alt="" />
    <div class="comment-description">
      <p class="desc">
        <a href="#" class="author">{{ $sub_comment->user->username }}</a>
        <span>
          <span class="comment-points">{{ $sub_comment->points->count() }}</span> points &bull;
        </span>
        <span>
          {{ time_since($sub_comment->created_at->getTimestamp()) }}
        </span>
      </p>
      <p class="message">
        {{ $sub_comment->comment }}
      </p>
      <div class="reply">
        <a class="reply-anchor" href="#">Reply</a>
        @if(Auth::check())
          <a href="#" class="up-vote-comment @if($sub_comment->points->where('user_id', Auth::id())->count()) active @endif ">
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
