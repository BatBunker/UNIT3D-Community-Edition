<nav class="py-4 brightness-150 bg-[rgb(0,0,0,.5)]">
    <div class="px-2 container_v2 mx-auto">
        <div class="grid grid-cols-3 gap-x-2">
            <ul class="col-span-2 flex justify-start gap-x-8">
                <li title="{{ __('common.ratio') }}">
                    <i class="{{ config('other.font-awesome') }} fa-sync-alt text-blue-600"></i>
                    {{ auth()->user()->getRatioString() }}
                </li>
                <li title="{{ __('common.upload') }}">
                    <a href="{{ route('user_uploads', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-up text-green-600"></i>
                        {{ auth()->user()->getUploaded() }}
                    </a>
                </li>
                <li title="{{ __('common.download') }}">
                    <a href="{{ route('user_torrents', ['username' => auth()->user()->username, 'downloaded' => 'include']) }}">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-down text-red-600"></i>
                        {{ auth()->user()->getDownloaded() }}
                    </a>
                </li>
                <li title="{{ __('torrent.seeding') }}">
                    <a href="{{ route('user_active', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-upload text-green-500"></i>
                        {{ auth()->user()->seedingTorrents()->count() }}
                    </a>
                </li>
                <li title="{{ __('torrent.leeching') }}">
                    <a href="{{ route('user_torrents', ['username' => auth()->user()->username, 'unsatisfied' => 'include']) }}">
                        <i class="{{ config('other.font-awesome') }} fa-download text-red-600"></i>
                        {{ auth()->user()->leechingTorrents()->count() }}
                    </a>
                </li>
                <li title="{{ __('common.buffer') }}">
                    <a href="{{ route('user_torrents', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-exchange text-blue-600"></i>
                        {{ auth()->user()->untilRatio(config('other.ratio')) }}
                    </a>
                </li>
                <li title="{{ __('user.my-bonus-points') }}">
                    <a href="{{ route('earnings.index', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-coins text-amber-400"></i>
                        {{ auth()->user()->getSeedbonus() }}
                    </a>
                </li>
                <li title="{{ __('common.ratio') }}">
                    <a href="{{ route('user_torrents', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-sync-alt text-blue-500"></i>
                        {{ auth()->user()->getRatioString() }}
                    </a>
                </li>
                <li title="{{ __('user.my-fl-tokens') }}">
                    <a href="{{ route('users.show', ['username' => auth()->user()->username]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-star text-amber-400"></i>
                        {{ auth()->user()->fl_tokens }}
                    </a>
                </li>
            </ul>
            <ul class="flex justify-end gap-x-8">
                <li>
                    <a style="color:{{ auth()->user()->group->color }}; background-image:{{ auth()->user()->group->effect }};"
                       class="text-bold"
                       href="{{ route('users.show', ['username' => auth()->user()->username]) }}">
                        {{auth()->user()->username}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_settings', ['username' => auth()->user()->username]) }}"
                       title="{{ __('user.my-settings') }}">
                        <i class="{{ config('other.font-awesome') }} fa-cogs text-sky-500"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_privacy', ['username' => auth()->user()->username]) }}"
                       title=" {{ __('user.my-privacy') }}">
                        <i class="{{ config('other.font-awesome') }} fa-eye text-green-700"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_security', ['username' => auth()->user()->username]) }}"
                       title=" {{ __('user.my-security') }}">
                        <i class="{{ config('other.font-awesome') }} fa-shield-alt text-red-600"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('achievements.index') }}" title=" My {{ __('user.achievements') }}">
                        <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_uploads', ['username' => auth()->user()->username]) }}"
                       title="{{ __('user.my-uploads') }}">
                        <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_requested', ['username' => auth()->user()->username]) }}"
                       title=" {{ __('user.my-requested') }}">
                        <i class="{{ config('other.font-awesome') }} fa-question"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('torrents', ['bookmarked' => 1]) }}" title="  {{ __('user.my-bookmarks') }}">
                        <i class="{{ config('other.font-awesome') }} fa-bookmark"></i>

                    </a>
                </li>
                <li>
                    <a href="{{ route('wishes.index', ['username' => auth()->user()->username]) }}"
                       title="{{ __('user.my-wishlist') }}">
                        <i class="{{ config('other.font-awesome') }} fa-clipboard-list"></i>
                    </a>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ route('logout') }}" title="{{ __('auth.logout') }}">
                        @csrf
                        <button class="top-nav--right__link" type="submit">
                            {{ __('auth.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<nav class="py-8 bg-[rgb(0,0,0,.3)]">
    <div class="px-2 container_v2 mx-auto">
        <div class="grid grid-cols-2">
            <div>
                <a href="{{ route('home.index') }}">
                    <img src="{{asset('logo.png')}}" class="animate-pulse" loading="lazy" alt="Site logo">
                </a>
            </div>
            <div class="flex items-center justify-end gap-9">
                <div class="w-1/2 flex justify-end ">
                    <ul class="flex text-zinc-300 w-full justify-end gap-x-7 ">
                        @if (auth()->user()->group->is_modo)
                            <li>
                                <a class="" href="{{ route('staff.dashboard.index') }}"
                                   title="{{ __('staff.staff-dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="w-10 h-10">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L12 12m6.894 5.785l-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864l-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495"/>
                                    </svg>

                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->group->is_modo)
                            <li>
                                <a class="relative" href="{{ route('staff.moderation.index') }}"
                                   title="{{ __('staff.torrent-moderation') }}">
                                    @if(auth()->user()->getUnModeratedTorrents() > 0)
                                        <span class="animate-ping absolute inline-flex rounded-full h-10 w-10 bg-sky-600"></span>
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="w-10 h-10">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>

                                </a>
                            </li>
                        @endif
                        <li>
                            @if(auth()->user()->getPrivateMessagesCount() > 0)
                                <span class="animate-ping absolute inline-flex rounded-full h-10 w-10 bg-sky-600"></span>
                            @endif
                            <a class="top-nav--right__icon-link relative" href="{{ route('inbox') }}"
                               title="{{ __('pm.inbox') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="top-nav--right__icon-link relative" href="{{ route('notifications.index') }}"
                               title="{{ __('user.notifications') }}">
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="animate-ping absolute inline-flex rounded-full h-10 w-10 bg-sky-600 "></span>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="top-nav--right__icon-link relative" href="{{ route('rss.index') }}"
                               title="{{ __('rss.rss') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12.75 19.5v-.75a7.5 7.5 0 00-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="top-nav--right__icon-link relative"
                               href="{{ route('upload_form', ['category_id' => 1]) }}"
                               title="{ __('common.upload') }}">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15"/>
                                </svg>

                            </a>
                        </li>
                    </ul>
                </div>
                <hr style="width: 1px" class="bg-white h-10 ">
                <div class="w-1/2">
                    <livewire:quick-search-dropdown/>
                </div>
            </div>
        </div>
    </div>
</nav>
@if(config('donation.enabled'))
    @include('donations.progress')
@endif

<nav class=" py-2 bg-[rgb(0,0,0,.4)]">
    <div class="container_v2 mx-auto">
        <ul class="flex justify-center gap-x-[2.48rem]">
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>

                    Home
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{route('torrents')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"/>
                    </svg>
                    {{ __('torrent.torrents') }}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{route('graveyard.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-red-800 mx-auto font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>

                    Dying
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('cards') . '?categories[0]=1'}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5"/>
                    </svg>
                    {{ __('mediahub.movies') }}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('cards') . '?categories[0]=2'}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z"/>
                    </svg>
                    Tv
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('cards') . '?categories[0]=3'}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-center mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
                    </svg>
                    Music
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('top10.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                    </svg>

                    Top 10
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('requests.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-center mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122"/>
                    </svg>

                    {{__('request.requests')}}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('forums.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-center mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                    </svg>

                    {{ __('common.community') }}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('playlists.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"/>
                    </svg>

                    {{ __('playlist.playlists') }}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center relative ">
                <a href="{{ route('tickets.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="w-12 h-12 mx-auto @if(auth()->user()->getTicketsCount() > 0) animate-pulse text-sky-600 @endif">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796a3.765 3.765 0 00-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 01-1.388.88m2.268-2.268l4.138 3.448m0 0a9.027 9.027 0 01-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0l-3.448-4.138m3.448 4.138a9.014 9.014 0 01-9.424 0m5.976-4.138a3.765 3.765 0 01-2.528 0m0 0a3.736 3.736 0 01-1.388-.88 3.737 3.737 0 01-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 01-1.652-1.306 9.027 9.027 0 01-1.306-1.652m0 0l4.138-3.448M4.33 16.712a9.014 9.014 0 010-9.424m4.138 5.976a3.765 3.765 0 010-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 011.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 00-1.652 1.306A9.025 9.025 0 004.33 7.288"/>
                    </svg>
                    {{ __('ticket.helpdesk') }}
                </a>
            </li>
            {{--        <li class="hover:bg-[#262626] p-2 text-center">--}}
            {{--            <a href="{{ route('upload_form', ['category_id' => 1]) }}">--}}
            {{--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
            {{--                     stroke="currentColor" class="w-12 h-12 mx-auto">--}}
            {{--                    <path stroke-linecap="round" stroke-linejoin="round"--}}
            {{--                          d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15"/>--}}
            {{--                </svg>--}}
            {{--                {{ __('common.upload') }}--}}
            {{--            </a>--}}
            {{--        </li>--}}
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('pages.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>

                    Wiki
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('pages.show', ['slug' => \config('other.rules_slug_name')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 mx-auto text-[#b69255]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                    {{ __('common.rules') }}
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center" title="{{ __('torrent.leeching') }}">
                <a href="{{ route('user_torrents', ['username' => auth()->user()->username, 'unsatisfied' => 'include']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12 text-red-800 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                    H&R
                </a>
            </li>
            <li class="hover:bg-[#262626] p-2 text-center">
                <a href="{{ route('pages.show', ['slug' => \config('other.donation_slug_name')]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 mx-auto text-red-500 outline-2
                 outline-black">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                    </svg>
                    Donate
                </a>
            </li>
        </ul>
    </div>
</nav>



