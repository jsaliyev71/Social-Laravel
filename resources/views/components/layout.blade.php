@props([
    'title' => 'Social Network - Course Project'
])

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>

        <link rel="stylesheet" href="{{ asset('css/body.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layouts/aside.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/alerts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/forms.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/parts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages/community.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body data-theme="{{ auth()->user()->userSettings->theme ?? 'light' }}">
        <div id="body">
            @include('layouts.header')

            <div id="main">
                {{ $slot }}

                @include('components.alerts')
            </div>

            @include('layouts.footer')
        </div>


        <script src="{{ asset('js/post.js') }}"></script>
        <script src="{{ asset('js/settings.js') }}"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>
        <script src="{{ asset('js/formAction.js') }}"></script>
        <script src="{{ asset('js/domUpdate.js') }}"></script>

        <script src="{{ asset('js/components/dropdown.js') }}"></script>
    </body>
</html>


