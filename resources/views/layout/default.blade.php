<!DOCTYPE html>
<html lang="{{ auth()->user()->locale }}">
<head>
    @include('partials.head')
</head>
<body>
<header>
    @include('partials.top_nav')
    @if (! Route::is('home.index'))
        <nav class="secondary-nav py-2 bg-[rgb(0,0,0,.2)]">
            <div class="container_v2 mx-auto ">
                <ul class="nav-tabsV2 mx-auto justify-center">
                    @yield('nav-tabs')
                </ul>
            </div>
        </nav>
    @endif
    @include('partials.alerts')
    @if (Session::has('achievement'))
        @include('partials.achievement_modal')
    @endif
    @if ($errors->any())
        <div id="ERROR_COPY" style="display: none;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
</header>
<main class="@yield('page')">
    @hasSection('main')
        @hasSection('sidebar')
            <article class="sidebar2">
                <div>
                    @yield('main')
                </div>
                <aside>
                    @yield('sidebar')
                </aside>
            </article>
        @else
            <article>
                @yield('main')
            </article>
        @endif
    @else
        <article>
            @yield('content')
        </article>
    @endif
</main>
@include('cookie-consent::index')
@include('partials.footer')
@vite(['resources/js/app.js','resources/js/unit3d/tmdb.js','resources/js/unit3d/parser.js','resources/js/unit3d/helper.js','resources/js/vendor/alpine.js','resources/js/vendor/virtual-select.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.all.min.js"
        nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}"></script>

@if (config('other.freeleech') == true || config('other.invite-only') == false || config('other.doubleup') == true)
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">
        function timer() {
            return {
                seconds: '00',
                minutes: '00',
                hours: '00',
                days: '00',
                distance: 0,
                countdown: null,
                promoTime: new Date('{{ config('other.freeleech_until') }}').getTime(),
                now: new Date().getTime(),
                start: function () {
                    this.countdown = setInterval(() => {
                        // Calculate time
                        this.now = new Date().getTime()
                        this.distance = this.promoTime - this.now
                        // Set Times
                        this.days = this.padNum(Math.floor(this.distance / (1000 * 60 * 60 * 24)))
                        this.hours = this.padNum(Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)))
                        this.minutes = this.padNum(Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60)))
                        this.seconds = this.padNum(Math.floor((this.distance % (1000 * 60)) / 1000))
                        // Stop
                        if (this.distance < 0) {
                            clearInterval(this.countdown)
                            this.days = '00'
                            this.hours = '00'
                            this.minutes = '00'
                            this.seconds = '00'
                        }
                    }, 100)
                },
                padNum: function (num) {
                    var zero = ''
                    for (var i = 0; i < 2; i++) {
                        zero += '0'
                    }
                    return (zero + num).slice(-2)
                }
            }
        }
    </script>
@endif

@if (Session::has('achievement'))
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}" defer>
        $('#modal-achievement').modal('show')
    </script>
@endif

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
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}" defer>
        Swal.fire({
            title: '<strong style=" color: rgb(17,17,17);">Error</strong>',
            icon: 'error',
            html: document.getElementById("ERROR_COPY").innerHTML,
            showCloseButton: true,
            willOpen: (el) => {
                el.querySelectorAll('textarea').forEach(textarea => textarea.remove());
            }
        })

    </script>
@endif

<script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}" defer>
    window.addEventListener('success', event => {
        if (event.detail !== undefined) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })

            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        }

    })
</script>

<script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}" defer>
    window.addEventListener('error', event => {
        if (event.detail !== undefined) {
            Swal.fire({
                title: '<strong style=" color: rgb(17,17,17);">Error</strong>',
                icon: 'error',
                html: event.detail.message,
                showCloseButton: true,
            })
        }
    })
</script>

@yield('javascripts')
@yield('scripts')
@livewireScripts(['nonce' => HDVinnie\SecureHeaders\SecureHeaders::nonce()])

<script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}" defer>
    Livewire.on('paginationChanged', () => {
        window.scrollTo({
            top: 15,
            left: 15,
            behaviour: 'smooth'
        })
    })
</script>
</body>
</html>
