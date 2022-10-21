@php
    $artWork = $user->personal_artwork !== null ? url('files/covers/' . $user->personal_artwork)  : '/img/default_featured.jpg';
@endphp
<section class="user-header" style="background-image: url({{$artWork}})">
    <div class="user-header__container">
        <div class="user-header__avatar">
            @if ($user->image != null)
                <img src="{{ url('files/img/' . $user->image) }}" alt="{{ $user->username }}" loading="lazy">
            @else
                <img src="{{ url('img/profile.png') }}" alt="{{ $user->username }}" loading="lazy">
            @endif
        </div>
        <div class="user-header__info">
            <div class="user-header__info-top">
                <div>
                    <h2>{{ $user->username }}</h2>
                    @if ($user->isOnline())
                        <span>
                        <i class="{{ config('other.font-awesome') }} fa-circle text-green"
                           title="{{ __('user.online') }}">
                    </i>
                  </span>
                    @else
                        <span>
                       <i class="{{ config('other.font-awesome') }} fa-circle text-red" title="{{ __('user.offline') }}"></i>
                        </span>
                    @endif
                    <span>
                    <a href="{{ route('create', ['receiver_id' => $user->id, 'username' => $user->username]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-envelope text-info"></i>
                </a>
                </span>
                    <span>
                    <a href="#modal_user_gift" data-toggle="modal"
                       data-target="#modal_user_gift">
                    <i class="{{ config('other.font-awesome') }} fa-gift text-info"></i>
                </a>
               </span>
                    @if ($user->getWarning() > 0)
                        <span>
                        <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-orange"
                           aria-hidden="true"
                           title="{{ __('user.active-warning') }}">
                    </i>
                  </span>
                    @endif
                    @if ($user->notes->count() > 0 && auth()->user()->group->is_modo)
                        <span>
                        <a href="{{ route('user_setting', ['username' => $user->username]) }}"
                           class="edit">
                        <i class="{{ config('other.font-awesome') }} fa-comment fa-beat text-danger"
                           aria-hidden="true"
                           title="{{ __('user.staff-noted') }}">
                        </i>
                    </a>
                   </span>
                    @endif
                    @php $watched = App\Models\Watchlist::whereUserId($user->id)->first(); @endphp
                    @if ($watched && auth()->user()->group->is_modo)
                        <span>
                        <i class="{{ config('other.font-awesome') }} fa-eye fa-beat text-danger"
                           aria-hidden="true" d
                           title="User is being watched!">
                    </i>
                  </span>
                    @endif
                </div>
                <div>
                    @if(!empty($user->title))
                        <span class="badge-extra">{{ $user->title }}</span>
                    @endif
                    <span class="badge-extra text-bold"
                          style="color:{{ $user->group->color }}!important; background-image:{{ $user->group->effect }};">
                {{ $user->group->name }}
            </span>
                    <span class="badge-extra"> Joined: {{ $user->created_at === null ? "N/A" : date('M d Y', $user->created_at->getTimestamp()) }}</span>
                </div>
            </div>
            <div class="user-header__achievements">
                @php
                    $x=1;
                @endphp
                @foreach ($achievements as $achievement)
                    @php
                        if($x > 15) { continue; }
                    @endphp
                    <img loading="lazy" src="/img/badges/{{ $achievement->details->name }}.png"
                         height="40px" title="{{ $achievement->details->name }}"
                         alt="{{ $achievement->details->name }}">
                    @php
                        $x++;
                    @endphp
                @endforeach
            </div>
            <div class="user-header__staff-buttons">
                <div>
                        <span class="badge-extra"><i
                                    class="{{ config('other.font-awesome') }} fa-upload"></i> {{ __('user.total-uploads') }}
                                : <span class="text-green text-bold">{{ $user->torrents_count }}</span></span>
                    <span class="badge-extra "><i
                                class="{{ config('other.font-awesome') }} fa-download"></i> {{ __('user.total-downloads') }}
                                        : <span
                                class="text-red text-bold">{{ $history->where('actual_downloaded', '>', 0)->count() }}</span></span>
                    <span class="badge-extra"><i
                                class="{{ config('other.font-awesome') }} fa-cloud-upload"></i> {{ __('user.total-seeding') }}
                                        : <span class="text-green text-bold">{{ $user->getSeeding() }}</span></span>
                    <span class="badge-extra"><i
                                class="{{ config('other.font-awesome') }} fa-cloud-download"></i> {{ __('user.total-leeching') }}
                                        : <span class="text-red text-bold">{{ $user->getLeeching() }}</span></span>
                </div>
                @if (auth()->user()->id != $user->id)
                    @if (auth()->user()->group->is_modo)
                        <div>
                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                    data-target="#modal_warn_user">
                                <span class="{{ config('other.font-awesome') }} fa-radiation-alt"></span>
                                Warn User
                            </button>
                            <button class="btn btn-xs btn-warning" data-toggle="modal"
                                    data-target="#modal_user_note"><span
                                        class="{{ config('other.font-awesome') }} fa-sticky-note"></span>
                                {{ __('user.note') }}
                            </button>
                            @if(! $watched)
                                <button class="btn btn-xs btn-danger" data-toggle="modal"
                                        data-target="#modal_user_watch">
                                    <span class="{{ config('other.font-awesome') }} fa-eye"></span>
                                    Watch
                                </button>
                            @else
                                <form style="display: inline;"
                                      action="{{ route('staff.watchlist.destroy', ['id' => $watched->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-warning" type="submit">
                                        <i class="{{ config('other.font-awesome') }} fa-eye-slash"></i> Unwatch
                                    </button>
                                </form>
                            @endif
                            @if ($user->group->id == 5)
                                <button class="btn btn-xs btn-warning" data-toggle="modal"
                                        data-target="#modal_user_unban"><span
                                            class="{{ config('other.font-awesome') }} fa-undo"></span> {{ __('user.unban') }}
                                </button>
                            @else
                                <button class="btn btn-xs btn-danger" data-toggle="modal"
                                        data-target="#modal_user_ban"><span
                                            class="{{ config('other.font-awesome') }} fa-ban"></span> {{ __('user.ban') }}
                                </button>
                            @endif
                            <a href="{{ route('user_setting', ['username' => $user->username]) }}"
                               class="btn btn-xs btn-warning"><span
                                        class="{{ config('other.font-awesome') }} fa-pencil"></span> {{ __('user.edit') }}
                            </a>
                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                    data-target="#modal_user_delete"><span
                                        class="{{ config('other.font-awesome') }} fa-trash"></span> {{ __('user.delete') }}
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>


















