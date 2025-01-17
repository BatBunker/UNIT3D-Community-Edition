
<div style="border-bottom: var(--app-border-light-color) solid 1px" class="flex gap-3 items-center p-2">
    @if (auth()->user()->id == $uploader['user_id'] || auth()->user()->group->is_modo == 1)
        <a style="color:{{ $uploader['user']['group']['color'] }}; background-image:{{ $uploader['user']['group']['effect'] }};"
           href="{{ route('users.show', ['username' =>  $uploader['user']['username']]) }}"
           class="font-bold badge-user flex-1">
            {{  $uploader['user']['username'] }}
        </a>
    @else
        <span class="font-bold badge-user">
               <i class="{{ config('other.font-awesome') }} fa-eye-slash" aria-hidden="true"></i>
               {{ strtoupper(__('common.hidden')) }}
       </span>
    @endif
    <span class="text-green-500">{{ $uploader['current_value'] }} / {{ $uploader['past_value'] }}  </span>
</div>