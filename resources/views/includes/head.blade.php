@include('includes.meta-data')
@if (!isset($posts) && isset($post->title))
  <title>{{ $post->title }} - 9Laravel</title>
@else
  <title>9Laravel - Go Code Something Awesome</title>
@endif
<link rel="stylesheet" href="{{ elixir('css/app.css') }}">
<script>
  window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
          'baseUrl' => url('/')
        ]) !!};

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken } });
</script>
