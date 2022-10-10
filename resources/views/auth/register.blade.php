@extends('layout.auth')
@section('title')
    <html lang="{{ config('app.locale') }}">
    @endsection

@section('content')
        @if (config('other.invite-only') == true && !$code)
            <div class="dark:text-white text-neutral-900 text-center p-2">
                <h1 class="text-3xl font-bold">{{ __('auth.need-invite') }}</h1>
            </div>
        @else
            <div class="max-w-lg p-3">
                <form class="flex flex-col gap-3" role="form" method="POST" action="{{ route('register', ['code' => $code]) }}">
                    <!--Hidden Stuff-->
                    <div class="h-0">
                        @csrf
                        @if (config('captcha.enabled') === true)
                            @hiddencaptcha
                        @endif
                    </div>
                    <!--Logo-->
                    <div class="flex flex-col">
                        <div class="flex relative">
                            <img class="text-center w-full align-center animate-pulse"
                                 src="{{asset('/logo.png')}}"
                                 loading="lazy"
                                 fetchpriority="high"
                                 alt="Logo of {{ config('app.name') }}">

                        </div>
                    </div>
                    <!--Username-->
                    <div class="flex flex-col">
                        <div class="flex relative">
                         <span class="inline-flex items-center px-3 border-t bg-white border-l border-b border-neutral-400 text-neutral-700 text-sm">
                          <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                              <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                         </span>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="appearance-none border border-neutral-400 w-full py-2 px-4 bg-white text-neutral-700 placeholder-neutral-600 text-base focus:outline-none focus:ring-2 focus:border-transparent"
                                   value="{{ old('username') }}"
                                   placeholder="{{ __('auth.username') }}"
                                   required
                                   autofocus
                            />
                        </div>
                    </div>
                    <!--Email-->
                    <div class="flex flex-col">
                        <div class="flex relative">
                    <span class="inline-flex items-center px-3 border-t bg-white border-l border-b border-neutral-400 text-neutral-700 text-sm">
                            <svg width="15"
                                 height="15"
                                 fill="currentColor"
                                 viewBox="0 0 1792 1792"
                                 xmlns="http://www.w3.org/2000/svg">
                               <path d="M1792 710v794q0 66-47 113t-113 47h-1472q-66 0-113-47t-47-113v-794q44 49 101 87 362 246 497 345 57 42 92.5 65.5t94.5 48 110 24.5h2q51 0 110-24.5t94.5-48 92.5-65.5q170-123 498-345 57-39 100-87zm0-294q0 79-49 151t-122 123q-376 261-468 325-10 7-42.5 30.5t-54 38-52 32.5-57.5 27-50 9h-2q-23 0-50-9t-57.5-27-52-32.5-54-38-42.5-30.5q-91-64-262-182.5t-205-142.5q-62-42-117-115.5t-55-136.5q0-78 41.5-130t118.5-52h1472q65 0 112.5 47t47.5 113z">
                               </path>
                            </svg>
                         </span>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="appearance-none border border-neutral-400 w-full py-2 px-4 bg-white text-neutral-700 placeholder-neutral-600 text-base focus:outline-none focus:ring-2 focus:border-transparent"
                                   placeholder="{{ __('auth.email') }}"
                                   required
                            />
                        </div>
                    </div>
                    <!--Password-->
                    <div class="flex flex-col">
                        <div class="flex relative">
                <span class="inline-flex items-center px-3 border-t bg-white border-l border-b border-neutral-400 text-neutral-700 text-sm">
                    <svg width="15"
                         height="15"
                         fill="currentColor"
                         viewBox="0 0 1792 1792"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M1376 768q40 0 68 28t28 68v576q0 40-28 68t-68 28h-960q-40 0-68-28t-28-68v-576q0-40 28-68t68-28h32v-320q0-185 131.5-316.5t316.5-131.5 316.5 131.5 131.5 316.5q0 26-19 45t-45 19h-64q-26 0-45-19t-19-45q0-106-75-181t-181-75-181 75-75 181v320h736z">
                        </path>
                    </svg>
                </span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="appearance-none border border-neutral-400 w-full py-2 px-4 bg-white text-neutral-700 placeholder-neutral-600 text-base focus:outline-none focus:ring-2 focus:border-transparent"
                                   placeholder="{{ __('auth.password') }}"
                                   required
                            />
                        </div>
                    </div>
                    <button type="submit"
                            id="login-button"
                            class="w-full px-4 py-2 text-base font-semibold text-center text-white transition duration-200 ease-in bg-black hover:text-black hover:bg-white focus:outline-none focus:ring-2">
                   <span class="w-full">
                   {{ __('auth.signup') }}
                   </span>
                    </button>
                </form>

                <!--User Resets-->
                <div class=" mt-3 flex flex-col items-center justify-between">
            <span class="text-sx text-center text-neutral-900 dark:text-white">
                Forgot Your:
                <a class="hover:underline" href="{{ route('password.request')}}">
                    Password
                </a>
                <span class="text-center">|</span>
                <a href="{{ route('username.request') }}">
                    Username ?
                </a>
            </span>
                </div>
            </div>
    @endif
    {{--  logic Missing  --}}
    {{--        @if (config('email-white-blacklist.enabled') == 'block')--}}
    {{--            <br>--}}
    {{--            <a href="{{ route('public.email') }}">--}}
    {{--                <h2 class="inactive underlineHover">{{ __('common.email-blacklist') }} </h2>--}}
    {{--            </a>--}}
    {{--        @elseif (config('email-white-blacklist.enabled') == 'allow')--}}
    {{--            <br>--}}
    {{--            <a href="{{ route('public.email') }}">--}}
    {{--                <h2 class="inactive underlineHover">{{ __('common.email-whitelist') }} </h2>--}}
    {{--            </a>--}}
    {{--    @endif--}}
@endsection