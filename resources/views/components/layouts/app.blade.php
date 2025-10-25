<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') . ' | ' . Request::segment(1) }}</title>
    @include('components.layouts.styles')
    @stack('css')

</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @livewire('components.sidebar')
            <div class="sidebar-overlay"></div>
            <div class="layout-page">
                @include('components.layouts.navbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                </div>
                <div class="content-backdrop fade"></div>
                @include('components.layouts.footer')
            </div>
        </div>
    </div>

    @include('components.layouts.scripts')
    @stack('js')
</body>

</html>
