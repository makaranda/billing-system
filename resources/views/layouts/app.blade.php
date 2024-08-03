<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>GIL REMINDERS</title>
        @include('libraries.app.styles')
        @stack('css')
    </head>
  <body>
        @include('components.nav')
        <div id="overlay" style="display: block;">
            <div class="loader"></div>
        </div>
        @yield('content')

        @include('components.footer')
        @include('libraries.app.scripts')
        @stack('scripts')
  </body>
</html>
