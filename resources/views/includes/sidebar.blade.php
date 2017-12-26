@foreach($sidebarPosts as $post)
<a href="{{ url('gag/'.$post->slug) }}" class="sidebar-item">
    @if ($post->gif)
      @php $image = substr($post->image, 0 , strpos($post->image, '.gif')).'.png'; @endphp
      <img class="img-responsive" src="{{ url('storage/posts/300/' . $image) }}" alt="">
    @else
      <img class="img-responsive" src="{{ url('storage/posts/300/' . $post->image) }}" alt="">
     @endif
    <p>{{ $post->title }}</p>
</a>
@endforeach
