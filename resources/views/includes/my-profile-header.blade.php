@if( $request->is('my-profile/*') || $request->is('my-profile') )
<div class="my-profile-header">
    <div class="top">
        <img class="profile-image" src="{{ url('/img/avatars/'.$user->avatar_image) }}" alt="" />
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->description }}</p>
    </div>
    <div class="bottom container">
        <div class="row">
            <div class="col-sm-16 col-sm-offset-4 text-left">
                <a href="{{ url('my-profile') }}" class="profile-category-link @if( $request->is('my-profile')) active @endif">Overview</a>
                <a href="{{ url('my-profile/posts') }}" class="profile-category-link @if( $request->is('my-profile/posts') ) active @endif">Posts</a>
                <a href="{{ url('my-profile/upvotes') }}" class="profile-category-link @if( $request->is('my-profile/upvotes') ) active @endif">Upvotes</a>
                <a href="{{ url('my-profile/comments') }}" class="profile-category-link @if( $request->is('my-profile/comments') ) active @endif">Comments</a>
            </div>
        </div>
    </div>
</div>
@endif
