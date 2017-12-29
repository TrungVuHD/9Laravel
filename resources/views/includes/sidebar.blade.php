@foreach($sidebar_posts as $post)
<a href="{{ url('posts/'.$post->slug) }}" class="sidebar-item">
    @if ($post->gif)
      @php $image = substr($post->image, 0 , strpos($post->image, '.gif')).'.png'; @endphp
      <img class="img-responsive" src="{{ url('storage/posts/400/' . $image) }}" alt="">
    @else
      <img class="img-responsive" src="{{ url('storage/posts/400/' . $post->image) }}" alt="">
     @endif
    <p>{{ $post->title }}</p>
</a>
@endforeach
