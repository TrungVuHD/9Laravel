<ul class="nav nav-pills nav-stacked">
    <li role="presentation" @if(active_route('settings/account') || active_route('settings')) class="active" @endif >
        <a href="{{ url('settings/account') }}">Account</a>
    </li>
    <li role="presentation" @if(active_route('settings/password')) class="active" @endif >
        <a href="{{ url('settings/password') }}">Password</a>
    </li>
    <li role="presentation" @if(active_route('settings/profile')) class="active" @endif >
        <a href="{{ url('settings/profile') }}">Profile</a>
    </li>
    <li role="presentation" @if(active_route('settings/categories/*') || active_route('settings/categories')) class="active" @endif >
        <a href="{{ url('settings/categories') }}">Categories</a>
    </li>
</ul>
