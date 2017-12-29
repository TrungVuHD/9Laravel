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
  <div class="container page-container">
    <div class="row">
      <div id="content" class="col-xs-24">
        @yield('content')
      </div>
    </div>
  </div>
  @include('includes.modals')
  @include('includes.scripts')
</body>
</html>
