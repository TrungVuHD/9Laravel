@foreach($sidebarPosts as $post)
<a href="{{ url('gag/'.$post->slug) }}" class="sidebar-item">
	<img class="img-responsive" src="{{ url('img/posts/300/'.$post->image) }}" alt="">
	<p>{{ $post->title }}</p>
</a>
@endforeach