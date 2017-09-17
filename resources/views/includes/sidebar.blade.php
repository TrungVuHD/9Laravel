@foreach($sidebarPosts as $post)
<a href="{{ url('gag/'.$post->slug) }}" class="sidebar-item">
    <?php
        if($post->is_gif) {
            $post->image = substr($post->image, 0 , strpos($post->image, '.gif')).'.png';
        }
    ?>
    <img class="img-responsive" src="{{ url('img/posts/300/'.$post->image) }}" alt="">
    <p>{{ $post->title }}</p>
</a>
@endforeach
