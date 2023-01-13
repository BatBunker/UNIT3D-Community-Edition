<div class="panel panel-chat shoutbox torrent-general" x-data="{ show: false }">
    <div class="panel-heading">
        <h4>
            <i class="{{ config("other.font-awesome") }} fa-heart text-pink-500"></i> Thanked By
        </h4>
    </div>
    <div class="panel-body">
        @foreach( $torrent->thanks as $thanks )
            <a href="{{route('users.show',['username' => $thanks->user->username])}}">
                <span style="color:{{ $thanks->user->group->color }}; background-image:{{ $thanks->user->group->effect }}"
                      class="badge-extra">
                    <i class="{{ $thanks->user->group->icon }}"></i>
                    {{$thanks->user->username}}
                </span>
            </a>
        @endforeach
    </div>
</div>
