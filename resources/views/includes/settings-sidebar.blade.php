<ul class="nav nav-pills nav-stacked">
    <li role="presentation" @if($request->is('settings/account') || $request->is('settings')) class="active" @endif >
        <a href="{{ url('settings/account') }}">Account</a>
    </li>
    <li role="presentation" @if($request->is('settings/password')) class="active" @endif >
        <a href="{{ url('settings/password') }}">Password</a>
    </li>
    <li role="presentation" @if($request->is('settings/profile')) class="active" @endif >
        <a href="{{ url('settings/profile') }}">Profile</a>
    </li>
    <li role="presentation" @if( $request->is('categories/*') || $request->is('categories')) class="active" @endif >
        <a href="{{ url('categories') }}">Categories</a>
    </li>
</ul>
