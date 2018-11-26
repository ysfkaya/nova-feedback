<span class="text-left">
    @if($user = $resource->last_reply_user)
        <a href="{{ url(config('nova.path')).'/resources/users/'.$user->id }}"
           class="no-underline dim text-primary font-bold">
                {{ $user->name }}
        </a>
    @else
        <span>&mdash;</span>
    @endif
</span>