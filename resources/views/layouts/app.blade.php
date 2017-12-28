<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.head')
</head>
<body>
  <div class="container-fluid">
    @include('includes.top-menu')
  </div>
  @include('includes.alert')
  @include('includes.my-profile-header')
  <div class="container page-container">
    <div class="row">
      <div id="content" class="col-sm-18">
        @yield('content')
      </div>
      <div class="col-sm-6">
        @yield('sidebar')
      </div>
    </div>
  </div>
  @include('includes.modals')
  @include('includes.scripts')
</body>
</html>
