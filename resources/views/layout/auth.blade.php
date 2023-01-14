<!DOCTYPE html>
<html class="dark" lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>{{ page_title(config('other.title')) }}</title>
    @show
    @section('meta')
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="referrer" content="no-referrer"/>
        <meta name="referrer" content="same-origin"/>
        <meta name="robots" content="noindex"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!---Light mode is not fully ready-->
        <meta name="color-scheme" content="dark">
    @show
    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    @vite('resources/sass/main/auth.scss')
    @if(config('other.auth-backdrop'))
        <style>
            :where(body):before {
                content: "";
                position: absolute;
                z-index: -1;
                height: 100%;
                width: 100%;
                filter: blur(10px) brightness(.5);
                /* background shorthand will not work here */
                background: var(--body-background-image);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center center;
                background-attachment: fixed;

            }
        </style>
    @endif
</head>
<body class="auth-bg bg-neutral-200 dark:bg-neutral-900 w-full h-screen leading-loose">
<main class="container grid place-items-center mx-auto h-full">
    @if ($errors->any())
        <div id="ERROR_COPY" style="display: none;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
@vite('resources/js/unit3d/public.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.all.min.js" nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}"></script>
@foreach (['warning', 'success', 'info'] as $key)
    @if (Session::has($key))
        <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })

            Toast.fire({
                icon: '{{ $key }}',
                title: '{{ Session::get($key) }}'
            })

        </script>
    @endif
@endforeach

@if (Session::has('errors'))
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">
        Swal.fire({
            title: '<strong style=" color: rgb(17,17,17);">Error</strong>',
            icon: 'error',
            html: document.getElementById("ERROR_COPY").innerHTML,
            showCloseButton: true,
            heightAuto: false
        })
    </script>
@endif
@if(config('other.auth-backdrop') !== '')
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">

        const setBackground = (value) => {
            document.addEventListener('DOMContentLoaded', () => {
                document.documentElement.style.setProperty('--body-background-image', `url(${value})`);
            });
        }
        setBackground('{{config('other.auth-backdrop')}}')
    </script>
@endif
@yield('scripts')
</body>
</html>