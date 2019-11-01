<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
    </head>
    <body>
        <div id="app">
            <main-app></main-app>
        </div>

        <script src=" {{ asset('js/app.js') }} "></script>

        <script>
            
            $('.js-scroll-trigger').click(function() {
                $('.navbar-collapse').collapse('hide');
            });
        </script>
    </body>
</html>
